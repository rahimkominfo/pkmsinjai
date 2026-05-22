<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2 self-start md:self-auto">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Antrian
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
                    <th class="p-3">Info Layanan</th>
                    <th class="p-3">Nomor Antrian</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($antrian)): ?>
                    <?php foreach ($antrian as $row): ?>
                    <tr class="border-b border-surface-container-low hover:bg-[#eff4ff] transition-colors">
                        <td class="p-3 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white shrink-0" style="background-color: <?= esc($row['color'] ?: '#006c4a') ?>;">
                                <span class="material-symbols-outlined text-[20px]"><?= esc($row['icon'] ?: 'medication') ?></span>
                            </div>
                            <div>
                                <div class="font-data-table text-data-table text-on-surface font-semibold"><?= esc($row['title']) ?></div>
                                <div class="font-label-sm text-label-sm text-outline-variant"><?= esc($row['loket']) ?> • <?= esc($row['petugas']) ?></div>
                            </div>
                        </td>
                        <td class="p-3 font-headline-md text-headline-md text-primary font-bold">
                            <?= esc($row['nomor']) ?>
                        </td>
                        <td class="p-3">
                            <?php 
                                $statusColor = 'text-outline bg-surface-variant border-outline-variant';
                                if ($row['status'] === 'menunggu') $statusColor = 'text-[#d97706] bg-[#fef3c7] border-[#fcd34d]';
                                elseif ($row['status'] === 'dilayani') $statusColor = 'text-primary bg-primary-container border-primary-fixed';
                                elseif ($row['status'] === 'selesai') $statusColor = 'text-[#166534] bg-[#dcfce3] border-[#86efac]';
                                elseif ($row['status'] === 'batal') $statusColor = 'text-error bg-error-container border-error';
                            ?>
                            <span class="font-label-sm text-[11px] <?= $statusColor ?> px-2 py-1 rounded border uppercase">
                                <?= esc($row['status']) ?>
                            </span>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= date('d M Y', strtotime($row['tanggal'])) ?>
                        </td>
                        <td class="p-3 text-right">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/edit/' . $row['id']) ?>" class="text-primary hover:text-primary-container transition-colors p-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/delete/' . $row['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus antrian ini?')" class="text-error hover:text-error-container transition-colors p-1 ml-2" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center font-body-md text-outline-variant">Belum ada data antrian.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
