<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
<h2 class="font-headline-lg text-headline-lg text-on-surface">Ringkasan Portal Berita</h2>
<button class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2 self-start md:self-auto">
<span class="material-symbols-outlined text-[18px]">add</span>
                        New Post
                    </button>
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
<span class="font-headline-xl text-headline-xl text-on-surface">2.4M</span>
<span class="font-label-sm text-label-sm text-primary bg-primary/10 px-2 py-1 rounded flex items-center gap-1 mb-1">
<span class="material-symbols-outlined text-[14px]">trending_up</span> 12%
                            </span>
</div>
</div>
<!-- Stat Card 2 -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col justify-between h-[140px]">
<div class="flex justify-between items-start">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Artikel Aktif</span>
<span class="material-symbols-outlined text-outline">article</span>
</div>
<div class="flex items-end gap-3 mt-4">
<span class="font-headline-xl text-headline-xl text-on-surface">8,432</span>
<span class="font-label-sm text-label-sm text-outline-variant mb-1">this month</span>
</div>
</div>
<!-- Stat Card 3 -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col justify-between h-[140px]">
<div class="flex justify-between items-start">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Langganan Baru</span>
<span class="material-symbols-outlined text-outline">person_add</span>
</div>
<div class="flex items-end gap-3 mt-4">
<span class="font-headline-xl text-headline-xl text-on-surface">1,204</span>
<span class="font-label-sm text-label-sm text-primary bg-primary/10 px-2 py-1 rounded flex items-center gap-1 mb-1">
<span class="material-symbols-outlined text-[14px]">trending_up</span> 4.3%
                            </span>
</div>
</div>
<!-- Stat Card 4 -->
<div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface flex flex-col justify-between h-[140px]">
<div class="flex justify-between items-start">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Menunggu Moderasi</span>
<span class="material-symbols-outlined text-outline">pending_actions</span>
</div>
<div class="flex items-end gap-3 mt-4">
<span class="font-headline-xl text-headline-xl text-on-surface">42</span>
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
<button class="text-primary font-label-sm text-label-sm hover:underline">View All</button>
</div>
<div class="flex-1 flex flex-col gap-4">
<!-- List Item -->
<div class="flex gap-4 items-start group cursor-pointer hover:bg-surface/50 p-2 -mx-2 rounded transition-colors">
<div class="w-16 h-12 bg-surface-container rounded overflow-hidden flex-shrink-0 border border-surface-variant">
<div class="w-full h-full bg-gradient-to-br from-secondary-container to-tertiary-container opacity-50"></div>
</div>
<div>
<h4 class="font-data-table text-data-table text-on-surface group-hover:text-primary transition-colors line-clamp-2">Tips Menjaga Kebersihan Lingkungan</h4>
<div class="flex items-center gap-2 mt-1">
<span class="font-label-sm text-[10px] text-outline-variant">Health</span>
<span class="w-1 h-1 rounded-full bg-outline-variant"></span>
<span class="font-label-sm text-[10px] text-outline-variant">142k views</span>
</div>
</div>
</div>
<!-- List Item -->
<div class="flex gap-4 items-start group cursor-pointer hover:bg-surface/50 p-2 -mx-2 rounded transition-colors">
<div class="w-16 h-12 bg-surface-container rounded overflow-hidden flex-shrink-0 border border-surface-variant">
<div class="w-full h-full bg-gradient-to-br from-tertiary-container to-primary-container opacity-30"></div>
</div>
<div>
<h4 class="font-data-table text-data-table text-on-surface group-hover:text-primary transition-colors line-clamp-2">Jadwal Imunisasi Bulan Ini</h4>
<div class="flex items-center gap-2 mt-1">
<span class="font-label-sm text-[10px] text-outline-variant">Program</span>
<span class="w-1 h-1 rounded-full bg-outline-variant"></span>
<span class="font-label-sm text-[10px] text-outline-variant">98k views</span>
</div>
</div>
</div>
<!-- List Item -->
<div class="flex gap-4 items-start group cursor-pointer hover:bg-surface/50 p-2 -mx-2 rounded transition-colors">
<div class="w-16 h-12 bg-surface-container rounded overflow-hidden flex-shrink-0 border border-surface-variant">
<div class="w-full h-full bg-gradient-to-br from-primary-container to-secondary-container opacity-40"></div>
</div>
<div>
<h4 class="font-data-table text-data-table text-on-surface group-hover:text-primary transition-colors line-clamp-2">Pentingnya Konsumsi Buah dan Sayur</h4>
<div class="flex items-center gap-2 mt-1">
<span class="font-label-sm text-[10px] text-outline-variant">Nutrition</span>
<span class="w-1 h-1 rounded-full bg-outline-variant"></span>
<span class="font-label-sm text-[10px] text-outline-variant">76k views</span>
</div>
</div>
</div>
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
<div class="grid grid-cols-12 gap-4 items-center py-3 hover:bg-[#eff4ff] transition-colors px-2 rounded -mx-2">
<div class="col-span-5 flex items-center gap-3">
<span class="material-symbols-outlined text-primary bg-primary/10 p-1.5 rounded-full text-[16px]">publish</span>
<span class="font-data-table text-data-table text-on-surface truncate">Tips Menjaga Kebersihan Lingkungan</span>
</div>
<div class="col-span-3 font-body-md text-body-md text-on-surface-variant">Sarah Jenkins</div>
<div class="col-span-2">
<span class="font-label-sm text-[11px] text-primary bg-primary/10 px-2 py-1 rounded border border-primary/20">Published</span>
</div>
<div class="col-span-2 font-body-md text-[13px] text-outline-variant text-right">10 min ago</div>
</div>
<div class="grid grid-cols-12 gap-4 items-center py-3 hover:bg-[#eff4ff] transition-colors px-2 rounded -mx-2 border-t border-surface-container-low">
<div class="col-span-5 flex items-center gap-3">
<span class="material-symbols-outlined text-[#d97706] bg-[#d97706]/10 p-1.5 rounded-full text-[16px]">edit_note</span>
<span class="font-data-table text-data-table text-on-surface truncate">Draft: Jadwal Imunisasi Bulan Ini</span>
</div>
<div class="col-span-3 font-body-md text-body-md text-on-surface-variant">Michael Chang</div>
<div class="col-span-2">
<span class="font-label-sm text-[11px] text-[#d97706] bg-[#d97706]/10 px-2 py-1 rounded border border-[#d97706]/20">In Review</span>
</div>
<div class="col-span-2 font-body-md text-[13px] text-outline-variant text-right">45 min ago</div>
</div>
<div class="grid grid-cols-12 gap-4 items-center py-3 hover:bg-[#eff4ff] transition-colors px-2 rounded -mx-2 border-t border-surface-container-low">
<div class="col-span-5 flex items-center gap-3">
<span class="material-symbols-outlined text-outline-variant bg-surface-container p-1.5 rounded-full text-[16px]">archive</span>
<span class="font-data-table text-data-table text-outline-variant truncate">Archived: Pentingnya Konsumsi Buah dan Sayur</span>
</div>
<div class="col-span-3 font-body-md text-body-md text-on-surface-variant">System</div>
<div class="col-span-2">
<span class="font-label-sm text-[11px] text-outline-variant bg-surface-container px-2 py-1 rounded border border-surface-variant">Archived</span>
</div>
<div class="col-span-2 font-body-md text-[13px] text-outline-variant text-right">2 hrs ago</div>
</div>
</div>
<div class="mt-4 pt-4 border-t border-surface-variant text-center">
<button class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors">View Full History</button>
</div>
</div>
</div>
<?= $this->endSection() ?>
