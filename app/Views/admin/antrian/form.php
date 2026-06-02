<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-error-container text-on-error-container p-4 rounded mb-6">
            <ul class="list-disc ml-5">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface max-w-4xl">
        <form action="<?= isset($antrian) ? base_url('admin/' . tenant()->pkm_slug . '/antrian/update/' . $antrian['id']) : base_url('admin/' . tenant()->pkm_slug . '/antrian/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Judul Layanan <span class="text-error">*</span></label>
                    <input type="text" id="title" name="title" value="<?= old('title', $antrian['title'] ?? '') ?>" placeholder="Cth: Poli Umum" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- Hak Akses Peran -->
                <div>
                    <label for="peran_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Hak Akses Petugas <span class="text-error">*</span></label>
                    <select id="peran_id" name="peran_id" required class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="">-- Pilih Hak Akses --</option>
                        <?php if(isset($peran)): ?>
                            <?php foreach($peran as $p): ?>
                                <option value="<?= $p['peran_id'] ?>" <?= old('peran_id', $antrian['peran_id'] ?? '') == $p['peran_id'] ? 'selected' : '' ?>>
                                    <?= esc($p['nama_peran']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Nomor -->
                <div>
                    <label for="nomor" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nomor Antrian <span class="text-error">*</span></label>
                    <input type="text" id="nomor" name="nomor" value="<?= old('nomor', $antrian['nomor'] ?? '') ?>" placeholder="Cth: A012" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all font-bold text-primary">
                </div>

                <!-- Loket -->
                <div>
                    <label for="loket" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Loket <span class="text-error">*</span></label>
                    <input type="text" id="loket" name="loket" value="<?= old('loket', $antrian['loket'] ?? '') ?>" placeholder="Cth: Loket 1" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- Petugas -->
                <div>
                    <label for="petugas" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Petugas/Dokter <span class="text-error">*</span></label>
                    <input type="text" id="petugas" name="petugas" value="<?= old('petugas', $antrian['petugas'] ?? '') ?>" placeholder="Cth: Dr. Andi" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Status <span class="text-error">*</span></label>
                    <select id="status" name="status" required class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="menunggu" <?= old('status', $antrian['status'] ?? '') === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="dilayani" <?= old('status', $antrian['status'] ?? '') === 'dilayani' ? 'selected' : '' ?>>Sedang Dilayani</option>
                        <option value="selesai" <?= old('status', $antrian['status'] ?? '') === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="batal" <?= old('status', $antrian['status'] ?? '') === 'batal' ? 'selected' : '' ?>>Batal</option>
                    </select>
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Tanggal <span class="text-error">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" value="<?= old('tanggal', $antrian['tanggal'] ?? date('Y-m-d')) ?>" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                </div>

                <!-- Desain UI Ekstra -->
                <div class="md:col-span-2 border-t border-surface-variant pt-4 mt-2">
                    <h4 class="font-label-sm text-label-sm uppercase tracking-wider text-outline-variant mb-4">Pengaturan Visual (Opsional)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Warna -->
                        <div>
                            <label for="color" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Kode Warna Latar (HEX)</label>
                            <input type="color" id="color" name="color" value="<?= old('color', $antrian['color'] ?? '#006c4a') ?>"
                                class="w-full h-10 bg-surface border border-surface-variant rounded focus:border-primary outline-none cursor-pointer p-1">
                        </div>

                        <!-- Ikon -->
                        <div>
                            <label for="icon" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Ikon Material</label>
                            <input type="text" id="icon" name="icon" value="<?= old('icon', $antrian['icon'] ?? 'medication') ?>" placeholder="Cth: medication, personal_injury, mask"
                                class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                            <p class="text-[12px] text-outline mt-1">Referensi: <a href="https://fonts.google.com/icons" target="_blank" class="text-primary hover:underline">Google Material Icons</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Antrian
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
