<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengaturan/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2 self-start md:self-auto">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah PKM
        </a>
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
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="border-b border-surface-variant text-outline-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="p-3 w-20">Logo</th>
                    <th class="p-3">Nama PKM (Tenant)</th>
                    <th class="p-3">Slug (Domain)</th>
                    <th class="p-3">Tema Warna</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pkms)): ?>
                    <?php foreach ($pkms as $row): ?>
                    <tr class="border-b border-surface-container-low hover:bg-[#eff4ff] transition-colors">
                        <td class="p-3">
                            <?php if ($row['logo']): ?>
                                <img src="<?= base_url(esc($row['logo'])) ?>" alt="Logo" class="w-12 h-12 object-contain rounded-full border border-surface-variant bg-white p-1 shadow-sm">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-surface-variant rounded flex items-center justify-center text-outline-variant rounded-full">
                                    <span class="material-symbols-outlined text-[20px]">apartment</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="p-3">
                            <div class="font-data-table text-data-table text-on-surface font-semibold"><?= esc($row['pkm_nama']) ?></div>
                            <div class="font-label-sm text-[11px] text-outline-variant">ID: <?= esc($row['pkm_uuid']) ?></div>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant font-mono">
                            /<?= esc($row['pkm_slug']) ?>
                        </td>
                        <td class="p-3 flex items-center gap-2 mt-4">
                            <div class="w-6 h-6 rounded-full border border-surface-variant shadow-sm" style="background-color: <?= esc($row['primary_color']) ?>;"></div>
                            <span class="font-body-md text-body-md text-on-surface-variant uppercase"><?= esc($row['primary_color']) ?></span>
                        </td>
                        <td class="p-3 text-right align-middle">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengaturan/edit/' . $row['pkm_id']) ?>" class="text-primary hover:text-primary-container transition-colors p-1 inline-block" title="Edit Identitas">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengaturan/delete/' . $row['pkm_id']) ?>" onclick="return confirm('Peringatan: Menghapus PKM akan mempengaruhi seluruh data (artikel, galeri) yang terkait. Lanjutkan?')" class="text-error hover:text-error-container transition-colors p-1 ml-2 inline-block" title="Hapus PKM">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center font-body-md text-outline-variant">Belum ada data pengaturan PKM.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
