<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/menu') ?>" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 font-label-md">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-error-container text-on-error-container p-4 rounded mb-4">
            <ul class="list-disc list-inside">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface">
        <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/menu/' . (isset($menu) ? 'update/' . $menu['id'] : 'store')) ?>" method="POST">
            <?= csrf_field() ?>

            <?php if (isset($list_pkm)): ?>
            <div class="mb-6">
                <label for="pkm_id" class="block font-label-md text-label-md text-on-surface mb-2">Pilih PKM <span class="text-error">*</span></label>
                <select id="pkm_id" name="pkm_id" required class="w-full border border-outline px-4 py-3 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-surface text-on-surface font-body-lg text-body-lg cursor-pointer">
                    <option value="" disabled <?= old('pkm_id', $menu['pkm_id'] ?? '') === '' ? 'selected' : '' ?>>-- Pilih PKM --</option>
                    <?php foreach ($list_pkm as $pkm): ?>
                        <option value="<?= esc($pkm['pkm_id']) ?>" <?= old('pkm_id', $menu['pkm_id'] ?? '') == $pkm['pkm_id'] ? 'selected' : '' ?>><?= esc($pkm['pkm_nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="mb-6">
                <label for="title" class="block font-label-md text-label-md text-on-surface mb-2">Judul Menu <span class="text-error">*</span></label>
                <input type="text" id="title" name="title" value="<?= old('title', $menu['title'] ?? '') ?>" class="w-full border border-outline px-4 py-3 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-surface text-on-surface font-body-lg text-body-lg" required placeholder="Contoh: Profil">
            </div>

            <div class="mb-6">
                <label for="url" class="block font-label-md text-label-md text-on-surface mb-2">URL <span class="text-error">*</span></label>
                <input type="text" id="url" name="url" value="<?= old('url', $menu['url'] ?? '') ?>" class="w-full border border-outline px-4 py-3 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-surface text-on-surface font-body-lg text-body-lg" required placeholder="Contoh: /profil (Gunakan / atau # atau link eksternal)">
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Isi dengan '#' jika menu ini hanya sebagai induk tanpa link (dropdown).</p>
            </div>

            <div class="mb-6">
                <label for="parent_id" class="block font-label-md text-label-md text-on-surface mb-2">Induk Menu (Opsional)</label>
                <select id="parent_id" name="parent_id" class="w-full border border-outline px-4 py-3 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-surface text-on-surface font-body-lg text-body-lg">
                    <option value="">-- Pilih Induk Menu (Utama) --</option>
                    <?php 
                    $renderOptions = function($items, $level = 0, $selectedId = null) use (&$renderOptions) {
                        foreach ($items as $item) {
                            $prefix = str_repeat('-- ', $level);
                            $selected = ($selectedId == $item['id']) ? 'selected' : '';
                            echo '<option value="' . $item['id'] . '" ' . $selected . '>';
                            echo $prefix . esc($item['title']);
                            if (isset($item['pkm_nama'])) {
                                echo ' - (' . esc($item['pkm_nama']) . ')';
                            }
                            echo '</option>';
                            if (!empty($item['children'])) {
                                $renderOptions($item['children'], $level + 1, $selectedId);
                            }
                        }
                    };
                    $renderOptions($parent_menus, 0, old('parent_id', $menu['parent_id'] ?? ''));
                    ?>
                </select>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Pilih induk jika ini adalah sub-menu.</p>
            </div>

            <div class="mb-6">
                <label for="sort_order" class="block font-label-md text-label-md text-on-surface mb-2">Urutan (Opsional)</label>
                <input type="number" id="sort_order" name="sort_order" value="<?= old('sort_order', $menu['sort_order'] ?? '0') ?>" class="w-full border border-outline px-4 py-3 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-surface text-on-surface font-body-lg text-body-lg">
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Angka lebih kecil akan tampil lebih dulu.</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2 font-label-md text-label-md text-on-surface cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" <?= old('is_active', isset($menu) ? $menu['is_active'] : 1) ? 'checked' : '' ?> class="w-4 h-4 accent-primary cursor-pointer">
                    Menu Aktif (Tampilkan di Halaman Utama)
                </label>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/menu') ?>" class="px-6 py-2 border border-outline text-on-surface rounded hover:bg-surface-container-low transition-colors font-label-lg">Batal</a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded hover:shadow-sm hover:-translate-y-[1px] transition-all font-label-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
