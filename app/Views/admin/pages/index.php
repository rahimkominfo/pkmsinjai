<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <div class="flex flex-col md:flex-row gap-4 items-center self-start md:self-auto">
            <?php if (isset($list_pkm)): ?>
                <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/pages') ?>" method="GET" class="flex items-center gap-2">
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
            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pages/create') ?>" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Halaman
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
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="border-b border-surface-variant text-outline-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="p-3">Judul Halaman</th>
                    <th class="p-3">Status</th>
                    <?php if (tenant()->pkm_id === 'super'): ?>
                    <th class="p-3">PKM</th>
                    <?php endif; ?>
                    <th class="p-3">Tanggal Dibuat</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $row): ?>
                    <tr class="border-b border-surface-container-low hover:bg-[#eff4ff] transition-colors">
                        <td class="p-3">
                            <div class="font-data-table text-data-table text-on-surface"><?= esc($row['judul']) ?></div>
                            <div class="font-body-sm text-body-sm text-outline-variant mt-1"><?= esc($row['slug']) ?></div>
                        </td>
                        <td class="p-3">
                            <?php if ($row['status'] === 'Diterbitkan'): ?>
                                <span class="bg-primary-container text-on-primary-container px-2 py-1 rounded text-label-sm font-label-sm">Diterbitkan</span>
                            <?php else: ?>
                                <span class="bg-surface-variant text-on-surface-variant px-2 py-1 rounded text-label-sm font-label-sm">Draf</span>
                            <?php endif; ?>
                        </td>
                        <?php if (tenant()->pkm_id === 'super'): ?>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant">
                            <?= esc($row['pkm_nama'] ?? 'Unknown') ?>
                        </td>
                        <?php endif; ?>
                        <td class="p-3 font-body-md text-body-md text-on-surface-variant"><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                        <td class="p-3 text-right">
                            <button type="button" data-url="<?= esc(base_url((tenant()->pkm_slug === 'super' && isset($row['pkm_slug']) ? $row['pkm_slug'] : tenant()->pkm_slug) . '/halaman/' . $row['slug'])) ?>" onclick="copyLink(this.getAttribute('data-url'))" class="text-on-surface-variant hover:text-primary transition-colors p-1 cursor-pointer" title="Salin Tautan">
                                <span class="material-symbols-outlined text-[20px]">link</span>
                            </button>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pages/edit/' . $row['page_uuid']) ?>" class="text-primary hover:text-primary-container transition-colors p-1 ml-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pages/delete/' . $row['page_uuid']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus halaman statis ini?')" class="text-error hover:text-error-container transition-colors p-1 ml-1" title="Hapus">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= tenant()->pkm_id === 'super' ? '5' : '4' ?>" class="p-4 text-center font-body-md text-outline-variant">Belum ada data halaman statis.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script {csp-script-nonce}>
function copyLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            alert("Tautan berhasil disalin ke clipboard!");
        }).catch(function(err) {
            console.error('Async: Could not copy text: ', err);
            fallbackCopyTextToClipboard(url);
        });
    } else {
        fallbackCopyTextToClipboard(url);
    }
}

function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    
    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        if (successful) {
            alert("Tautan berhasil disalin ke clipboard!");
        } else {
            prompt("Penyalinan otomatis gagal. Silakan salin tautan berikut secara manual:", text);
        }
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
        prompt("Penyalinan otomatis gagal. Silakan salin tautan berikut secara manual:", text);
    }

    document.body.removeChild(textArea);
}
</script>
<?= $this->endSection() ?>
