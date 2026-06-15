<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <p class="font-body-md text-on-surface-variant mt-2">Atur nomor urut antrian untuk loket atau poli yang aktif hari ini. Anda bisa mengubahnya menggunakan tombol tambah/kurang atau mengetik langsung nomornya.</p>
        <?php if (isset($list_pkm)): ?>
            <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian-loket') ?>" method="GET" class="mt-4 flex items-center gap-2">
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
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="bg-primary-container text-on-primary-container p-4 rounded mb-6 shadow-sm border border-primary/20">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-error-container text-on-error-container p-4 rounded mb-6 shadow-sm border border-error/20">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($antrian)): ?>
            <?php foreach ($antrian as $row): ?>
                <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-6 flex flex-col shadow-sm hover:shadow-md transition-shadow h-full">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white shrink-0" style="background-color: <?= esc($row['color'] ?? '#0ea5e9') ?>">
                            <span class="material-symbols-outlined text-[28px]"><?= esc($row['icon'] ?? 'confirmation_number') ?></span>
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-on-surface line-clamp-1" title="<?= esc($row['title']) ?>"><?= esc($row['title']) ?></h3>
                            <p class="text-label-sm text-outline-variant line-clamp-1"><?= esc($row['loket']) ?> &bull; <?= esc($row['petugas']) ?></p>
                            <?php if (tenant()->pkm_id === 'super'): ?>
                                <span class="inline-block mt-1 text-[10px] bg-surface-variant text-on-surface-variant px-2 py-0.5 rounded font-medium"><?= esc($row['pkm_nama'] ?? 'Unknown') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <form id="form_<?= $row['id'] ?>" action="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian-loket/update/' . $row['id']) ?>" method="POST" class="mt-auto">
                        <?= csrf_field() ?>
                        <div class="bg-surface-container p-4 rounded mb-4">
                            <label class="block text-label-sm text-on-surface-variant mb-3 text-center uppercase tracking-wider font-semibold">Nomor Antrian</label>
                            
                            <div class="flex items-center justify-center gap-3">
                                <button type="button" data-action="decrement" data-id="<?= $row['id'] ?>" class="btn-update-antrian w-12 h-12 rounded-lg bg-surface-variant hover:bg-outline-variant text-on-surface flex items-center justify-center transition-colors active:scale-95">
                                    <span class="material-symbols-outlined text-[28px]">remove</span>
                                </button>
                                
                                <input type="text" id="nomor_<?= $row['id'] ?>" name="nomor" value="<?= esc($row['nomor']) ?>" 
                                       class="w-32 h-14 text-center font-headline-lg text-headline-lg bg-surface border-2 border-surface-variant rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/20 outline-none transition-all shadow-inner">
                                
                                <button type="button" data-action="increment" data-id="<?= $row['id'] ?>" class="btn-update-antrian w-12 h-12 rounded-lg bg-primary-container hover:bg-primary hover:text-on-primary text-on-primary-container flex items-center justify-center transition-colors active:scale-95">
                                    <span class="material-symbols-outlined text-[28px]">add</span>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-primary text-on-primary py-3 rounded-lg font-label-lg hover:shadow-md hover:-translate-y-px transition-all">Update Nomor</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full p-8 text-center bg-surface-container-lowest border border-surface-variant rounded-lg">
                <span class="material-symbols-outlined text-[48px] text-outline-variant mb-4">inbox</span>
                <p class="font-body-md text-on-surface-variant">Belum ada data antrian untuk dikelola.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script {csp-script-nonce}>
document.addEventListener('DOMContentLoaded', function() {
    /**
     * Update the queue number input value intelligently.
     * It handles raw numbers ("123") and prefixes ("A-042", "B 01").
     */
    function updateNumber(id, change) {
        const input = document.getElementById('nomor_' + id);
        if (!input) return;
        
        let val = input.value.trim();
        
        if (!val) {
            input.value = change > 0 ? '1' : '0';
            document.getElementById('form_' + id).submit();
            return;
        }
        
        // Parse format e.g., "A-042", "Poli-10", "15"
        // Regex extracts non-digit prefix (if any) and the digit part
        const match = val.match(/^(.*?)(\d+)$/);
        if (match) {
            const prefix = match[1];
            const numStr = match[2];
            const len = numStr.length;
            let num = parseInt(numStr, 10);
            
            num += change;
            if (num < 0) num = 0; // Prevent negative queues
            
            let newNumStr = num.toString();
            // Maintain original leading zeros padding
            while (newNumStr.length < len) {
                newNumStr = '0' + newNumStr;
            }
            
            input.value = prefix + newNumStr;
        } else {
            // Fallback if there are no numbers at the end
            if (change > 0) input.value = val + '1';
        }
        
        // Auto-submit the form instantly
        document.getElementById('form_' + id).submit();
    }

    // Attach event listeners to all update buttons
    const buttons = document.querySelectorAll('.btn-update-antrian');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            const change = action === 'increment' ? 1 : -1;
            updateNumber(id, change);
        });
    });
});
</script>
<?= $this->endSection() ?>
