<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/sdm-pkm') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-error-container text-on-error-container p-4 rounded mb-6">
            <ul class="list-disc ml-5">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface">
        <form action="<?= isset($sdm) ? base_url('admin/' . tenant()->pkm_slug . '/sdm-pkm/update/' . $sdm['uuid']) : base_url('admin/' . tenant()->pkm_slug . '/sdm-pkm/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kiri: Form Utama -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Lengkap <span class="text-error">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= esc(old('nama_lengkap', $sdm['nama_lengkap'] ?? '')) ?>" required
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                    </div>

                    <!-- Profesi / Jabatan -->
                    <div>
                        <label for="profesi_jabatan" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Profesi / Jabatan <span class="text-error">*</span></label>
                        <input type="text" id="profesi_jabatan" name="profesi_jabatan" value="<?= esc(old('profesi_jabatan', $sdm['profesi_jabatan'] ?? '')) ?>" required
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                        <p class="text-[12px] text-outline mt-1">Contoh: Dokter Umum, Perawat Gigi, Kepala Puskesmas, dll.</p>
                    </div>

                    <!-- Unit / Poli -->
                    <div>
                        <label for="unit_poli" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Unit / Poli Penempatan <span class="text-error">*</span></label>
                        <input type="text" id="unit_poli" name="unit_poli" value="<?= esc(old('unit_poli', $sdm['unit_poli'] ?? '')) ?>" required
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                        <p class="text-[12px] text-outline mt-1">Contoh: Poli Umum, IGD, Apotek, Manajemen, dll.</p>
                    </div>

                    <!-- Foto Pegawai URL -->
                    <div>
                        <label for="foto_pegawai" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">URL Foto Pegawai</label>
                        <input type="url" id="foto_pegawai" name="foto_pegawai" value="<?= esc(old('foto_pegawai', $sdm['foto_pegawai'] ?? '')) ?>" placeholder="https://..."
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                        <p class="text-[12px] text-outline mt-1">Masukkan URL gambar foto pegawai (opsional).</p>
                    </div>
                </div>

                <!-- Kanan: Sidebar Form -->
                <div class="space-y-6">
                    <?php if (isset($list_pkm)): ?>
                    <!-- PKM (Super Admin Only) -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="pkm_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Pilih PKM <span class="text-error">*</span></label>
                        <select id="pkm_id" name="pkm_id" required class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 cursor-pointer">
                            <option value="" disabled <?= old('pkm_id', $sdm['pkm_id'] ?? '') === '' ? 'selected' : '' ?>>-- Pilih PKM --</option>
                            <?php foreach ($list_pkm as $pkm): ?>
                                <option value="<?= esc($pkm['pkm_id']) ?>" <?= old('pkm_id', $sdm['pkm_id'] ?? '') == $pkm['pkm_id'] ? 'selected' : '' ?>><?= esc($pkm['pkm_nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/sdm-pkm') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Pegawai
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
