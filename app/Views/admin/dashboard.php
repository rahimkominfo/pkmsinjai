<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
<div class="mb-8 mt-2">
    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-6">Statistik Pengunjung (Antrian)</h2>
    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface overflow-x-auto shadow-sm">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="border-b border-surface-variant text-outline-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Layanan / Poli</th>
                    <th class="p-3 text-center">Nomor Terakhir</th>
                    <th class="p-3 text-center">Total Pengunjung</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logAntrian)): ?>
                    <tr>
                        <td colspan="4" class="p-4 text-center font-body-md text-outline-variant">Belum ada rekap data antrian (Ubah status antrian menjadi "SELESAI" untuk mencatat log).</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($logAntrian as $log): ?>
                    <tr class="border-b border-surface-container-low hover:bg-[#eff4ff] transition-colors">
                        <td class="p-3 font-body-md text-on-surface-variant"><?= date('d M Y', strtotime($log['tanggal'])) ?></td>
                        <td class="p-3 font-data-table text-on-surface font-semibold"><?= esc($log['title']) ?></td>
                        <td class="p-3 text-center font-headline-md text-primary font-bold"><?= esc($log['nomor_terakhir']) ?></td>
                        <td class="p-3 text-center">
                            <span class="inline-block bg-primary-container text-on-primary-container font-headline-sm px-4 py-1 rounded-full border border-primary/20">
                                <?= esc($log['total_pengunjung']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 mt-12 border-t border-surface-variant pt-8">
<h2 class="font-headline-lg text-headline-lg text-on-surface">Ringkasan Portal Berita</h2>

</div>
<!-- Stats Grid (Bento Style approach for top row) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-gutter">
<!-- Stat Card 1 -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col justify-between h-[140px]">
<div class="flex justify-between items-start">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total Pembaca</span>
<span class="material-symbols-outlined text-outline">visibility</span>
</div>
<div class="flex items-end gap-3 mt-4">
<span class="font-headline-xl text-headline-xl text-on-surface"><?= number_format($totalPembaca) ?></span>
</div>
</div>
<!-- Stat Card 2 -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col justify-between h-[140px]">
<div class="flex justify-between items-start">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Artikel Aktif</span>
<span class="material-symbols-outlined text-outline">article</span>
</div>
<div class="flex items-end gap-3 mt-4">
<span class="font-headline-xl text-headline-xl text-on-surface"><?= number_format($artikelAktif) ?></span>
<span class="font-label-sm text-label-sm text-outline-variant mb-1">this month</span>
</div>
</div>
<!-- Stat Card 3 -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col justify-between h-[140px]">
<div class="flex justify-between items-start">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total Pengguna</span>
<span class="material-symbols-outlined text-outline">group</span>
</div>
<div class="flex items-end gap-3 mt-4">
<span class="font-headline-xl text-headline-xl text-on-surface"><?= number_format($totalPengguna) ?></span>
</div>
</div>
<!-- Stat Card 4 -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col justify-between h-[140px]">
<div class="flex justify-between items-start">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Menunggu Moderasi</span>
<span class="material-symbols-outlined text-outline">pending_actions</span>
</div>
<div class="flex items-end gap-3 mt-4">
<span class="font-headline-xl text-headline-xl text-on-surface"><?= number_format($menungguModerasi) ?></span>
<span class="font-label-sm text-label-sm text-[#d97706] bg-[#d97706]/10 px-2 py-1 rounded mb-1">Needs attention</span>
</div>
</div>
</div>
<!-- Middle Section Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter mb-gutter">
<!-- Chart Placeholder -->
<div class="lg:col-span-8 bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface min-h-[400px] flex flex-col">
<div class="flex justify-between items-center mb-6">
<h3 class="font-headline-md text-headline-md text-on-surface">Tren Pembaca Mingguan</h3>
<select class="bg-surface border-none text-on-surface-variant font-label-sm text-label-sm focus:ring-0 cursor-pointer">
<option>Last 7 Days</option>
<option>Last 30 Days</option>
</select>
</div>
<!-- Stylized Chart Area -->
<div class="flex-1 w-full bg-[linear-gradient(to_right,#f2f4f6_1px,transparent_1px),linear-gradient(to_bottom,#f2f4f6_1px,transparent_1px)] bg-[size:40px_40px] relative rounded flex items-end">
<div class="absolute inset-0 flex items-center justify-center pointer-events-none">
<span class="text-outline-variant font-body-md text-body-md bg-surface-container-lowest px-4 py-2 rounded shadow-sm border border-surface-variant">Interactive Chart Canvas</span>
</div>
<!-- Mock Bars -->
<div class="w-full flex justify-between items-end px-4 md:px-8 h-4/5 gap-2 md:gap-4 opacity-40">
<div class="w-full bg-primary/20 rounded-t h-[40%]"></div>
<div class="w-full bg-primary/40 rounded-t h-[65%]"></div>
<div class="w-full bg-primary/30 rounded-t h-[50%]"></div>
<div class="w-full bg-primary/60 rounded-t h-[80%]"></div>
<div class="w-full bg-primary/80 rounded-t h-[100%]"></div>
<div class="w-full bg-primary/50 rounded-t h-[70%]"></div>
<div class="w-full bg-primary/30 rounded-t h-[45%]"></div>
</div>
</div>
</div>
<!-- Top Performing Posts -->
<div class="lg:col-span-4 bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col">
<div class="flex justify-between items-center mb-6">
<h3 class="font-headline-md text-headline-md text-on-surface">Berita Terpopuler</h3>
<a href="<?= base_url('admin/' . tenant()->pkm_slug . '/artikel') ?>" class="text-primary font-label-sm text-label-sm hover:underline">View All</a>
</div>
<div class="flex-1 flex flex-col gap-4">
<?php if(empty($beritaPopuler)): ?>
    <div class="p-4 text-center text-outline-variant font-body-md text-body-md">Belum ada berita terpopuler.</div>
<?php else: ?>
    <?php foreach($beritaPopuler as $bp): ?>
    <!-- List Item -->
    <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/artikel/edit/' . $bp['artikel_id']) ?>" class="flex gap-4 items-start group hover:bg-surface/50 p-2 -mx-2 rounded transition-colors">
        <div class="w-16 h-12 bg-surface-container rounded overflow-hidden flex-shrink-0 border border-surface-variant">
            <?php if($bp['gambar_utama']): ?>
                <img src="<?= strpos($bp['gambar_utama'], 'http') === 0 ? esc($bp['gambar_utama']) : base_url(esc($bp['gambar_utama'])) ?>" class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-secondary-container to-tertiary-container opacity-50"></div>
            <?php endif; ?>
        </div>
        <div class="flex-1">
            <h4 class="font-data-table text-data-table text-on-surface group-hover:text-primary transition-colors line-clamp-2" title="<?= esc($bp['judul']) ?>"><?= esc($bp['judul']) ?></h4>
            <div class="flex items-center gap-2 mt-1">
                <span class="font-label-sm text-[10px] text-outline-variant"><?= date('d M Y', strtotime($bp['tanggal_publikasi'])) ?></span>
                <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
                <span class="font-label-sm text-[10px] text-outline-variant"><?= number_format($bp['jumlah_tayang']) ?> views</span>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>
<!-- Bottom Section: Activity Feed -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface overflow-x-auto">
<h3 class="font-headline-md text-headline-md text-on-surface mb-6">Aktivitas Berita Terkini</h3>
<div class="flex flex-col min-w-[600px]">
<!-- Header Row -->
<div class="grid grid-cols-12 gap-4 pb-3 border-b border-surface-variant mb-4 px-2">
<div class="col-span-5 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider">Action / Article</div>
<div class="col-span-3 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider">Editor</div>
<div class="col-span-2 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider">Status</div>
<div class="col-span-2 font-label-sm text-label-sm text-outline-variant uppercase tracking-wider text-right">Time</div>
</div>
<!-- Feed Rows -->
<?php if(empty($aktivitasTerkini)): ?>
    <div class="p-4 text-center text-outline-variant font-body-md text-body-md">Belum ada aktivitas.</div>
<?php else: ?>
    <?php foreach($aktivitasTerkini as $at): ?>
    <div class="grid grid-cols-12 gap-4 items-center py-3 hover:bg-[#eff4ff] transition-colors px-2 rounded -mx-2 border-t border-surface-container-low">
        <div class="col-span-5 flex items-center gap-3">
            <?php if($at['status'] == 'Ditayangkan'): ?>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-1.5 rounded-full text-[16px]">publish</span>
            <?php elseif($at['status'] == 'Draf'): ?>
                <span class="material-symbols-outlined text-[#d97706] bg-[#d97706]/10 p-1.5 rounded-full text-[16px]">edit_note</span>
            <?php else: ?>
                <span class="material-symbols-outlined text-outline-variant bg-surface-container p-1.5 rounded-full text-[16px]">archive</span>
            <?php endif; ?>
            <span class="font-data-table text-data-table text-on-surface truncate" title="<?= esc($at['judul']) ?>"><?= esc($at['judul']) ?></span>
        </div>
        <div class="col-span-3 font-body-md text-body-md text-on-surface-variant truncate"><?= esc($at['penulis_nama'] ?? 'System') ?></div>
        <div class="col-span-2">
            <?php if($at['status'] == 'Ditayangkan'): ?>
                <span class="font-label-sm text-[11px] text-primary bg-primary/10 px-2 py-1 rounded border border-primary/20">Published</span>
            <?php elseif($at['status'] == 'Draf'): ?>
                <span class="font-label-sm text-[11px] text-[#d97706] bg-[#d97706]/10 px-2 py-1 rounded border border-[#d97706]/20">In Review</span>
            <?php else: ?>
                <span class="font-label-sm text-[11px] text-outline-variant bg-surface-container px-2 py-1 rounded border border-surface-variant">Archived</span>
            <?php endif; ?>
        </div>
        <div class="col-span-2 font-body-md text-[13px] text-outline-variant text-right"><?= date('d M Y, H:i', strtotime($at['updated_at'])) ?></div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
<div class="mt-4 pt-4 border-t border-surface-variant text-center">
<button class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors">View Full History</button>
</div>
</div>
</div>
<?= $this->endSection() ?>
