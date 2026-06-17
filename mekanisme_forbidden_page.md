# Mekanisme & Analisis Error 403 Forbidden pada Create/Edit Halaman

Dokumen ini menjelaskan penyebab dan solusi terkait munculnya pesan **403 Forbidden** saat mencoba menyimpan atau membuat halaman baru (`admin/(:segment)/pages/create` atau `edit`) setelah aplikasi di-deploy ke cPanel, terutama saat memasukkan gambar melalui URL.

## 1. Analisis Penyebab Utama

Munculnya error 403 Forbidden di lingkungan *shared hosting* (cPanel) biasanya disebabkan oleh faktor-faktor keamanan berikut:

### A. ModSecurity & Filter Payload URL (Kasus "Insert via URL")
ModSecurity adalah Web Application Firewall (WAF) yang sangat sensitif terhadap isi data yang dikirim melalui form (POST).
- **Kasus Spesifik (Insert via URL)**: Saat Anda menggunakan fitur CKEditor untuk memasukkan gambar menggunakan link luar (URL), data yang dikirim ke server mengandung string seperti `<img src="https://external-site.com/image.jpg">`.
- **Mengapa Diblokir?**:
    1. **Remote File Inclusion (RFI)**: Firewall mencurigai adanya upaya menyisipkan file dari server luar yang bisa membahayakan sistem.
    2. **Protocol Filtering**: Banyak aturan ModSecurity (seperti rule dari *OWASP Core Rule Set*) yang secara otomatis memblokir permintaan POST jika mengandung protokol `http://` atau `https://` di dalam field teks, karena dianggap sebagai indikasi serangan **SSRF (Server-Side Request Forgery)** atau **Link Injection**.
- **Gejala**: Error 403 muncul tepat saat menekan tombol "Simpan" karena request tersebut dicegat oleh firewall cPanel sebelum sempat diproses oleh skrip PHP CodeIgniter Anda.

### B. Proteksi XSS (Cross-Site Scripting)
Input dari CKEditor berupa tag HTML mentah (`<p>`, `<div>`, `<table>`). WAF seringkali menganggap pengiriman tag HTML melalui form sebagai upaya serangan untuk menyuntikkan skrip berbahaya.

### C. Mismatch CSRF (Cross-Site Request Forgery)
- **Mengapa Terjadi?**: Jika konfigurasi `app.baseURL` di `.env` tidak sesuai (misal: menggunakan `http` padahal hosting pakai `https`), token CSRF akan dianggap tidak valid.
- **Gejala**: Muncul pesan "The action you requested is not allowed" atau langsung 403.

---

## 2. Mengapa di Localhost Berjalan, Tapi di Server Error?

### A. Ketiadaan Firewall di Localhost
Di lingkungan pengembangan (XAMPP/Laragon), ModSecurity biasanya tidak terpasang. Server menerima apapun yang Anda kirim, termasuk tag HTML dan URL eksternal.

### B. Reputasi IP & Whitelisting cPanel
Server cPanel memiliki fitur **CSF (ConfigServer Security & Firewall)**. 
- Jika Anda sering login ke cPanel dari satu laptop, IP Anda mungkin masuk dalam *temporary whitelist*.
- Laptop atau koneksi internet lain (IP baru) akan diperiksa secara ketat oleh setiap *rule* keamanan yang aktif.

---

## 3. Langkah-Langkah Solusi

### Solusi 1: Whitelist/Nonaktifkan ModSecurity (Solusi Paling Ampuh)
Karena masalah ini berada di level server (bukan di kode CI4), Anda harus menyesuaikan keamanan server:
1.  **Melalui cPanel**: Cari menu **ModSecurity**, lalu coba matikan (*Disable*) untuk domain tersebut. Jika setelah dimatikan fitur "Insert via URL" berfungsi, maka dipastikan ModSecurity adalah penyebabnya.
2.  **Hubungi Provider Hosting**: Kirim tiket dukungan dan minta mereka melakukan *whitelist* terhadap Rule ID yang terpicu saat Anda menyimpan halaman. Anda bisa melihat ID tersebut di menu **Errors** pada cPanel.

### Solusi 2: Gunakan Fitur Upload, Bukan Link URL
Untuk menghindari blokir firewall terhadap string `http://`, disarankan untuk **mengunduh gambar dan mengunggahnya langsung** ke server (Upload via CKEditor) daripada menggunakan link URL luar. Dengan mengunggah file, payload POST tidak akan mengandung protokol URL eksternal yang mencurigakan.

### Solusi 3: Perbaikan Konfigurasi .env
Pastikan domain sudah benar dan menggunakan protokol yang tepat:
```env
app.baseURL = 'https://nama-domain-anda.com/'
```

### Solusi 4: Pengaturan .htaccess (Opsional)
Jika diizinkan oleh provider, tambahkan ini di `public/.htaccess`:
```apache
<IfModule mod_security.c>
  SecFilterEngine Off
  SecFilterScanPOST Off
</IfModule>
```
*Catatan: Banyak provider hosting menonaktifkan kemampuan user untuk mengubah setting ini demi keamanan.*

---

## 4. Kesimpulan & Rekomendasi
Pesan **Forbidden** saat memasukkan URL gambar adalah mekanisme pertahanan server terhadap potensi serangan **RFI/SSRF**. 

**Rekomendasi Utama**:
1. Gunakan fitur **Upload Gambar** daripada "Insert via URL".
2. Jika harus menggunakan URL, mintalah pihak hosting untuk melakukan *whitelist* terhadap endpoint `admin/*/pages/create` dan `admin/*/pages/edit`.
3. Pastikan `app.baseURL` selalu sinkron dengan URL yang diakses di browser.
