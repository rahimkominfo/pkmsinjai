## [v1.0.3] - 2026-05-29
### ✨ Added
- Sistem Login otentikasi Admin (`/login`) dengan UI standar Tailwind CSS dan Material Symbols.
- Filter Autorisasi `AuthFilter` untuk memproteksi seluruh rute `/admin` serta isolasi data (hanya dapat mengakses `pkm_slug` masing-masing atau semua untuk Admin Dinkes).
- Navigasi dinamis di sidebar Admin sesuai hak akses peran (Role-based Access Control).

### 🔄 Changed
- Penyesuaian struktur peran (role) pada tabel `sys_users` menjadi `Admin Dinkes`, `Admin PKM`, `Editor`, dan `Penulis`.
- Update controller dan routing untuk mendukung manajemen tenant sesuai dengan hak akses (Admin Dinkes adalah level tertinggi).
- Mengganti nama peran (role) **Kontributor** menjadi **Penulis** pada tabel `sys_users`, controller, dan view terkait.

## [v1.0.1] - 2026-05-22
### 🐛 Fixed
- Perbaikan error `HTTPException: Could not move file` pada saat upload gambar di menu Galeri, Artikel, dan Pengaturan dengan menggunakan path absolut `FCPATH`.
- Perbaikan izin akses (permissions) pada direktori `public/uploads`.

### ✨ Added
- Implementasi auto-convert ke format **WebP** untuk semua unggahan gambar guna optimalisasi performa dan penyimpanan sesuai standar `GEMINI.md`.
- Fitur auto-create directory jika folder tujuan upload belum tersedia.
- **Struktur Folder Dinamis:** Pengorganisasian file unggahan kini dikelompokkan berdasarkan slug tenant (contoh: `uploads/{slug}/galeri/`) untuk manajemen aset yang lebih rapi.

### 🔄 Changed
- Restrukturisasi nama tabel database sesuai standar `GEMINI.md`:
  - `users` -> `sys_users`
  - `artikel` -> `trn_artikel`
  - `kategori` -> `mst_kategori`
  - `tags` -> `mst_tags`
  - `artikel_kategori` -> `trn_artikel_kategori`
  - `artikel_tags` -> `trn_artikel_tags`
  - `galeri` -> `trn_galeri`
  - `galeri_gambar` -> `trn_galeri_gambar`
  - `media` -> `mst_media`
  - `artikel_media` -> `trn_artikel_media`
  - `komentar` -> `trn_komentar`
  - `subscribers` -> `mst_subscribers`
  - `visitor` -> `log_visitor`

### ✨ Added
- Tabel baru `mst_pkm` untuk manajemen multi-tenant.
- Kolom `pkm_id` di hampir semua tabel untuk mendukung isolasi data per tenant.
- Kolom `uuid` di tabel utama (`mst_pkm`, `sys_users`, `trn_artikel`).
- Indexing pada kolom filter (`pkm_id`, `status`, `slug`, `deleted_at`).
- Implementasi `Soft Deletes` pada tabel yang belum memilikinya.
