<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Manajemen Media</h2>
        <div class="flex flex-col md:flex-row gap-4 items-center self-start md:self-auto">
            <?php if (isset($list_pkm)): ?>
                <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/media') ?>" method="GET" class="flex items-center gap-2">
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
            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">upload</span>
                Unggah Media
            </button>
        </div>
    </div>

    <!-- Feedback Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-[#10b981]/10 text-[#10b981] border border-[#10b981]/20 px-4 py-3 rounded relative mb-6 font-body-md text-body-md">
            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-[#ef4444]/10 text-[#ef4444] border border-[#ef4444]/20 px-4 py-3 rounded relative mb-6 font-body-md text-body-md">
            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <!-- Media Table -->
    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg overflow-hidden level-1-surface">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-surface-variant">
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant w-16">#</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Pratinjau</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">Info File</th>
                        <?php if (tenant()->pkm_id === 'super'): ?>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">PKM</th>
                        <?php endif; ?>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant">URL File</th>
                        <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md text-on-surface">
                    <?php if (!empty($list_media) && is_array($list_media)): ?>
                        <?php foreach ($list_media as $i => $media): ?>
                            <tr class="border-b border-surface-variant hover:bg-surface-container-low transition-colors">
                                <td class="px-6 py-4"><?= $i + 1 ?></td>
                                <td class="px-6 py-4">
                                    <?php if(strpos($media['tipe_file'], 'image') !== false): ?>
                                        <img src="<?= strpos($media['url_file'], 'http') === 0 ? esc($media['url_file']) : base_url(esc($media['url_file'])) ?>" alt="<?= esc($media['nama_file']) ?>" class="h-16 w-16 object-cover rounded shadow-sm">
                                    <?php else: ?>
                                        <span class="material-symbols-outlined text-[40px] text-outline">description</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-on-surface"><?= esc($media['nama_file']) ?></div>
                                    <div class="text-on-surface-variant text-sm mt-1">
                                        <?= esc($media['tipe_file']) ?>
                                    </div>
                                    <div class="text-on-surface-variant text-xs mt-1">
                                        Diunggah: <?= date('d M Y, H:i', strtotime($media['created_at'])) ?>
                                    </div>
                                </td>
                                <?php if (tenant()->pkm_id === 'super'): ?>
                                <td class="px-6 py-4 font-body-md text-body-md text-on-surface-variant">
                                    <?= esc($media['pkm_nama'] ?? 'Unknown') ?>
                                </td>
                                <?php endif; ?>
                                <td class="px-6 py-4">
                                    <input type="text" readonly value="<?= strpos($media['url_file'], 'http') === 0 ? esc($media['url_file']) : base_url(esc($media['url_file'])) ?>" class="bg-surface-container w-full p-2 rounded text-xs border border-surface-variant cursor-text outline-none focus:border-primary" onclick="this.select()">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="navigator.clipboard.writeText('<?= base_url($media['url_file']) ?>'); alert('Link berhasil disalin!')" class="text-primary hover:bg-primary/10 p-2 rounded-full transition-colors flex items-center justify-center" title="Salin Link">
                                            <span class="material-symbols-outlined text-[20px]">content_copy</span>
                                        </button>
                                        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/media/delete/' . $media['media_id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus media ini?')" class="text-[#ef4444] hover:bg-[#ef4444]/10 p-2 rounded-full transition-colors flex items-center justify-center" title="Hapus">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= tenant()->pkm_id === 'super' ? '6' : '5' ?>" class="px-6 py-8 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] mb-2 text-outline">perm_media</span>
                                <p>Belum ada media yang diunggah.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-surface rounded-xl shadow-lg w-full max-w-md overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-surface-variant flex justify-between items-center bg-surface-container-lowest">
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Unggah Media Baru</h3>
            <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low rounded-full p-1 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/media/store') ?>" method="post" enctype="multipart/form-data" class="flex-1 flex flex-col">
            <div class="p-6 flex-1 bg-background">
                <?php if (isset($list_pkm)): ?>
                <div class="mb-4">
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Pilih PKM <span class="text-error">*</span></label>
                    <select name="pkm_id" required class="w-full bg-surface-container-lowest border border-surface-variant rounded p-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                        <option value="" disabled selected>-- Pilih PKM --</option>
                        <?php foreach ($list_pkm as $pkm): ?>
                            <option value="<?= esc($pkm['pkm_id']) ?>"><?= esc($pkm['pkm_nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <div class="mb-4">
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Pilih File (Max 10MB)</label>
                    <input type="file" name="file_media" required accept="image/*,application/pdf" class="w-full bg-surface-container-lowest border border-surface-variant rounded p-2 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                    <p class="text-xs text-on-surface-variant mt-2">Mendukung file gambar (JPG, PNG, WEBP) dan dokumen PDF.</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-surface-variant flex justify-end gap-3 bg-surface-container-lowest">
                <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-4 py-2 rounded text-primary hover:bg-primary/10 font-label-large text-label-large transition-colors">Batal</button>
                <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded font-label-large text-label-large shadow-sm hover:shadow hover:-translate-y-[1px] transition-all">Unggah</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
