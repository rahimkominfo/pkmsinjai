<section class="bg-surface-container-low border-b border-outline-variant/30 py-4">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-2">
            <div class="flex items-center gap-3">
                <h2 class="font-headline-md text-xl font-bold text-on-surface">Status Antrian Hari Ini</h2>
                <div class="flex items-center gap-2 bg-white/50 px-3 py-1 rounded-full border border-outline-variant/50">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-pulse-green absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-600"></span>
                    </span>
                    <span class="text-caption font-label-md text-on-surface-variant">Live Update: <?= $last_update ?></span>
                </div>
            </div>
            <p class="text-caption text-on-surface-variant hidden md:block italic">Nomor antrian yang sedang dilayani saat ini</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php foreach ($antrian as $item): ?>
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
                <div class="bg-<?= $item['color'] ?>-50 border-b border-<?= $item['color'] ?>-100 p-4 flex justify-between items-center">
                    <div>
                        <h3 class="font-headline-md text-<?= $item['color'] ?>-900 text-lg font-bold"><?= $item['title'] ?></h3>
                        <p class="text-<?= $item['color'] ?>-700 font-label-md text-sm"><?= $item['loket'] ?></p>
                    </div>
                    <div class="bg-<?= $item['color'] ?>-100 text-<?= $item['color'] ?>-800 p-2 rounded-lg">
                        <span class="material-symbols-outlined"><?= $item['icon'] ?></span>
                    </div>
                </div>
                <div class="p-6 flex flex-col items-center justify-center border-b border-outline-variant/30 relative">
                    <?php if (isset($item['is_idle']) && $item['is_idle']): ?>
                        <span class="absolute top-2 right-2 text-xs font-semibold bg-surface-container-high text-on-surface-variant px-2 py-1 rounded-full">Selesai</span>
                        <p class="text-on-surface-variant font-label-md mb-1 text-center">Jumlah Peserta<br>Dilayani</p>
                        <div class="text-5xl font-black text-on-surface-variant tracking-tight mt-1"><?= (int) preg_replace('/[^0-9]/', '', $item['nomor']) ?></div>
                    <?php else: ?>
                        <span class="absolute top-2 right-2 text-xs font-semibold bg-<?= $item['color'] ?>-100 text-<?= $item['color'] ?>-700 px-2 py-1 rounded-full animate-pulse">Melayani</span>
                        <p class="text-on-surface-variant font-label-md mb-1">Nomor Antrian</p>
                        <div class="text-5xl font-black text-<?= $item['color'] ?>-600 tracking-tight"><?= $item['nomor'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="p-4 bg-<?= $item['color'] ?>-50/50 flex items-center gap-3 mt-auto">
                    <div class="w-10 h-10 rounded-full bg-<?= $item['color'] ?>-200 overflow-hidden border-2 border-white shadow-sm flex-shrink-0 flex items-center justify-center">
                        <?php if (isset($item['img'])): ?>
                            <img alt="<?= $item['petugas'] ?>" class="w-full h-full object-cover" src="<?= $item['img'] ?>"/>
                        <?php else: ?>
                            <span class="material-symbols-outlined text-<?= $item['color'] ?>-600 text-lg">person</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-xs text-on-surface-variant font-medium">Petugas</p>
                        <p class="font-semibold text-sm text-on-surface"><?= $item['petugas'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
