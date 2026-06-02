<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola data peran (role) pengguna sistem.</p>
        </div>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/peran/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2 self-start md:self-auto">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Peran
        </a>
    </div>

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="bg-primary-container text-on-primary-container p-4 rounded mb-4">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-surface-variant">
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider">No</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider">Nama Peran</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider">Deskripsi</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($peran)): ?>
                <tr>
                    <td colspan="4" class="py-4 text-center text-outline-variant font-body-md">Tidak ada data.</td>
                </tr>
                <?php else: ?>
                    <?php $i=1; foreach($peran as $p): ?>
                    <tr class="border-b border-surface-variant hover:bg-surface-container-low transition-colors">
                        <td class="py-3 px-4 font-body-md text-body-md text-on-surface"><?= $i++ ?></td>
                        <td class="py-3 px-4 font-data-table text-data-table text-on-surface"><?= esc($p['nama_peran']) ?></td>
                        <td class="py-3 px-4 font-body-md text-body-md text-on-surface-variant"><?= esc($p['deskripsi']) ?></td>
                        <td class="py-3 px-4 flex gap-2">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/peran/edit/' . $p['peran_id']) ?>" class="text-primary hover:text-primary-container bg-primary/10 hover:bg-primary/20 p-1.5 rounded transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/peran/delete/' . $p['peran_id']) ?>" class="text-error hover:text-error-container bg-error/10 hover:bg-error/20 p-1.5 rounded transition-colors" title="Hapus" onclick="return confirm('Yakin ingin menghapus peran ini?');">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
