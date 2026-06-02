<!-- TopNavBar -->
<nav class="bg-surface-container-lowest dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm docked full-width top-0 sticky z-50">
    <div class="flex justify-between items-center w-full px-6 py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-6">
            <a class="font-headline-md text-headline-md font-black tracking-tight text-on-surface dark:text-on-primary-fixed" href="<?= base_url(tenant()->pkm_slug) ?>"><?= mb_strtoupper(tenant()->pkm_nama) ?></a>
            <div class="hidden md:flex gap-6 items-center">
                <?php 
                $menuModel = new \App\Models\MenuModel();
                $menus = $menuModel->getActiveTree(tenant()->pkm_id);
                $currentURL = rtrim(current_url(), '/');
                $homeURL = rtrim(base_url(tenant()->pkm_slug), '/');
                $isHome = ($currentURL === $homeURL);
                $activeClass = "text-primary dark:text-primary-fixed font-bold border-b-2 border-primary dark:border-primary-fixed pb-2";
                $inactiveClass = "text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors";
                ?>
                <a class="<?= $isHome ? $activeClass : $inactiveClass ?> font-label-md text-label-md" href="<?= base_url(tenant()->pkm_slug) ?>">Beranda</a>

                <?php foreach($menus as $m): ?>
                    <?php if (empty($m['children'])): ?>
                        <?php 
                        $href = $m['url'];
                        if ($href !== '#' && strpos($href, 'http') !== 0) {
                            $href = base_url(tenant()->pkm_slug . '/' . ltrim($href, '/'));
                        }
                        $isActive = ($href !== '#' && $currentURL === rtrim($href, '/'));
                        ?>
                        <a class="<?= $isActive ? $activeClass : $inactiveClass ?> font-label-md text-label-md" href="<?= esc($href) ?>"><?= esc($m['title']) ?></a>
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
                            <a href="<?= esc($href) ?>" class="<?= $isActive ? $activeClass : $inactiveClass ?> flex items-center gap-1 font-label-md text-label-md py-2">
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
            <button class="text-on-surface-variant hover:text-primary transition-colors duration-200 hidden md:block">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">account_circle</span>
            </button>
        </div>
    </div>
</nav>
