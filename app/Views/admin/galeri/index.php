<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2 self-start md:self-auto">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Galeri
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
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="border-b border-surface-variant text-outline-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="p-3 w-20">Sampul</th>
                    <th class="p-3">Judul Galeri</th>
                    <th class="p-3">Jumlah Foto</th>
                    <th class="p-3">Tanggal Dibuat</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($galeri)): ?>
                    <?php foreach ($galeri as $row): ?>
                    <tr class="border-b border-surface-container-low hover:bg-[#eff4ff] transition-colors">
                        <td class="p-3">
                            <?php if ($row['sampul_url']): ?>
                                <img src="<?= base_url(esc($row['sampul_url'])) ?>" alt="Sampul" class="w-16 h-12 object-cover rounded shadow-sm">
                            <?php else: ?>
                                <div class="w-16 h-12 bg-surface-variant rounded flex items-center justify-center text-outline-variant">
                                    <span class="material-symbols-outlined text-[20px]">image</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="p-3">
                            <div class="font-data-table text-data-table text-on-surface font-semibold truncate max-w-[200px]" title="<?= esc($row['judul']) ?>"><?= esc($row['judul']) ?></div>
                            <div class="font-label-sm text-label-sm text-outline-variant truncate max-w-xs"><?= esc($row['deskripsi']) ?></div>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= $row['jumlah_foto'] ?> Foto
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td class="p-3 text-right">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri/edit/' . $row['galeri_id']) ?>" class="text-primary hover:text-primary-container transition-colors p-1" title="Edit & Kelola Foto">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri/delete/' . $row['galeri_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')" class="text-error hover:text-error-container transition-colors p-1 ml-2" title="Hapus Galeri">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center font-body-md text-outline-variant">Belum ada data galeri.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
