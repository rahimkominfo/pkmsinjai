<!-- Statistik Kesehatan Section -->
<section class="mb-section-gap bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/50">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-stack-lg gap-4">
        <div>
            <h2 class="font-headline-lg text-headline-lg mb-1 border-b-2 border-primary inline-block pb-2">Grafik Penyakit Terbanyak</h2>
            <p class="text-on-surface-variant font-body-md text-body-md">Data Jumlah Pasien Terdiagnosa</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="" method="get">
                <select name="periode" onchange="this.form.submit()" class="form-select bg-surface border border-outline-variant rounded-md text-label-md font-label-md py-2 pl-3 pr-8 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    <option value="">Seluruh Periode</option>
                    <?php foreach ($list_periode as $p): ?>
                        <?php 
                        $val = $p['periode_awal'] . '|' . $p['periode_akhir'];
                        $label = date('d/m/Y', strtotime($p['periode_awal'])) . ' - ' . date('d/m/Y', strtotime($p['periode_akhir']));
                        ?>
                        <option value="<?= $val ?>" <?= $selected_periode == $val ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
    </div>
    <!-- Bar Chart -->
    <div class="w-full h-64 mb-8 flex items-end justify-between gap-2 md:gap-4 relative px-4">
        <!-- Y-axis scale lines -->
        <div class="absolute inset-0 flex flex-col justify-between z-0 pointer-events-none opacity-20">
            <div class="w-full border-t border-outline-variant h-0"></div>
            <div class="w-full border-t border-outline-variant h-0"></div>
            <div class="w-full border-t border-outline-variant h-0"></div>
            <div class="w-full border-t border-outline-variant h-0"></div>
            <div class="w-full border-t border-outline-variant h-0"></div>
        </div>
        <!-- Y-axis labels -->
        <div class="absolute left-0 top-0 bottom-0 w-8 flex flex-col justify-between text-caption font-caption text-on-surface-variant -ml-6 py-1">
            <span><?= $max_jumlah ?></span>
            <span><?= round($max_jumlah * 0.75) ?></span>
            <span><?= round($max_jumlah * 0.5) ?></span>
            <span><?= round($max_jumlah * 0.25) ?></span>
            <span>0</span>
        </div>
        <!-- Bars -->
        <?php foreach ($penyakit as $item): ?>
        <div class="relative group w-full flex flex-col items-center justify-end h-full z-10">
            <div class="w-full max-w-[40px] bg-primary rounded-t-sm hover:bg-primary/80 transition-colors cursor-pointer" style="height: <?= $item['percent'] ?>;"></div>
            <span class="mt-2 text-caption font-caption text-on-surface font-semibold"><?= $item['kode'] ?></span>
            <!-- Tooltip -->
            <div class="absolute bottom-[calc(<?= $item['percent'] ?>+8px)] left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-caption font-caption px-3 py-2 rounded shadow-md opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all whitespace-nowrap z-20 pointer-events-none">
                <div class="font-bold"><?= $item['nama'] ?></div>
                <div>Jumlah: <?= $item['jumlah'] ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container border-b border-outline-variant">
                    <th class="py-3 px-4 font-label-md text-label-md text-on-surface">Kode</th>
                    <th class="py-3 px-4 font-label-md text-label-md text-on-surface">Nama Penyakit</th>
                    <th class="py-3 px-4 font-label-md text-label-md text-on-surface text-right">Jumlah Pasien</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface">
                <?php foreach ($penyakit as $index => $item): ?>
                <tr class="border-b border-outline-variant/50 hover:bg-surface-container-lowest transition-colors <?= $index % 2 == 1 ? 'bg-surface-bright' : '' ?>">
                    <td class="py-3 px-4 font-semibold text-primary"><?= $item['kode'] ?></td>
                    <td class="py-3 px-4"><?= $item['nama'] ?></td>
                    <td class="py-3 px-4 text-right"><?= $item['jumlah'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
