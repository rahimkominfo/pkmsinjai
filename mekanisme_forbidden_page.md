# Mekanisme & Analisis Error 403 Forbidden pada Create/Edit Halaman

Dokumen ini menjelaskan penyebab teknis dan solusi terkait munculnya pesan **403 Forbidden** saat menyimpan konten yang mengandung gambar di lingkungan cPanel (Hosting).

## 1. Gejala Error
Saat menekan tombol **Simpan**, muncul pesan:
> **Forbidden**
> You don't have permission to access this resource.
> *Additionally, a 403 Forbidden error was encountered while trying to use an ErrorDocument to handle the request.*

## 2. Analisis Penyebab Utama (Root Cause)

### A. ModSecurity (Web Application Firewall)
Penyebab paling umum di cPanel adalah **ModSecurity**. Firewall ini memeriksa setiap data POST yang dikirim ke server.
- **Deteksi Payload HTML**: Konten CKEditor dikirim dalam bentuk tag HTML (`<img src="...">`, `<table>`, dll). ModSecurity sering menganggap tag HTML di dalam field teks sebagai serangan **Cross-Site Scripting (XSS)**.
- **Filter Protokol (URL)**: Jika Anda memasukkan gambar via URL luar, data mengandung string `http://` atau `https://`. Firewall mencurigai ini sebagai upaya **Server-Side Request Forgery (SSRF)** atau **Remote File Inclusion (RFI)**.
- **Base64 Data (Image Paste)**: Jika Anda menyalin-tempel (paste) gambar langsung ke editor, CKEditor sering mengubahnya menjadi string Base64 yang sangat panjang (`data:image/png;base64,...`). String panjang dan acak ini sering memicu rule **Obfuscated Code Injection** atau melebihi batas **SecRequestBodyLimit**.

---

## 3. Solusi Tanpa Menonaktifkan ModSecurity (Advanced)

Jika Anda tidak ingin menonaktifkan ModSecurity, gunakan pendekatan "Data Obfuscation" (Penyamaran Data) agar payload tidak terbaca sebagai ancaman oleh firewall:

### Solusi 1: Base64 Encoding Payload (Paling Ampuh)
Cara ini menyamarkan seluruh konten HTML menjadi string acak sebelum dikirim lewat POST.
1.  **Sisi Klien (JavaScript)**: Sebelum form di-submit, ambil data dari CKEditor, ubah ke Base64, dan masukkan ke hidden input.
    ```javascript
    // Contoh logic
    const content = editor.getData();
    const base64Content = btoa(unescape(encodeURIComponent(content)));
    document.getElementById('hidden_content_input').value = base64Content;
    ```
2.  **Sisi Server (PHP/Controller)**: Decode kembali string tersebut sebelum disimpan ke database.
    ```php
    $rawContent = $this->request->getPost('content');
    $decodedContent = base64_decode($rawContent);
    ```
*Hasilnya: Firewall hanya melihat string acak (misal: `YmVyYXRhcnlh...`) dan tidak akan memblokirnya karena tidak ada tag HTML.*

### Solusi 2: Menggunakan JSON AJAX Request
Beberapa firewall memiliki aturan yang lebih longgar untuk request dengan `Content-Type: application/json` dibandingkan `application/x-www-form-urlencoded`.
- Ubah proses simpan menggunakan `fetch()` atau `axios` dengan payload JSON.

### Solusi 3: Konversi Karakter Spesial (HTML Entities)
Ubah karakter `<` dan `>` menjadi entitas sebelum dikirim.
- Client: `content.replace(/</g, "&lt;").replace(/>/g, "&gt;")`
- Server: `htmlspecialchars_decode($content)`

### Solusi 4: Optimalisasi Konfigurasi CKEditor (Upload Adapter)
Jangan biarkan gambar masuk sebagai tag `<img>` dengan sumber eksternal atau Base64.
- Pastikan fitur **Simple Upload Adapter** aktif.
- Gambar yang di-drag/paste akan langsung diunggah ke server sebagai file binary (Multipart), bukan sebagai string teks di dalam konten. Request Multipart biasanya memiliki limit yang lebih besar dan aturan yang berbeda di ModSecurity.

---

## 4. Langkah-Langkah Perbaikan di Sisi Server (Hosting)

Jika solusi kode di atas terlalu rumit, lakukan hal berikut di cPanel:

1.  **Cek Log Error**: Cari menu **Errors** di cPanel. Catat **Rule ID** yang muncul (misal: `[id "941100"]`).
2.  **Whitelist via .htaccess**: Jika diizinkan, tambahkan pengecualian ID tersebut di `.htaccess`:
    ```apache
    <IfModule mod_security.c>
      SecRuleRemoveById 941100
    </IfModule>
    ```
3.  **Hubungi Provider**: Kirimkan Rule ID tersebut dan minta mereka melakukan whitelist khusus untuk user Anda atau endpoint tertentu.

## 5. Kesimpulan
Error 403 ini terjadi karena **Firewall Server gagal membedakan antara konten artikel yang sah dengan upaya serangan injeksi**. Menggunakan metode **Base64 Encoding** adalah solusi terbaik untuk aplikasi CMS yang berjalan di shared hosting yang sangat ketat.
