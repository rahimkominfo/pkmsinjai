<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface">Statistik Penyakit</h2>
        <p class="text-body-md text-on-surface-variant">Manajemen data statistik penyakit dari file Excel.</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="mb-6 p-4 bg-success-container text-on-success-container rounded-lg flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    <p class="font-label-md"><?= session()->getFlashdata('success') ?></p>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="mb-6 p-4 bg-error-container text-on-error-container rounded-lg flex items-center gap-3">
    <span class="material-symbols-outlined">error</span>
    <p class="font-label-md"><?= session()->getFlashdata('error') ?></p>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Import Form -->
    <div class="lg:col-span-1">
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant">
            <h3 class="font-title-md text-title-md text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">upload_file</span>
                Import Data Excel
            </h3>
            <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/statistik/import') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-6">
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="file_excel">
                        Pilih File (.xlsx / .xls)
                    </label>
                    <input type="file" name="file_excel" id="file_excel" accept=".xlsx, .xls" required
                           class="block w-full text-body-md text-on-surface-variant
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-label-md file:font-label-md
                                  file:bg-primary file:text-on-primary
                                  hover:file:bg-primary/90 transition-all
                                  cursor-pointer border border-outline-variant rounded-md p-1">
                    <p class="mt-2 text-caption font-caption text-on-surface-variant">
                        Pastikan format file sesuai dengan template standar laporan penyakit.
                    </p>
                </div>
                <button type="submit" class="w-full bg-primary text-on-primary font-label-md text-label-md py-3 rounded-md flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors shadow-sm">
                    <span class="material-symbols-outlined">import_export</span>
                    Mulai Import
                </button>
            </form>
        </div>
    </div>

    <!-- Data List -->
    <div class="lg:col-span-2">
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant overflow-hidden">
            <div class="p-6 border-b border-outline-variant flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface">Data Terimport</h3>
                    <span class="bg-primary/10 text-primary text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Total: <?= count($statistik) ?> Baris
                    </span>
                </div>
                
                <!-- Filter Periode -->
                <form action="" method="get" class="flex items-center gap-2">
                    <select name="periode" onchange="this.form.submit()" class="bg-surface border border-outline-variant rounded-md px-3 py-1.5 font-label-sm text-label-sm outline-none focus:ring-1 focus:ring-primary transition-all">
                        <option value="">Semua Periode</option>
                        <?php foreach ($list_periode as $p): ?>
                            <?php 
                            $val = $p['periode_awal'] . '|' . $p['periode_akhir'];
                            $label = date('d/m/Y', strtotime($p['periode_awal'])) . ' - ' . date('d/m/Y', strtotime($p['periode_akhir']));
                            ?>
                            <option value="<?= $val ?>" <?= $filter_periode == $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($filter_periode): ?>
                        <a href="<?= current_url() ?>" class="text-error hover:text-error-container p-1" title="Reset Filter">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container border-b border-outline-variant">
                            <th class="py-3 px-6 font-label-md text-label-md text-on-surface">Kode</th>
                            <th class="py-3 px-6 font-label-md text-label-md text-on-surface">Diagnosa</th>
                            <th class="py-3 px-6 font-label-md text-label-md text-on-surface text-center">Total</th>
                            <th class="py-3 px-6 font-label-md text-label-md text-on-surface text-right">Periode</th>
                        </tr>
                    </thead>
                    <tbody class="font-body-md text-body-md text-on-surface">
                        <?php if (empty($statistik)): ?>
                        <tr>
                            <td colspan="4" class="py-12 px-6 text-center text-on-surface-variant italic">
                                Belum ada data statistik yang diimport.
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($statistik as $item): ?>
                            <tr class="border-b border-outline-variant/50 hover:bg-surface-container-low transition-colors">
                                <td class="py-3 px-6 font-semibold text-primary"><?= esc($item['kode_diagnosa']) ?></td>
                                <td class="py-3 px-6"><?= esc($item['diagnosa']) ?></td>
                                <td class="py-3 px-6 text-center">
                                    <span class="font-bold"><?= $item['total'] ?></span>
                                    <div class="text-[10px] text-on-surface-variant">L: <?= $item['jumlah_lk'] ?> | P: <?= $item['jumlah_pr'] ?></div>
                                </td>
                                <td class="py-3 px-6 text-right text-label-sm font-label-sm whitespace-nowrap">
                                    <?= date('d M Y', strtotime($item['periode_awal'])) ?> - <br>
                                    <?= date('d M Y', strtotime($item['periode_akhir'])) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
