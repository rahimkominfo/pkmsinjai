# MEKANISME DOMAIN CUSTOM (MULTI-TENANT)

Dokumen ini menjelaskan mekanisme teknis untuk mengganti pola URL default `[base_url]/(:segment)` menjadi penggunaan nama domain kustom (misal: `puskesmas-panaikang.id` atau `panaikang.pkmsinjai.test`).

## 1. Perubahan Database
Tambahkan kolom `pkm_domain` pada tabel `mst_pkm` untuk menyimpan mapping domain setiap tenant.

```sql
ALTER TABLE mst_pkm ADD COLUMN pkm_domain VARCHAR(255) UNIQUE AFTER pkm_slug;
```

## 2. Konfigurasi Aplikasi (`app/Config/App.php`)
Agar CodeIgniter 4 menerima request dari berbagai domain, pastikan `allowedHostnames` dikonfigurasi. Untuk fleksibilitas tinggi (wildcard/multi-domain), kita bisa membacanya dari database atau mengizinkan semua host jika berada di balik reverse proxy yang aman.

```php
// app/Config/App.php
public array $allowedHostnames = []; // Bisa diisi list domain manual atau dikosongkan jika ditangani Filter
```

## 3. Modifikasi Tenant Filter (`app/Filters/TenantFilter.php`)
Ubah logika pendeteksian dari **Segment URL** menjadi **Hostname**.

```php
// app/Filters/TenantFilter.php

public function before(RequestInterface $request, $arguments = null)
{
    helper('tenant');
    $hostname = $request->getUri()->getHost();
    $pkmModel = new \App\Models\PkmModel();

    // 1. Cek apakah hostname adalah domain utama portal (misal: pkmsinjai.test)
    $mainDomain = parse_url(base_url(), PHP_URL_HOST);
    
    if ($hostname === $mainDomain) {
        // Jika di domain utama, cek apakah ada segment (fallback mode)
        $slug = $request->getUri()->getSegment(1);
        if (empty($slug) || $slug === 'admin') return;

        $pkm = $pkmModel->where('pkm_slug', $slug)->first();
    } else {
        // 2. Jika bukan domain utama, cari berdasarkan kolom pkm_domain
        $pkm = $pkmModel->where('pkm_domain', $hostname)->first();
    }

    if (!$pkm) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant/Domain tidak terdaftar.');
    }

    set_tenant($pkm);
}
```

## 4. Penyesuaian Helper (`app/Helpers/tenant_helper.php`)
Pastikan fungsi `base_url()` tetap menghasilkan link yang benar sesuai domain yang sedang aktif.

```php
// app/Helpers/tenant_helper.php

if (!function_exists('tenant_url')) {
    function tenant_url($path = '') {
        $tenant = get_tenant(); // Mengambil data tenant dari session/global state
        if ($tenant && !empty($tenant['pkm_domain'])) {
            return "http://" . $tenant['pkm_domain'] . "/" . ltrim($path, '/');
        }
        return base_url($tenant['pkm_slug'] . "/" . ltrim($path, '/'));
    }
}
```

## 5. Implementasi Routing (`app/Config/Routes.php`)
Gunakan Group Routing untuk memisahkan logika Portal Utama dan Tenant.

```php
// app/Config/Routes.php

// Route khusus Domain Tenant
$routes->group('', ['filter' => 'tenant_filter'], function($routes) {
    $routes->get('/', 'Frontend\Home::index');
    $routes->get('artikel/(:any)', 'Frontend\Artikel::detail/$1');
    // ... route tenant lainnya
});
```

## 6. Contoh Penggunaan
| Nama PKM | Slug | Custom Domain | URL Akses |
| :--- | :--- | :--- | :--- |
| PKM Panaikang | `panaikang` | `panaikang.id` | `http://panaikang.id/` |
| PKM Manipi | `manipi` | `manipi.pkmsinjai.test` | `http://manipi.pkmsinjai.test/` |

## 7. Panduan Konfigurasi cPanel (Zone Editor & Aliases)

Untuk menghubungkan domain/subdomain kustom (misal: `pkm-mannanti.sinjaikab.go.id`) ke aplikasi utama Anda (`pkm.sinjaikab.go.id`), ikuti langkah berikut:

### A. Pengaturan DNS di Zone Editor
1. Login ke cPanel.
2. Cari menu **Zone Editor**.
3. Pilih domain utama (`sinjaikab.go.id`).
4. Klik **+ CNAME Record** (atau **Manage** > **Add Record**).
5. Isi data berikut:
   - **Name**: `pkm-mannanti.sinjaikab.go.id.`
   - **TTL**: `14400`
   - **Type**: `CNAME`
   - **Record**: `pkm.sinjaikab.go.id` (Arahkan ke domain utama aplikasi).
   *Jika menggunakan IP, gunakan Type **A Record** dan isi **Record** dengan IP Server.*

### B. Pengaturan Domain di cPanel (Aliases/Domains)
Agar server mengenali request dari domain baru dan mengarahkannya ke folder aplikasi yang sama:
1. Masuk ke menu **Domains** (atau **Aliases/Parked Domains** di versi cPanel lama).
2. Klik **Create A New Domain**.
3. Masukkan nama domain: `pkm-mannanti.sinjaikab.go.id`.
4. **PENTING**: Jangan centang "Share document root".
5. Isi **Document Root** dengan path yang **SAMA** dengan aplikasi utama Anda (misal: `public_html/pkm-portal/public`).
6. Klik **Submit**.

### C. Alur Kerja Sistem (Penyederhanaan)
- User akses: `pkm-mannanti.sinjaikab.go.id`
- Server (cPanel) mengarahkan request ke folder aplikasi yang sama dengan `pkm.sinjaikab.go.id`.
- CI4 `TenantFilter` mendeteksi hostname `pkm-mannanti.sinjaikab.go.id`.
- Aplikasi mencari di tabel `mst_pkm` kolom `pkm_domain` yang bernilai `pkm-mannanti.sinjaikab.go.id`.
- Aplikasi menyajikan data PKM Mannanti seolah-olah user mengakses `pkm.sinjaikab.go.id/all/pkm-mannanti`.

## 8. Integrasi dengan Aplikasi/Folder Lain di Server Produksi

Jika di server utama (`pkm.sinjaikab.go.id`) terdapat folder lain yang berisi aplikasi berbeda, sistem tidak akan bentrok karena mekanisme `.htaccess` default CodeIgniter:

### A. Prioritas Folder Fisik
File `.htaccess` di folder `public/` memiliki aturan:
```apache
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
```
Artinya:
- Jika URL mengarah ke **file asli** (seperti `.jpg`, `.pdf`), server akan langsung membukanya.
- Jika URL mengarah ke **folder asli** (misal: `/pkm.sinjaikab.go.id/aplikasi_lain/`), server akan masuk ke folder tersebut dan **tidak** memproses routing CI4.

### B. Strategi Isolasi via Document Root
Untuk memastikan domain kustom (tenant) tidak "melihat" folder aplikasi lain di domain utama:
1. **Struktur Folder Ideal**:
   ```text
   /public_html
   ├── /pkm-portal (Aplikasi Multi-tenant CI4)
   │   └── /public (Document Root)
   ├── /aplikasi_A (Aplikasi lain)
   └── /aplikasi_B (Aplikasi lain)
   ```
2. **Pengaturan Document Root di cPanel**:
   Arahkan domain `pkm-mannanti.sinjaikab.go.id` **langsung** ke path `/public_html/pkm-portal/public`.
   - Dengan ini, secara teknis domain tenant hanya bisa melihat file di dalam folder `public/` aplikasi multi-tenant.
   - Folder `/aplikasi_A` dan `/aplikasi_B` aman karena berada di luar (atas) dari Document Root domain tenant.

### C. Fallback vs Custom Domain
- **Akses Fallback**: `pkm.sinjaikab.go.id/all/pkm-mannanti` (Tetap berfungsi menggunakan segment).
- **Akses Custom Domain**: `pkm-mannanti.sinjaikab.go.id` (Berfungsi menggunakan Hostname detection).

---
**Catatan Penting:**
- Pastikan konfigurasi VHost (Apache/Nginx) sudah diarahkan ke root folder yang sama.
- Jika menggunakan HTTPS, pastikan SSL (Let's Encrypt) mendukung multi-domain atau Wildcard SSL.
