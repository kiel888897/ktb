<?php
// Header gaya "papan". Set $hbMobileOnly = true untuk beranda (desktop beranda punya papan menu sendiri).
// $hbCurrent: 'produk' | 'service' | 'tentang' | 'kontak'
$hbMobileOnly = $hbMobileOnly ?? false;
$hbCurrent = $hbCurrent ?? '';
$hbArrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
$hbLinks = [
    'produk' => ['products.php', 'Produk'],
    'service' => ['services.php', 'Service'],
    'tentang' => ['about.php', 'Tentang kami'],
    'kontak' => ['contact.php', 'Kontak'],
];
?>
<header class="<?= $hbMobileOnly ? 'lg:hidden ' : '' ?>sticky top-0 z-40 bg-[var(--ground)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 lg:h-20 flex items-center justify-between gap-3">
        <a href="/" class="flex items-center gap-3 min-w-0">
            <img src="assets/img/logo.webp" width="96" height="96" alt="" class="w-9 h-9 lg:w-11 lg:h-11 rounded-full shrink-0">
            <span class="text-lg lg:text-xl font-bold tracking-tight truncate">Kusuma Trisna Bali</span>
        </a>

        <?php if (!$hbMobileOnly): ?>
            <nav aria-label="Menu utama" class="hidden lg:flex items-center gap-[var(--gap)]">
                <?php foreach ($hbLinks as $key => [$href, $label]): ?>
                    <a href="<?= $href ?>" <?= $hbCurrent === $key ? 'aria-current="page"' : '' ?>
                        class="px-4 py-2.5 rounded-[var(--r)] font-semibold transition-colors <?= $hbCurrent === $key ? 'bg-[var(--ink)] text-white' : 'hover:bg-[var(--tile)]' ?>"><?= $label ?></a>
                <?php endforeach; ?>
                <a href="https://wa.me/6287779928897" target="_blank" rel="noopener" class="btn ml-2 !py-2.5">Chat WhatsApp</a>
            </nav>
        <?php endif; ?>

        <details class="mnav lg:hidden">
            <summary class="flex items-center gap-2 h-11 px-3 rounded-[var(--r)] bg-[var(--tile)] font-semibold cursor-pointer list-none" aria-label="Buka menu">Menu
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </summary>
            <nav aria-label="Menu HP" class="absolute left-0 right-0 top-16 bg-[var(--ground)] px-4 sm:px-6 pb-6 pt-2 grid gap-[var(--gap)]">
                <?php foreach ($hbLinks as $key => [$href, $label]): ?>
                    <a href="<?= $href ?>" <?= $hbCurrent === $key ? 'aria-current="page"' : '' ?>
                        class="tile flex items-center justify-between py-4 font-semibold <?= $hbCurrent === $key ? '!bg-[var(--ink)] text-white' : '' ?>"><?= $label ?> <?= $hbArrow ?></a>
                <?php endforeach; ?>
                <a href="https://wa.me/6287779928897" target="_blank" rel="noopener" class="btn">Chat WhatsApp</a>
            </nav>
        </details>
    </div>
</header>
