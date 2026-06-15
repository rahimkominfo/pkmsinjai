<footer class="bg-inverse-surface text-inverse-on-surface py-12">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Info Kontak & Sosial Media -->
        <div class="space-y-8">
            <div>
                <h3 class="font-headline-md text-2xl font-bold mb-6 text-primary-fixed">Hubungi Kami</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-primary-fixed mt-1">location_on</span>
                        <div>
                            <p class="font-label-md text-label-md uppercase opacity-60 mb-1">Alamat</p>
                            <p class="font-body-md"><?= esc(tenant('alamat') ?? 'Alamat Belum Diatur') ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-primary-fixed mt-1">mail</span>
                        <div>
                            <p class="font-label-md text-label-md uppercase opacity-60 mb-1">Email</p>
                            <p class="font-body-md"><?= esc(tenant('email') ?? '-') ?></p>
                        </div>
                    </div>
                    <?php if(tenant('telepon')): ?>
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-primary-fixed mt-1">call</span>
                        <div>
                            <p class="font-label-md text-label-md uppercase opacity-60 mb-1">Telepon / WA</p>
                            <p class="font-body-md"><?= esc(tenant('telepon')) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div>
                <h4 class="font-label-md text-label-md uppercase tracking-widest mb-4 opacity-70">Media Sosial</h4>
                <div class="flex gap-4">
                    <!-- Facebook -->
                    <?php if(tenant('facebook')): ?>
                    <a href="<?= esc(tenant('facebook')) ?>" target="_blank" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all group" title="Facebook">
                        <svg class="w-6 h-6 fill-current text-white group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <?php endif; ?>
                    <!-- Instagram -->
                    <?php if(tenant('instagram')): ?>
                    <a href="<?= esc(tenant('instagram')) ?>" target="_blank" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all group" title="Instagram">
                        <svg class="w-6 h-6 fill-current text-white group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44c-.795 0-1.439-.645-1.439-1.44s.644-1.44 1.439-1.44z"/></svg>
                    </a>
                    <?php endif; ?>
                    <!-- Youtube -->
                    <?php if(tenant('youtube')): ?>
                    <a href="<?= esc(tenant('youtube')) ?>" target="_blank" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-all group" title="Youtube">
                        <svg class="w-6 h-6 fill-current text-white group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Peta Lokasi -->
        <div class="h-80 md:h-full min-h-[350px] rounded-2xl overflow-hidden shadow-2xl border border-white/10">
            <?php if(tenant('google_maps')): ?>
            <iframe src="<?= esc(tenant('google_maps')) ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <?php else: ?>
            <div class="w-full h-full bg-white/5 flex items-center justify-center text-white/50 font-body-md text-center px-4">
                Peta lokasi belum diatur.<br>Silakan lengkapi URL Embed Google Maps di Pengaturan PKM.
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 opacity-60">
        <p class="font-caption text-caption text-center md:text-left">&copy; <?= date('Y') ?> <?= esc(tenant('pkm_nama') ?? 'Puskesmas') ?>. Hak Cipta Dilindungi.</p>
        <div class="flex gap-6 font-caption text-caption">
            <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
            <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
        </div>
    </div>
</footer>
