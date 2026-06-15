<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/kategori') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
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

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface max-w-2xl">
        <form action="<?= isset($kategori) ? base_url('admin/' . tenant()->pkm_slug . '/kategori/update/' . $kategori['kategori_uuid']) : base_url('admin/' . tenant()->pkm_slug . '/kategori/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if (isset($list_pkm)): ?>
                <!-- PKM (Super Admin Only) -->
                <div class="md:col-span-2">
                    <label for="pkm_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Pilih PKM <span class="text-error">*</span></label>
                    <select id="pkm_id" name="pkm_id" required class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="" disabled <?= old('pkm_id', $kategori['pkm_id'] ?? '') === '' ? 'selected' : '' ?>>-- Pilih PKM --</option>
                        <?php foreach ($list_pkm as $pkm): ?>
                            <option value="<?= esc($pkm['pkm_id']) ?>" <?= old('pkm_id', $kategori['pkm_id'] ?? '') == $pkm['pkm_id'] ? 'selected' : '' ?>><?= esc($pkm['pkm_nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>

                <!-- Nama Kategori -->
                <div class="md:col-span-2">
                    <label for="nama" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Kategori <span class="text-error">*</span></label>
                    <input type="text" id="nama" name="nama" value="<?= old('nama', $kategori['nama'] ?? '') ?>" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- Induk Kategori -->
                <div class="md:col-span-2">
                    <label for="kategori_induk_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Induk Kategori <span class="text-outline-variant font-normal">(Opsional)</span></label>
                    <select id="kategori_induk_id" name="kategori_induk_id" class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="">-- Pilih Induk Kategori (Jadikan Kategori Utama) --</option>
                        <?php foreach ($parent_kategori as $parent): ?>
                            <option value="<?= $parent['kategori_id'] ?>" <?= old('kategori_induk_id', $kategori['kategori_induk_id'] ?? '') == $parent['kategori_id'] ? 'selected' : '' ?>>
                                <?= esc($parent['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/kategori') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
