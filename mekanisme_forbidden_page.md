# Mekanisme & Analisis Error 403 Forbidden pada Edit Halaman

Dokumen ini menjelaskan penyebab dan solusi terkait munculnya pesan **403 Forbidden** saat mencoba menyimpan atau mengedit halaman statis (`admin/(:segment)/pages/edit/`) setelah aplikasi di-deploy ke cPanel.

## 1. Analisis Penyebab Utama

Munculnya error 403 Forbidden di lingkungan *shared hosting* (cPanel) biasanya disebabkan oleh tiga faktor utama berikut:

### A. ModSecurity (Penyebab Paling Umum)
ModSecurity adalah Web Application Firewall (WAF) yang aktif di hampir semua server cPanel. 
- **Mengapa Terjadi?**: Saat Anda mengedit halaman statis, Anda biasanya mengirimkan data berupa tag HTML (melalui CKEditor/Rich Text Editor). ModSecurity seringkali menganggap tag HTML dalam permintaan POST sebagai upaya serangan **XSS (Cross-Site Scripting)** atau **SQL Injection**.
- **Gejala**: Error muncul seketika saat tombol "Simpan" ditekan, sebelum request mencapai kode CodeIgniter Anda.

### B. Mismatch CSRF (Cross-Site Request Forgery)
CodeIgniter 4 memiliki fitur proteksi CSRF.
- **Mengapa Terjadi?**: Jika Anda berpindah laptop atau jaringan, session/cookie yang lama mungkin tidak valid atau terjadi ketidaksesuaian antara domain yang diakses dengan `baseURL` yang dikonfigurasi di `.env`.
- **Gejala**: Error biasanya disertai pesan "The action you requested is not allowed."

### C. Konfigurasi `app.baseURL` yang Salah
- **Mengapa Terjadi?**: Jika di `.env` atau `Config/App.php` Anda masih menggunakan `localhost` atau IP lama, maka pengiriman form (POST) akan dianggap sebagai *cross-domain request* yang tidak sah oleh browser atau server.

---

## 2. Mengapa di Laptop Anda Berjalan, Tapi di Laptop Lain Error?

Ini adalah fenomena umum dalam pengembangan web. Berikut adalah alasan teknis mengapa hal ini terjadi:

### A. Reputasi IP & Whitelisting Otomatis
Server cPanel sering dilengkapi dengan **CSF (ConfigServer Security & Firewall)**. Jika Anda sering login dan beraktivitas sebagai admin dari IP laptop Anda, firewall mungkin telah menandai IP Anda sebagai "aman" atau melakukan whitelisting sementara. Laptop lain dengan IP berbeda dianggap sebagai "pengunjung baru" yang harus melewati filter ModSecurity yang sangat ketat.

### B. State Browser & Cache Session
Laptop Anda mungkin memiliki session atau cookie yang sudah mapan (*established*) dari sesi sebelumnya. Saat laptop lain mencoba mengakses, ia memulai dari awal. Jika ada sedikit saja ketidaksesuaian pada `baseURL` (misal: Anda akses via `http` tapi laptop lain via `https`), maka token CSRF atau cookie session akan ditolak oleh server pada laptop baru tersebut, memicu 403.

### C. Perbedaan ISP/Jaringan
Kadang, ISP tertentu melakukan inspeksi paket data. Jika laptop lain menggunakan jaringan yang berbeda, payload POST yang berisi HTML (dari editor halaman) bisa saja mengalami *flagging* di tingkat proxy ISP atau firewall regional server sebelum sampai ke script aplikasi Anda.

### D. Pengaturan Browser (SameSite Cookie)
Browser modern memiliki aturan ketat terkait **SameSite Cookie**. Jika laptop Anda menggunakan browser versi lama atau memiliki pengaturan yang lebih longgar, cookie CSRF mungkin terkirim dengan lancar. Laptop baru dengan browser terupdate mungkin memblokir cookie tersebut jika `baseURL` dan `cookieDomain` di CodeIgniter tidak dikonfigurasi dengan presisi sesuai domain di cPanel.

---

## 3. Langkah-Langkah Solusi

### Solusi 1: Nonaktifkan/Whitelist ModSecurity (Prioritas Utama)
Jika masalahnya adalah ModSecurity, Anda memiliki dua cara:
1.  **Melalui cPanel**: 
    - Login ke cPanel.
    - Cari menu **ModSecurity**.
    - Matikan (Disable) ModSecurity untuk domain yang bersangkutan (Hanya disarankan untuk pengetesan).
2.  **Melalui .htaccess**:
    Tambahkan baris berikut di file `public/.htaccess` untuk mencoba mematikan rule tertentu (catatan: beberapa provider hosting melarang ini):
    ```apache
    <IfModule mod_security.c>
      SecFilterEngine Off
      SecFilterScanPOST Off
    </IfModule>
    ```
3.  **Hubungi Support**: Jika cara di atas tidak bisa, minta pihak hosting untuk melakukan *whitelist* terhadap URL `admin/*/pages/edit/*`.

### Solusi 2: Perbaikan Konfigurasi Environment (.env)
Pastikan file `.env` di server sudah sesuai dengan domain hosting Anda:
```env
app.baseURL = 'https://domain-anda.com/'
app.indexPage = ''
```
*Pastikan menggunakan `https://` jika domain Anda menggunakan SSL.*

### Solusi 3: Penyesuaian Cookie & CSRF
Buka file `app/Config/Security.php` dan pastikan pengaturan berikut:
```php
public string $csrfProtection = 'cookie'; // Gunakan cookie untuk persistensi lebih baik
public bool $redirect = true;            // Redirect jika token tidak valid
```
Dan di `app/Config/App.php`:
```php
public string $cookieDomain = ''; // Kosongkan agar otomatis mengikuti domain aktif
public bool $cookieSecure = true; // Set TRUE jika menggunakan HTTPS
```

### Solusi 4: Perizinan Folder (Permissions)
Pastikan folder `writable` memiliki akses yang cukup:
- Folder `writable` dan sub-foldernya: `775` atau `755`.
- Jika server sangat ketat, gunakan `777` (namun pastikan keamanannya).

---

## 3. Kesimpulan & Rekomendasi
Besar kemungkinan masalah yang Anda alami adalah **ModSecurity** karena fitur edit halaman mengirimkan konten HTML mentah. 

**Rekomendasi Tindakan**:
1. Cek `baseURL` di `.env`.
2. Coba matikan ModSecurity di cPanel sementara untuk memastikan apakah error hilang.
3. Jika hilang, Anda tahu penyebabnya adalah firewall server.
