# Release Notes

## [v1.0.0] - 2026-05-21
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
