## [v1.0.11] - 2026-06-15
### 🐛 Fixed
- Perbaikan masalah embed Google Maps yang tidak tampil di footer akibat pembatasan Content Security Policy (CSP).
- Penyesuaian `frameSrc` pada konfigurasi CSP untuk mengizinkan domain `google.com` dan `maps.google.com`.
- Peningkatan keamanan output pada URL Google Maps menggunakan context `attr` pada fungsi `esc()`.

## [v1.0.10] - 2026-06-13
### ✨ Added
- Penambahan fitur edit tanggal publikasi pada form artikel (Create & Edit) di Dashboard Admin.
- Validasi format tanggal publikasi untuk memastikan kompatibilitas dengan database MySQL.

## [v1.0.9] - 2026-06-12
### ✨ Added
- Fitur CRUD Halaman Statis (Pages) untuk membuat halaman informasi khusus per tenant.
- Penambahan menu "Halaman Statis" pada SideNavBar di Dashboard Admin.
- Tabel database `mst_pages` untuk menyimpan data halaman statis dengan dukungan `UUID` untuk URL.
- Penambahan form input gambar header/banner khusus mobile (`header_img_mobile`) pada halaman Pengaturan Identitas PKM.
- Implementasi upload, konversi WebP, dan penyimpanan aset banner mobile per tenant.
- Penyesuaian UI form pengaturan untuk membedakan banner desktop (landscape) dan mobile (portrait/square).
- Fitur filter periode pada tabel "Data Terimport" di halaman Statistik Penyakit untuk mempermudah audit data per laporan.
- Implementasi filter periode dinamis pada Grafik Penyakit Terbanyak di halaman Frontend untuk menyaring data berdasarkan laporan yang tersedia.
- Penyederhanaan UI Grafik Penyakit dengan menghapus tombol Export Data pada sisi publik.
- Pembaruan sistem manajemen menu: Mendukung hierarki menu tak terbatas (nested menus) dengan pilihan induk yang lebih fleksibel.
- Implementasi perenderan menu rekursif pada Navbar Frontend untuk mendukung tampilan sub-menu bertingkat (multi-level dropdown) baik di desktop maupun mobile.

## [v1.0.8] - 2026-06-11
### 🛡️ Security
- Implementasi penguatan keamanan global: Mengaktifkan CSRF Protection, XSS Filtering (invalidchars), Honeypot, dan Secure Headers secara global.
- Aktivasi Content Security Policy (CSP) untuk mencegah serangan injection dan cross-site scripting (XSS).
- Mitigasi celah keamanan IDOR (Insecure Direct Object Reference) pada modul Artikel, Kategori, dan Pengguna dengan verifikasi kepemilikan data (tenant isolation) yang lebih ketat.
- Migrasi URL administratif dari berbasis ID numerik ke berbasis UUID sesuai standar keamanan `GEMINI.md`.
- Penambahan fungsi escaping `esc()` pada seluruh input form untuk mencegah eksekusi skrip berbahaya.
- Pengaktifan fitur CSRF Token Randomization untuk perlindungan tambahan.

## [v1.0.7] - 2026-06-11
### ✨ Added
- Fitur Import Statistik Penyakit dari file Excel (`.xlsx`, `.xls`) di Dashboard Admin.
- Menu "Statistik Penyakit" pada SideNavBar Admin untuk manajemen data laporan penyakit tahunan/bulanan.
- Tabel database `trn_statistik_penyakit` untuk menyimpan data diagnosa penyakit per tenant.
- Integrasi `StatistikCell` di Frontend untuk menampilkan grafik 10 penyakit terbanyak secara dinamis dari database.
- Dukungan library `phpoffice/phpspreadsheet` untuk pemrosesan file Excel.

## [v1.0.6] - 2026-06-10
### ✨ Added
- Fitur Pencarian Puskesmas pada halaman utama portal (`/`) untuk mempermudah akses informasi antar wilayah.
- Implementasi filter pencarian instan (client-side) menggunakan JavaScript untuk pengalaman pengguna yang lebih cepat dan responsif.
- State "Tidak Ditemukan" dengan desain visual yang informatif saat hasil pencarian nihil.
- Tampilan nama kategori dinamis pada *Hero Carousel* dan *Featured News* menggantikan teks statis "Berita Utama" dan "Terbaru".
- Perubahan format *Running Text* agar menampilkan teks sesuai dengan input di database (menghapus paksaan huruf kapital).

## [v1.0.5] - 2026-06-09
### ✨ Added
- Fitur Teks Berjalan (*Running Text*) pada halaman utama PKM untuk pengumuman atau tips kesehatan.
- Menu manajemen Teks Berjalan di SideNavBar Admin (`admin/(:segment)/running-text`) untuk Admin Dinkes dan Admin PKM.
- Tabel database baru `mst_running_text` untuk menyimpan data teks berjalan per tenant.
- Seeder `RunningTextSeeder` untuk data pengumuman awal.
- Implementasi *Hamburger Menu* (Sidebar Mobile) pada halaman frontend untuk navigasi yang responsif di perangkat seluler.

## [v1.0.4] - 2026-06-09
### 🐛 Fixed
- Perbaikan tampilan konten artikel pada halaman detail berita yang menampilkan tag HTML mentah. Kini HTML dirender dengan benar (seperti huruf tebal, miring, dsb).

### 🔄 Changed
- Implementasi pewarnaan dinamis pada `SideNavBar` di Dashboard Admin menggunakan kolom `primary_color` dan `on_primary_color` dari tabel `mst_pkm`.
- Implementasi pewarnaan dinamis pada Navbar Frontend menggunakan kolom `primary_color` dan `on_primary_color` dari tabel `mst_pkm`.
- Sinkronisasi `PkmSeeder` untuk menyertakan `on_primary_color` default (Putih) untuk seluruh tenant PKM.

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
