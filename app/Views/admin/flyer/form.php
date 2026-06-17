<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/flyer') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
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
        <form action="<?= isset($flyer) ? base_url('admin/' . tenant()->pkm_slug . '/flyer/update/' . $flyer['uuid']) : base_url('admin/' . tenant()->pkm_slug . '/flyer/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kiri: Form Utama -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Judul Flyer <span class="text-error">*</span></label>
                        <input type="text" id="judul" name="judul" value="<?= esc(old('judul', $flyer['judul'] ?? '')) ?>" required
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                    </div>

                    <!-- Gambar URL -->
                    <div>
                        <label for="gambar_url" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">URL Gambar <span class="text-error">*</span></label>
                        <input type="url" id="gambar_url" name="gambar_url" value="<?= esc(old('gambar_url', $flyer['gambar_url'] ?? '')) ?>" required placeholder="https://..."
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                        <p class="text-[12px] text-outline mt-1">Masukkan URL gambar (contoh: https://domain.com/gambar.jpg).</p>
                    </div>

                    <!-- Label -->
                    <div>
                        <label for="label" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Label (Opsional)</label>
                        <input type="text" id="label" name="label" value="<?= esc(old('label', $flyer['label'] ?? '')) ?>"
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                    </div>
                </div>

                <!-- Kanan: Sidebar Form -->
                <div class="space-y-6">
                    <?php if (isset($list_pkm)): ?>
                    <!-- PKM (Super Admin Only) -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="pkm_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Pilih PKM <span class="text-error">*</span></label>
                        <select id="pkm_id" name="pkm_id" required class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 cursor-pointer">
                            <option value="" disabled <?= old('pkm_id', $flyer['pkm_id'] ?? '') === '' ? 'selected' : '' ?>>-- Pilih PKM --</option>
                            <?php foreach ($list_pkm as $pkm): ?>
                                <option value="<?= esc($pkm['pkm_id']) ?>" <?= old('pkm_id', $flyer['pkm_id'] ?? '') == $pkm['pkm_id'] ? 'selected' : '' ?>><?= esc($pkm['pkm_nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <!-- Status -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="status" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Status <span class="text-error">*</span></label>
                        <select id="status" name="status" class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 cursor-pointer">
                            <option value="Aktif" <?= old('status', $flyer['status'] ?? '') === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Tidak Aktif" <?= old('status', $flyer['status'] ?? '') === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Urutan -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="urutan" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Urutan Tampil</label>
                        <input type="number" id="urutan" name="urutan" value="<?= esc(old('urutan', $flyer['urutan'] ?? '0')) ?>"
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                        <p class="text-[12px] text-outline mt-1">Angka lebih kecil tampil lebih awal (0, 1, 2...)</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/flyer') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Flyer
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
