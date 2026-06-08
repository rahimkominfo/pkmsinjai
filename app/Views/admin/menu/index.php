<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <div class="flex flex-col md:flex-row gap-4 items-center self-start md:self-auto">
            <?php if (isset($list_pkm)): ?>
                <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/menu') ?>" method="GET" class="flex items-center gap-2">
                    <select name="pkm_id" onchange="this.form.submit()" class="bg-surface text-on-surface border border-outline px-3 py-2 rounded focus:outline-none focus:border-primary font-body-md text-body-md">
                        <option value="super">Semua PKM</option>
                        <?php foreach ($list_pkm as $pkm): ?>
                            <option value="<?= esc($pkm['pkm_id']) ?>" <?= (isset($selected_pkm) && $selected_pkm == $pkm['pkm_id']) ? 'selected' : '' ?>>
                                <?= esc($pkm['pkm_nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif; ?>
            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/menu/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Menu
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="bg-primary-container text-on-primary-container p-4 rounded mb-4">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-error-container text-on-error-container p-4 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="border-b border-surface-variant text-outline-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="p-3">Judul Menu</th>
                    <?php if (tenant()->pkm_id === 'super'): ?>
                    <th class="p-3">PKM</th>
                    <?php endif; ?>
                    <th class="p-3">URL</th>
                    <th class="p-3">Induk Menu</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Urutan</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($menus)): ?>
                    <?php foreach ($menus as $row): ?>
                    <tr class="border-b border-surface-container-low hover:bg-[#eff4ff] transition-colors">
                        <td class="p-3">
                            <div class="font-data-table text-data-table text-on-surface"><?= esc($row['title']) ?></div>
                        </td>
                        <?php if (tenant()->pkm_id === 'super'): ?>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= esc($row['pkm_nama'] ?? 'Unknown') ?>
                        </td>
                        <?php endif; ?>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant"><?= esc($row['url']) ?></td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= $row['parent_title'] ? esc($row['parent_title']) : '<span class="text-outline-variant italic">Utama</span>' ?>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= $row['is_active'] ? '<span class="text-primary font-medium">Aktif</span>' : '<span class="text-error font-medium">Sembunyi</span>' ?>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant"><?= esc($row['sort_order']) ?></td>
                        <td class="p-3 text-right">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/menu/edit/' . $row['id']) ?>" class="text-primary hover:text-primary-container transition-colors p-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/menu/delete/' . $row['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')" class="text-error hover:text-error-container transition-colors p-1 ml-2" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= tenant()->pkm_id === 'super' ? '7' : '6' ?>" class="p-4 text-center font-body-md text-outline-variant">Belum ada data menu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
