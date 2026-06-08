<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <div class="flex flex-col md:flex-row gap-4 items-center self-start md:self-auto">
            <?php if (isset($list_pkm)): ?>
                <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian') ?>" method="GET" class="flex items-center gap-2">
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
            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Antrian
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
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="border-b border-surface-variant text-outline-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="p-3">Info Layanan</th>
                    <?php if (tenant()->pkm_id === 'super'): ?>
                    <th class="p-3">PKM</th>
                    <?php endif; ?>
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
                        <?php if (tenant()->pkm_id === 'super'): ?>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= esc($row['pkm_nama'] ?? 'Unknown') ?>
                        </td>
                        <?php endif; ?>
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
                            <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/update_status/' . $row['id']) ?>" method="POST" class="inline-block m-0">
                                <?= csrf_field() ?>
                                <select name="status" onchange="this.form.submit()" class="font-label-sm text-[11px] <?= $statusColor ?> px-2 py-1 rounded border uppercase cursor-pointer outline-none appearance-none pr-6 bg-no-repeat" style="background-image: url('data:image/svg+xml;utf8,<svg fill=%22currentColor%22 height=%2224%22 viewBox=%220 0 24 24%22 width=%2224%22 xmlns=%22http://www.w3.org/2000/svg%22><path d=%22M7 10l5 5 5-5z%22/></svg>'); background-position: right 2px top 50%; background-size: 16px;">
                                    <option value="menunggu" <?= $row['status'] == 'menunggu' ? 'selected' : '' ?>>MENUNGGU</option>
                                    <option value="dilayani" <?= $row['status'] == 'dilayani' ? 'selected' : '' ?>>DILAYANI</option>
                                    <option value="selesai" <?= $row['status'] == 'selesai' ? 'selected' : '' ?>>SELESAI</option>
                                    <option value="batal" <?= $row['status'] == 'batal' ? 'selected' : '' ?>>BATAL</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= date('d M Y', strtotime($row['tanggal'])) ?>
                        </td>
                        <td class="p-3 text-right">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/reset/' . $row['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin mereset nomor antrian ini ke 0?')" class="text-[#d97706] hover:text-[#b45309] transition-colors p-1" title="Reset Nomor">
                                <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/edit/' . $row['id']) ?>" class="text-primary hover:text-primary-container transition-colors p-1 ml-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian/delete/' . $row['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus antrian ini?')" class="text-error hover:text-error-container transition-colors p-1 ml-1" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= tenant()->pkm_id === 'super' ? '6' : '5' ?>" class="p-4 text-center font-body-md text-outline-variant">Belum ada data antrian.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
