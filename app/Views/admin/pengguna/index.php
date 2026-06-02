<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengguna/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2 self-start md:self-auto">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Pengguna
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
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="border-b border-surface-variant text-outline-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="p-3">Nama / Username</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Peran</th>
                    <th class="p-3">Tanggal Daftar</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr class="border-b border-surface-container-low hover:bg-[#eff4ff] transition-colors">
                        <td class="p-3">
                            <div class="font-data-table text-data-table text-on-surface"><?= esc($user['nama_publik']) ?></div>
                            <div class="font-label-sm text-label-sm text-outline-variant">@<?= esc($user['username']) ?></div>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant"><?= esc($user['email']) ?></td>
                        <td class="p-3">
                            <span class="font-label-sm text-[11px] <?= in_array($user['peran'], ['Admin Dinkes', 'Admin PKM']) ? 'text-primary bg-primary/10 border-primary/20' : 'text-[#d97706] bg-[#d97706]/10 border-[#d97706]/20' ?> px-2 py-1 rounded border">
                                <?= esc($user['peran'] ?? '-') ?>
                            </span>
                        </td>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant"><?= date('d M Y', strtotime($user['tanggal_daftar'])) ?></td>
                        <td class="p-3 text-right">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengguna/edit/' . $user['user_id']) ?>" class="text-primary hover:text-primary-container transition-colors p-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengguna/delete/' . $user['user_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" class="text-error hover:text-error-container transition-colors p-1 ml-2" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center font-body-md text-outline-variant">Belum ada data pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
