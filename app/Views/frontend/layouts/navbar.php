<!-- TopNavBar -->
<nav class="border-b border-outline-variant dark:border-outline shadow-sm docked full-width top-0 sticky z-50" style="background-color: var(--tenant-primary); color: var(--tenant-on-primary);">
    <div class="flex justify-between items-center w-full px-6 py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-6">
            <a class="font-headline-md text-headline-md font-black tracking-tight" href="<?= base_url(tenant()->pkm_slug) ?>" style="color: var(--tenant-on-primary);"><?= mb_strtoupper(tenant()->pkm_nama) ?></a>
            <div class="hidden md:flex gap-6 items-center">
                <?php 
                $menuModel = new \App\Models\MenuModel();
                $menus = $menuModel->getActiveTree(tenant()->pkm_id);
                $currentURL = rtrim(current_url(), '/');
                $homeURL = rtrim(base_url(tenant()->pkm_slug), '/');
                $isHome = ($currentURL === $homeURL);
                $activeClass = "font-bold border-b-2 pb-2";
                $inactiveClass = "opacity-80 hover:opacity-100 transition-opacity";
                $linkStyle = "color: var(--tenant-on-primary); border-color: var(--tenant-on-primary);";
                ?>
                <a class="<?= $isHome ? $activeClass : $inactiveClass ?> font-label-md text-label-md" href="<?= base_url(tenant()->pkm_slug) ?>" style="<?= $linkStyle ?>">Beranda</a>

                <?php foreach($menus as $m): ?>
                    <?php if (empty($m['children'])): ?>
                        <?php 
                        $href = $m['url'];
                        if ($href !== '#' && strpos($href, 'http') !== 0) {
                            $href = base_url(tenant()->pkm_slug . '/' . ltrim($href, '/'));
                        }
                        $isActive = ($href !== '#' && $currentURL === rtrim($href, '/'));
                        ?>
                        <a class="<?= $isActive ? $activeClass : $inactiveClass ?> font-label-md text-label-md" href="<?= esc($href) ?>" style="<?= $linkStyle ?>"><?= esc($m['title']) ?></a>
                    <?php else: ?>
                        <div class="relative group">
                            <?php 
                            $href = $m['url'];
                            if ($href !== '#' && strpos($href, 'http') !== 0) {
                                $href = base_url(tenant()->pkm_slug . '/' . ltrim($href, '/'));
                            }
                            $isParentActive = false;
                            foreach ($m['children'] as $child) {
                                $c_href = $child['url'];
                                if ($c_href !== '#' && strpos($c_href, 'http') !== 0) {
                                    $c_href = base_url(tenant()->pkm_slug . '/' . ltrim($c_href, '/'));
                                }
                                if ($c_href !== '#' && $currentURL === rtrim($c_href, '/')) {
                                    $isParentActive = true;
                                    break;
                                }
                            }
                            $isActive = ($href !== '#' && $currentURL === rtrim($href, '/')) || $isParentActive;
                            ?>
                            <a href="<?= esc($href) ?>" class="<?= $isActive ? $activeClass : $inactiveClass ?> flex items-center gap-1 font-label-md text-label-md py-2" style="<?= $linkStyle ?>">
                                <?= esc($m['title']) ?>
                                <span class="material-symbols-outlined text-[18px]">expand_more</span>
                            </a>
                            <div class="absolute left-0 mt-0 min-w-[200px] bg-white dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 whitespace-nowrap">
                                <?php foreach($m['children'] as $child): ?>
                                    <?php 
                                    $c_href = $child['url'];
                                    if ($c_href !== '#' && strpos($c_href, 'http') !== 0) {
                                        $c_href = base_url(tenant()->pkm_slug . '/' . ltrim($c_href, '/'));
                                    }
                                    $isChildActive = ($c_href !== '#' && $currentURL === rtrim($c_href, '/'));
                                    ?>
                                    <a href="<?= esc($c_href) ?>" class="block px-4 py-2 text-sm <?= $isChildActive ? 'text-primary bg-surface-container-low font-bold' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' ?>"><?= esc($child['title']) ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="transition-colors duration-200 hidden md:block opacity-80 hover:opacity-100" style="color: var(--tenant-on-primary);">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">account_circle</span>
            </button>
            <!-- Hamburger Menu Button -->
            <button id="menuToggle" class="md:hidden flex items-center justify-center p-2 rounded-lg hover:bg-white/10 transition-colors" style="color: var(--tenant-on-primary);">
                <span class="material-symbols-outlined text-[28px]">menu</span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu Sidebar -->
<div id="mobileMenu" class="fixed inset-0 z-[60] hidden">
    <!-- Backdrop -->
    <div id="menuBackdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <!-- Sidebar Content -->
    <div id="menuContent" class="absolute right-0 top-0 h-full w-[280px] shadow-2xl translate-x-full transition-transform duration-300 flex flex-col" style="background-color: var(--tenant-primary); color: var(--tenant-on-primary);">
        <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
            <span class="font-bold uppercase tracking-wider">Menu</span>
            <button id="menuClose" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto py-6 px-4 flex flex-col gap-2">
            <a class="<?= $isHome ? 'bg-white/20 font-bold' : 'opacity-80' ?> px-4 py-3 rounded-lg flex items-center gap-3 transition-all" href="<?= base_url(tenant()->pkm_slug) ?>">
                <span class="material-symbols-outlined text-[20px]">home</span>
                Beranda
            </a>
            
            <?php foreach($menus as $m): ?>
                <?php 
                $href = $m['url'];
                if ($href !== '#' && strpos($href, 'http') !== 0) {
                    $href = base_url(tenant()->pkm_slug . '/' . ltrim($href, '/'));
                }
                ?>
                <?php if (empty($m['children'])): ?>
                    <a class="opacity-80 hover:opacity-100 hover:bg-white/10 px-4 py-3 rounded-lg flex items-center gap-3 transition-all" href="<?= esc($href) ?>">
                        <span class="material-symbols-outlined text-[20px]">link</span>
                        <?= esc($m['title']) ?>
                    </a>
                <?php else: ?>
                    <div class="flex flex-col gap-1">
                        <div class="px-4 py-2 mt-2 text-[11px] uppercase tracking-[0.2em] opacity-50 font-bold"><?= esc($m['title']) ?></div>
                        <?php foreach($m['children'] as $child): ?>
                            <?php 
                            $c_href = $child['url'];
                            if ($c_href !== '#' && strpos($c_href, 'http') !== 0) {
                                $c_href = base_url(tenant()->pkm_slug . '/' . ltrim($c_href, '/'));
                            }
                            ?>
                            <a class="opacity-80 hover:opacity-100 hover:bg-white/10 px-6 py-3 rounded-lg flex items-center gap-3 transition-all" href="<?= esc($c_href) ?>">
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                <?= esc($child['title']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <div class="mt-8 pt-6 border-t border-white/10">
                <a href="<?= base_url('login') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all font-bold">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    Portal Admin
                </a>
            </div>
        </nav>
        <div class="p-6 text-center opacity-40 text-[10px] uppercase tracking-widest font-bold">
            &copy; <?= date('Y') ?> <?= esc(tenant()->pkm_nama) ?>
        </div>
    </div>
</div>

<!-- Running Text Section -->
<?php 
$runningTextModel = new \App\Models\RunningTextModel();
$runningTexts = $runningTextModel->getActive(tenant()->pkm_id);
?>
<?php if (!empty($runningTexts)): ?>
<div class="w-full overflow-hidden py-2 bg-surface-container-high border-b border-outline-variant">
    <div class="flex whitespace-nowrap animate-scroll-text hover:[animation-play-state:paused] cursor-default">
        <?php foreach($runningTexts as $rt): ?>
            <span class="inline-block px-10 text-body-md font-medium text-primary uppercase tracking-wide">
                <?= esc($rt['teks']) ?>
            </span>
        <?php endforeach; ?>
        <!-- Duplicate for seamless loop if content is short -->
        <?php if (count($runningTexts) < 3): ?>
            <?php foreach($runningTexts as $rt): ?>
                <span class="inline-block px-10 text-body-md font-medium text-primary uppercase tracking-wide">
                    <?= esc($rt['teks']) ?>
                </span>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
