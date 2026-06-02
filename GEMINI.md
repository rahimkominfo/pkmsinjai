# SYSTEM PROMPT: PENGEMBANGAN APLIKASI PKM MULTI-TENANT (CI4)

## 1. Standar Pengembangan (Core Policy)
- **Framework**: CodeIgniter 4 (Wajib PSR-12, DRY).
- **CSS Framework**: Wajib menggunakan **Tailwind CSS** yang diinstal dan dikonfigurasi melalui **PostCSS** untuk optimalisasi proses build.
- **Struktur DB**: Prefix `sys_`, `mst_`, `trn_`, `log_`. Wajib `Soft Deletes` dan `Indexing` pada kolom filter.
- **Keamanan**: `UUID` untuk URL, `password_hash()` (BCRYPT), CSRF & XSS filtering aktif.
- **Portabilitas**: Gunakan `base_url()` dan `ROOTPATH` agar kompatibel di PC/Termux.
- **Asset**: Auto-convert ke WebP. Dilarang modifikasi PDF dengan TTE (scan `/ByteRange`).
- **UI Icon**: Wajib menggunakan **Google Material Symbols** sebagai icon font resmi untuk seluruh elemen antarmuka aplikasi.

## 2. Arsitektur Multi-Tenant (9 PKM)
- **Konsep**: Single Codebase, Logic `pkm_id` per data.
- **Tenant Detection**: Wajib menggunakan *Filter* (Middleware) CI4 untuk mendeteksi domain/path dan memuat konfigurasi tema (`primary_color`, `logo`, `header_img`) secara dinamis.
- **Identitas**: Data PKM disimpan di tabel `mst_pkm`.

## 3. Data Server Lokal (Environment)
Gunakan kredensial berikut untuk pengaturan koneksi *database* di file `.env` atau `app/Config/Database.php`:
- **hostname**: localhost
- **database**: pkmsinjai_db
- **username**: root
- **password**: sembarangji

## 4. Manajemen Kualitas & Dokumentasi
- **Release Notes**: Wajib update `RELEASE_NOTES.md` di root project menggunakan Semantic Versioning (vMAJOR.MINOR.PATCH) dengan label:
    - ✨ Added: Fitur baru
    - 🐛 Fixed: Bug fix
    - 🔄 Changed: Perubahan non-bug
    - 🗑️ Deprecated: Fitur yang akan dihapus
    - 🛡️ Security: Patch keamanan

## 5. Perintah Operasional
- Setiap kode yang dibuat **HARUS** menyertakan dokumentasi singkat mengenai kegunaannya.
- Untuk setiap perubahan fitur, tanyakan apakah sudah perlu mengupdate `RELEASE_NOTES.md`.
- Jika membuat kode HTML atau View, pastikan implementasi komponen menggunakan utility-first classes dari **Tailwind CSS** (hasil compile PostCSS) dan ikon memanfaatkan kelas dari **Google Material Symbols**.
- Jika membuat *query* atau migrasi database, pastikan mengacu pada kredensial di bagian **Data Server Lokal** dan menyertakan `log_activity()` untuk audit.

---
*Note: Ini adalah panduan permanen untuk setiap tugas coding yang saya berikan kepada Anda.*