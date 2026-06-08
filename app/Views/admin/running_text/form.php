<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/running-text') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
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

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface max-w-3xl">
        <form action="<?= isset($running_text) ? base_url('admin/' . tenant()->pkm_slug . '/running-text/update/' . $running_text['id']) : base_url('admin/' . tenant()->pkm_slug . '/running-text/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if (isset($list_pkm)): ?>
                <!-- PKM (Super Admin Only) -->
                <div class="md:col-span-2">
                    <label for="pkm_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Pilih PKM <span class="text-error">*</span></label>
                    <select id="pkm_id" name="pkm_id" required class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="" disabled <?= old('pkm_id', $running_text['pkm_id'] ?? '') === '' ? 'selected' : '' ?>>-- Pilih PKM --</option>
                        <?php foreach ($list_pkm as $pkm): ?>
                            <option value="<?= esc($pkm['pkm_id']) ?>" <?= old('pkm_id', $running_text['pkm_id'] ?? '') == $pkm['pkm_id'] ? 'selected' : '' ?>><?= esc($pkm['pkm_nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>

                <!-- Teks -->
                <div class="md:col-span-2">
                    <label for="teks" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Teks Berjalan <span class="text-error">*</span></label>
                    <textarea id="teks" name="teks" required rows="3"
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all"><?= old('teks', $running_text['teks'] ?? '') ?></textarea>
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label for="is_active" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Status</label>
                    <select id="is_active" name="is_active" class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="1" <?= old('is_active', $running_text['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= old('is_active', $running_text['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/running-text') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
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
