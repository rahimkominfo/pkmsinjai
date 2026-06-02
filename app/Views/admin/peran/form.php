<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>
<div class="max-w-[600px] mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/peran') ?>" class="text-on-surface-variant hover:bg-surface-container-low rounded-full p-2 transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        </div>
    </div>

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface">
        <form action="<?= base_url('admin/' . tenant()->pkm_slug . '/peran/' . (isset($peran) ? 'update/'.$peran['peran_id'] : 'store')) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-6">
                <label class="block font-label-md text-label-md text-on-surface mb-2" for="nama_peran">Nama Peran <span class="text-error">*</span></label>
                <input type="text" id="nama_peran" name="nama_peran" value="<?= old('nama_peran', $peran['nama_peran'] ?? '') ?>" class="w-full px-4 py-2 bg-surface border <?= isset($validation) && $validation->hasError('nama_peran') ? 'border-error focus:ring-error' : 'border-outline-variant focus:border-primary focus:ring-primary' ?> rounded outline-none focus:ring-1 transition-all text-body-md" required>
                <?php if(isset($validation) && $validation->hasError('nama_peran')): ?>
                    <p class="font-label-sm text-label-sm text-error mt-1"><?= $validation->getError('nama_peran') ?></p>
                <?php endif; ?>
            </div>
            
            <div class="mb-6">
                <label class="block font-label-md text-label-md text-on-surface mb-2" for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-2 bg-surface border <?= isset($validation) && $validation->hasError('deskripsi') ? 'border-error focus:ring-error' : 'border-outline-variant focus:border-primary focus:ring-primary' ?> rounded outline-none focus:ring-1 transition-all text-body-md"><?= old('deskripsi', $peran['deskripsi'] ?? '') ?></textarea>
                <?php if(isset($validation) && $validation->hasError('deskripsi')): ?>
                    <p class="font-label-sm text-label-sm text-error mt-1"><?= $validation->getError('deskripsi') ?></p>
                <?php endif; ?>
            </div>
            
            <div class="flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/peran') ?>" class="px-4 py-2 rounded font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 rounded font-label-md text-label-md bg-primary text-on-primary hover:shadow-sm hover:-translate-y-[1px] transition-all">
                    <?= isset($peran) ? 'Simpan Perubahan' : 'Tambah Peran' ?>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
