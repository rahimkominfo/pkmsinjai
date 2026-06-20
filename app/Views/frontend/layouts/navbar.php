<!-- TopNavBar -->
<nav class="border-b border-outline-variant dark:border-outline shadow-sm docked full-width top-0 sticky z-50" 
     style="background-color: <?= (!empty(tenant('primary_color'))) ? esc(tenant('primary_color')) : '#006c4a' ?> !important; 
            color: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?> !important;">
    <div class="flex justify-between items-center w-full px-6 py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-6">
            <a class="flex items-center gap-3 font-headline-md text-headline-md font-black tracking-tight" href="<?= base_url(tenant('pkm_slug')) ?>" 
               style="color: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?> !important;">
                <?php if(tenant('logo')): ?>
                    <img src="<?= base_url(esc(tenant('logo'))) ?>" alt="Logo" class="w-10 h-10 object-contain">
                <?php endif; ?>
                <span><?= mb_strtoupper(tenant('pkm_nama')) ?></span>
            </a>
            <div class="hidden md:flex gap-6 items-center">
                <?php 
                $menuModel = new \App\Models\MenuModel();
                $menus = $menuModel->getActiveTree(tenant('pkm_id'));
                $currentURL = rtrim(current_url(), '/');
                $homeURL = rtrim(base_url(tenant('pkm_slug')), '/');
                $isHome = ($currentURL === $homeURL);
                $activeClass = "font-bold border-b-2 pb-2";
                $inactiveClass = "opacity-80 hover:opacity-100 transition-opacity";
                $linkStyle = "color: " . ((!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff') . " !important; border-color: " . ((!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff') . " !important;";
                ?>
                <a class="<?= $isHome ? $activeClass : $inactiveClass ?> font-label-md text-label-md" href="<?= base_url(tenant('pkm_slug')) ?>" style="<?= $linkStyle ?>">Beranda</a>

                <?php 
                $renderDesktopMenu = function($items, $currentURL, $activeClass, $inactiveClass, $linkStyle) use (&$renderDesktopMenu) {
                    $bgColor = (!empty(tenant('primary_color'))) ? esc(tenant('primary_color')) : '#006c4a';
                    $onBgColor = (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff';

                    foreach ($items as $m) {
                        $href = $m['url'];
                        if ($href !== '#' && strpos($href, 'http') !== 0) {
                            $href = base_url(tenant('pkm_slug') . '/' . ltrim($href, '/'));
                        }

                        if (empty($m['children'])) {
                            $isActive = ($href !== '#' && $currentURL === rtrim($href, '/'));
                            $style = "color: {$onBgColor} !important; border-bottom:0 !important;";
                            if ($isActive) {
                                $style .= " background-color: rgba(255,255,255,0.1); font-weight: bold;";
                            }
                            echo '<a class="block w-full px-4 py-2 text-sm hover:bg-white/10 transition-colors" href="' . esc($href) . '" style="' . $style . '">' . esc($m['title']) . '</a>';
                        } else {
                            // Cek jika ada anak yang aktif
                            $isAnyChildActive = false;
                            $checkActive = function($children) use (&$checkActive, $currentURL, &$isAnyChildActive) {
                                foreach ($children as $child) {
                                    $c_href = $child['url'];
                                    if ($c_href !== '#' && strpos($c_href, 'http') !== 0) {
                                        $c_href = base_url(tenant('pkm_slug') . '/' . ltrim($c_href, '/'));
                                    }
                                    if ($c_href !== '#' && $currentURL === rtrim($c_href, '/')) {
                                        $isAnyChildActive = true;
                                        return;
                                    }
                                    if (!empty($child['children'])) $checkActive($child['children']);
                                }
                            };
                            $checkActive($m['children']);
                            $isActive = ($href !== '#' && $currentURL === rtrim($href, '/')) || $isAnyChildActive;

                            if ($m['parent_id'] === null) {
                                // Level 1 (Top Level)
                                echo '<div class="relative group">';
                                echo '<a href="' . esc($href) . '" class="' . ($isActive ? $activeClass : $inactiveClass) . ' flex items-center gap-1 font-label-md text-label-md py-2 transition-colors" style="' . $linkStyle . '">';
                                echo esc($m['title']);
                                echo '<span class="material-symbols-outlined text-[18px]">expand_more</span>';
                                echo '</a>';
                                echo '<div class="absolute left-0 mt-0 min-w-[200px] border border-white/10 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 flex flex-col py-1" style="background-color: ' . $bgColor . ' !important;">';
                                $renderDesktopMenu($m['children'], $currentURL, $activeClass, $inactiveClass, $linkStyle);
                                echo '</div></div>';
                            } else {
                                // Level 2 and deeper
                                $style = "color: {$onBgColor} !important;";
                                if ($isActive) {
                                    $style .= " background-color: rgba(255,255,255,0.1); font-weight: bold;";
                                }
                                echo '<div class="relative group/sub w-full">';
                                echo '<a href="' . esc($href) . '" class="flex items-center justify-between w-full px-4 py-2 text-sm hover:bg-white/10 transition-colors cursor-pointer" style="' . $style . '">';
                                echo '<span>' . esc($m['title']) . '</span>';
                                echo '<span class="material-symbols-outlined text-[16px]">chevron_right</span>';
                                echo '</a>';
                                echo '<div class="absolute left-full top-0 ml-px min-w-[200px] border border-white/10 rounded-md shadow-lg opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all z-[60] flex flex-col py-1" style="background-color: ' . $bgColor . ' !important;">';
                                $renderDesktopMenu($m['children'], $currentURL, $activeClass, $inactiveClass, $linkStyle);
                                echo '</div></div>';
                            }
                        }
                    }
                };
                $renderDesktopMenu($menus, $currentURL, $activeClass, $inactiveClass, $linkStyle);
                ?>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-4">
                <?php if(tenant('facebook')): ?>
                <a href="<?= esc(tenant('facebook')) ?>" target="_blank" class="transition-colors duration-200 opacity-80 hover:opacity-100" style="color: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?> !important;" title="Facebook">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <?php endif; ?>
                <?php if(tenant('instagram')): ?>
                <a href="<?= esc(tenant('instagram')) ?>" target="_blank" class="transition-colors duration-200 opacity-80 hover:opacity-100" style="color: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?> !important;" title="Instagram">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44c-.795 0-1.439-.645-1.439-1.44s.644-1.44 1.439-1.44z"/></svg>
                </a>
                <?php endif; ?>
                <?php if(tenant('youtube')): ?>
                <a href="<?= esc(tenant('youtube')) ?>" target="_blank" class="transition-colors duration-200 opacity-80 hover:opacity-100" style="color: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?> !important;" title="Youtube">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                </a>
                <?php endif; ?>
            </div>
            <!-- Hamburger Menu Button -->
            <button id="menuToggle" class="md:hidden flex items-center justify-center p-2 rounded-lg hover:bg-white/10 transition-colors" style="color: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?> !important;">
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
    <div id="menuContent" class="absolute right-0 top-0 h-full w-[280px] shadow-2xl translate-x-full transition-transform duration-300 flex flex-col" 
         style="background-color: <?= (!empty(tenant('primary_color'))) ? esc(tenant('primary_color')) : '#006c4a' ?> !important; 
                color: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?> !important;">
        <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
            <span class="font-bold uppercase tracking-wider">Menu</span>
            <button id="menuClose" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto py-6 px-4 flex flex-col gap-2">
            <a class="<?= $isHome ? 'bg-white/20 font-bold' : 'opacity-80' ?> px-4 py-3 rounded-lg flex items-center gap-3 transition-all" href="<?= base_url(tenant('pkm_slug')) ?>">
                <span class="material-symbols-outlined text-[20px]">home</span>
                Beranda
            </a>
            
            <?php 
            $renderMobileMenu = function($items, $level = 0) use (&$renderMobileMenu) {
                foreach ($items as $m) {
                    $href = $m['url'];
                    if ($href !== '#' && strpos($href, 'http') !== 0) {
                        $href = base_url(tenant('pkm_slug') . '/' . ltrim($href, '/'));
                    }
                    
                    if (empty($m['children'])) {
                        $padding = $level > 0 ? 'px-6' : 'px-4';
                        echo '<a class="opacity-80 hover:opacity-100 hover:bg-white/10 ' . $padding . ' py-3 rounded-lg flex items-center gap-3 transition-all" href="' . esc($href) . '">';
                        echo '<span class="material-symbols-outlined text-[20px]">' . ($level > 0 ? 'chevron_right' : 'link') . '</span>';
                        echo esc($m['title']);
                        echo '</a>';
                    } else {
                        echo '<div class="flex flex-col gap-1">';
                        $padding = $level > 0 ? 'px-6' : 'px-4';
                        echo '<div class="' . $padding . ' py-2 mt-2 text-[11px] uppercase tracking-[0.2em] opacity-50 font-bold">' . esc($m['title']) . '</div>';
                        $renderMobileMenu($m['children'], $level + 1);
                        echo '</div>';
                    }
                }
            };
            $renderMobileMenu($menus);
            ?>
            
            <div class="mt-8 pt-6 border-t border-white/10">
                <div class="px-4 mb-4 text-[11px] uppercase tracking-[0.2em] opacity-50 font-bold text-white">Media Sosial</div>
                <div class="flex gap-4 px-4">
                    <?php if(tenant()->facebook): ?>
                    <a href="<?= esc(tenant()->facebook) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all" title="Facebook">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if(tenant()->instagram): ?>
                    <a href="<?= esc(tenant()->instagram) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all" title="Instagram">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c.796 0 1.441.645 1.441 1.44s-.645 1.44-1.441 1.44c-.795 0-1.439-.645-1.439-1.44s.644-1.44 1.439-1.44z"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if(tenant()->youtube): ?>
                    <a href="<?= esc(tenant()->youtube) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/20 transition-all" title="Youtube">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?= base_url('login') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all font-bold">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    Portal Admin
                </a>
            </div>
        </nav>
        <div class="p-6 text-center opacity-40 text-[10px] uppercase tracking-widest font-bold">
            &copy; <?= date('Y') ?> <?= esc(tenant('pkm_nama')) ?>
        </div>
    </div>
</div>

<!-- Running Text Section -->
<?php 
$runningTextModel = new \App\Models\RunningTextModel();
$runningTexts = $runningTextModel->getActive(tenant('pkm_id'));
?>
<?php if (!empty($runningTexts)): ?>
<style {csp-style-nonce}>
    /* Ensure nested dropdowns are visible on hover */
    .group\/sub:hover > .group-hover\/sub\:visible {
        visibility: visible !important;
        opacity: 1 !important;
    }
    .marquee-wrapper {
        animation: marquee-scroll 40s linear infinite !important;
    }
    @keyframes marquee-scroll {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-50%, 0, 0); }
    }
</style>
<div class="marquee-container w-full overflow-hidden bg-surface-container-high border-b border-outline-variant py-3 relative">
    <div class="marquee-wrapper flex flex-row flex-nowrap w-max">
        <!-- Grup Pertama -->
        <div class="marquee-group flex flex-row flex-nowrap items-center shrink-0">
            <?php foreach($runningTexts as $rt): ?>
                <div class="marquee-item px-[60px] font-semibold whitespace-nowrap inline-block text-[14px]" style="color: <?= (!empty(tenant('primary_color'))) ? esc(tenant('primary_color')) : 'var(--tenant-primary)' ?>;">
                    <?= esc($rt['teks']) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Grup Kedua (Looping) -->
        <div class="marquee-group flex flex-row flex-nowrap items-center shrink-0">
            <?php foreach($runningTexts as $rt): ?>
                <div class="marquee-item px-[60px] font-semibold whitespace-nowrap inline-block text-[14px]" style="color: <?= (!empty(tenant('primary_color'))) ? esc(tenant('primary_color')) : 'var(--tenant-primary)' ?>;">
                    <?= esc($rt['teks']) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
