<?php

require 'admin/config/database.php';

$e = fn($s) => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');

// Nama merek di DB huruf kapital semua; rapikan untuk kalimat
$brandName = function ($n) {
    $n = trim((string) $n);
    if (strlen($n) <= 3) {
        return strtoupper($n);
    }
    return preg_replace('/\bTv\b/', 'TV', ucwords(strtolower($n), " -"));
};

$productImg = fn($f) => !empty($f) ? 'admin/uploads/products/' . $f : 'assets/img/product-placeholder.webp';

$brands = $pdo->query("SELECT name, slug, logo FROM brands ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$partners = $pdo->query("
    SELECT name, logo
    FROM partners
    WHERE is_active = 1
    ORDER BY sort_order ASC, id DESC
")->fetchAll(PDO::FETCH_ASSOC);

$productSql = "
    SELECT
        p.id, p.name, p.slug, p.model,
        b.name AS brand,
        s.name AS sub_name, s.slug AS sub_slug,
        pi.image
    FROM products p
    LEFT JOIN brands b ON b.id = p.brand_id
    LEFT JOIN subcategories s ON s.id = p.subcategory_id
    LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
    WHERE p.is_active = 1
      AND p.deleted_at IS NULL
";

$allProducts = $pdo->query($productSql . " ORDER BY p.sort_order ASC, p.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Satu baris per produk (jaga-jaga bila ada >1 gambar utama)
$seen = [];
$allProducts = array_values(array_filter($allProducts, function ($p) use (&$seen) {
    if (isset($seen[$p['id']])) {
        return false;
    }
    return $seen[$p['id']] = true;
}));

$featured = $pdo->query($productSql . " AND p.is_featured = 1 ORDER BY p.sort_order ASC, p.created_at DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);
$featuredIds = [];
$featured = array_values(array_filter($featured, function ($p) use (&$featuredIds) {
    if (isset($featuredIds[$p['id']])) {
        return false;
    }
    return $featuredIds[$p['id']] = true;
}));
foreach ($allProducts as $p) {
    if (count($featured) >= 4) {
        break;
    }
    if (!isset($featuredIds[$p['id']])) {
        $featured[] = $p;
        $featuredIds[$p['id']] = true;
    }
}
$featured = array_slice($featured, 0, 4);

// Katalog per subkategori, yang terbanyak dulu
$catalog = [];
foreach ($allProducts as $p) {
    if (empty($p['sub_slug'])) {
        continue;
    }
    $catalog[$p['sub_slug']]['name'] = $p['sub_name'];
    $catalog[$p['sub_slug']]['items'][] = $p;
}
uasort($catalog, fn($a, $b) => count($b['items']) <=> count($a['items']));
$catalog = array_slice($catalog, 0, 8, true);

$brandCount = count($brands);
$productCount = count($allProducts);
$partnerNames = array_map(fn($p) => $brandName($p['name']), $partners);
$partnerList = count($partnerNames) > 1
    ? implode(', ', array_slice($partnerNames, 0, -1)) . ' dan ' . end($partnerNames)
    : implode('', $partnerNames);

$waNumber = '6287779928897';
$waHello = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode('Halo Kusuma Trisna Bali, saya ingin bertanya.');
$mapsUrl = 'https://share.google/LNnFVBGg7wU9klqp3';

$arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Distributor &amp; Service Elektronik Tabanan | Kusuma Trisna Bali</title>

    <meta name="description" content="Distributor dan service center elektronik resmi di Tabanan, Bali. Produk original dari brand ternama, teknisi profesional, dan garansi resmi.">

    <meta name="robots" content="index, follow">

    <link rel="canonical" href="https://www.kusumatrisnabali.com/">

    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Kusuma Trisna Bali | Distributor & Service Elektronik di Tabanan Bali">
    <meta property="og:description" content="Distributor dan pusat layanan perbaikan elektronik terpercaya di Tabanan, Bali. Menyediakan berbagai produk elektronik resmi dengan harga terbaik dan dukungan teknis profesional.">
    <meta property="og:url" content="https://www.kusumatrisnabali.com/">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:image" content="https://www.kusumatrisnabali.com/assets/og-image.jpg">
    <meta property="og:image:alt" content="Elektonik Kusuma Trisna Bali Tabanan">
    <meta property="og:image:width" content="1000">
    <meta property="og:image:height" content="563">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Kusuma Trisna Bali | Distributor & Service Elektronik">
    <meta name="twitter:description" content="Distributor dan pusat layanan perbaikan elektronik terpercaya di Tabanan, Bali.">
    <meta name="twitter:image" content="https://www.kusumatrisnabali.com/assets/og-image.jpg">

    <meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="theme-color" content="#c1121f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Kusuma Trisna Bali">

    <script>document.documentElement.classList.add('js');</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="assets/img/slider3.webp" fetchpriority="high">

    <?php include 'schema-store.php'; ?>
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <!-- Bar atas khusus HP/tablet -->
    <header class="lg:hidden sticky top-0 z-40 bg-[var(--ground)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <a href="/" class="flex items-center gap-3 min-w-0">
                <img src="assets/img/logo.webp" width="96" height="96" alt="" class="w-9 h-9 rounded-full shrink-0">
                <span class="text-lg font-bold tracking-tight truncate">Kusuma Trisna Bali</span>
            </a>
            <details class="mnav">
                <summary class="flex items-center gap-2 h-11 px-3 rounded-[var(--r)] bg-[var(--tile)] font-semibold cursor-pointer list-none" aria-label="Buka menu">Menu <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg></summary>
                <nav aria-label="Menu HP" class="absolute left-0 right-0 top-16 bg-[var(--ground)] px-4 sm:px-6 pb-6 pt-2 grid gap-[var(--gap)]">
                    <a href="products.php" class="tile flex items-center justify-between py-4 font-semibold">Produk <?= $arrow ?></a>
                    <a href="services.php" class="tile flex items-center justify-between py-4 font-semibold">Service &amp; lacak <?= $arrow ?></a>
                    <a href="about.php" class="tile flex items-center justify-between py-4 font-semibold">Tentang kami <?= $arrow ?></a>
                    <a href="contact.php" class="tile flex items-center justify-between py-4 font-semibold">Kontak <?= $arrow ?></a>
                </nav>
            </details>
        </div>
    </header>

    <main id="main-content">

        <!-- ============ PAPAN PEMBUKA ============ -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 pt-1 lg:pt-6 lg:h-[100svh] lg:min-h-[680px] lg:max-h-[1100px] lg:flex lg:flex-col" aria-label="Kusuma Trisna Bali">
            <div class="board lg:flex-1 lg:min-h-0 lg:grid-rows-[auto_auto_minmax(0,1fr)]" data-reveal>

                <!-- Nama -->
                <a href="/" class="tile hidden lg:flex lg:col-span-12 items-center gap-4 lg:gap-8 bg-[var(--ink)] text-white py-5 lg:py-7">
                    <img src="assets/img/logo.webp" width="96" height="96" alt="" class="w-11 h-11 sm:w-16 sm:h-16 lg:w-24 lg:h-24 shrink-0 rounded-full">
                    <p class="t-display text-[clamp(2rem,9vw,3.75rem)] lg:whitespace-nowrap lg:text-[length:var(--t-display)]">Kusuma Trisna Bali</p>
                </a>

                <!-- Menu -->
                <nav aria-label="Menu utama" class="hidden lg:grid lg:col-span-12 grid-cols-2 lg:grid-cols-4 gap-[var(--gap)]">
                    <a href="products.php" class="tile flex items-center justify-between py-4 font-semibold transition-colors hover:bg-[var(--tile-2)]">Produk <?= $arrow ?></a>
                    <a href="services.php" class="tile flex items-center justify-between py-4 font-semibold transition-colors hover:bg-[var(--tile-2)]">Service <?= $arrow ?></a>
                    <a href="about.php" class="tile flex items-center justify-between py-4 font-semibold transition-colors hover:bg-[var(--tile-2)]">Tentang kami <?= $arrow ?></a>
                    <a href="contact.php" class="tile flex items-center justify-between py-4 font-semibold transition-colors hover:bg-[var(--tile-2)]">Kontak <?= $arrow ?></a>
                </nav>

                <!-- Foto besar + pernyataan -->
                <div class="tile tile--photo col-span-2 lg:col-start-3 lg:col-span-8 lg:row-start-3 flex flex-col lg:block !bg-transparent lg:!bg-[var(--tile-2)] !overflow-visible lg:!overflow-hidden">
                    <div class="aspect-square sm:aspect-[4/3] rounded-[var(--r)] lg:rounded-none lg:aspect-auto lg:absolute lg:inset-0 overflow-hidden">
                        <img src="assets/img/slider3.webp" width="1920" height="1075" fetchpriority="high"
                            class="drift w-full h-full object-cover"
                            alt="Showroom elektronik Kusuma Trisna Bali dengan kulkas, AC, TV, dan audio">
                    </div>
                    <div class="relative lg:absolute lg:left-0 lg:bottom-0 lg:max-w-[64%] bg-[var(--ground)] lg:rounded-tr-[var(--r)] pt-6 pb-2 lg:p-7">
                        <h1 class="t-l">Distributor &amp; service elektronik di Tabanan</h1>
                        <p class="t-s mt-3">Produk resmi dari <?= $brandCount ?> merek, dan service yang bisa Anda pantau lewat kode tiket.</p>
                        <div class="lg:hidden grid grid-cols-2 gap-[var(--gap)] mt-6">
                            <a href="<?= $waHello ?>" target="_blank" rel="noopener" class="btn">Chat WhatsApp</a>
                            <a href="#lacak" class="btn !bg-[var(--ink)] hover:!bg-black">Lacak service</a>
                        </div>
                    </div>
                </div>

                <!-- Rel kiri: foto + fakta -->
                <div class="col-span-2 lg:col-start-1 lg:col-span-2 lg:row-start-3 grid grid-cols-2 lg:grid-cols-1 lg:grid-rows-[auto_minmax(0,1fr)] gap-[var(--gap)]">
                    <div class="tile tile--photo hidden lg:block lg:order-2 min-h-0">
                        <img src="assets/img/slider8.webp" width="1536" height="864" loading="lazy"
                            class="object-[30%_50%]" alt="Rak showroom berisi TV, kulkas, dan stok barang">
                    </div>
                    <ul class="tile col-span-2 lg:col-span-1 t-s font-medium grid grid-cols-2 gap-x-4 gap-y-1 lg:block lg:space-y-1 lg:order-1 lg:!p-4">
                        <li>Sejak 2019</li>
                        <li><?= $brandCount ?> merek resmi</li>
                        <li><?= $productCount ?> produk di katalog</li>
                        <li>Service resmi <?= count($partners) ?> merek</li>
                        <li>Tabanan, Bali</li>
                    </ul>
                </div>

                <!-- Rel kanan: warna terang ke gelap, terakhir aksi -->
                <div class="rail col-span-2 lg:col-start-11 lg:col-span-2 lg:row-start-3 grid grid-cols-2 lg:grid-cols-1 lg:grid-rows-5 gap-[var(--gap)] lg:min-h-0">
                    <div class="tile t-s">
                        <p class="font-semibold">Sen–Sab 08.00–17.00</p>
                        <p class="text-[var(--soft)]" data-open-status>WITA</p>
                    </div>
                    <a href="<?= $mapsUrl ?>" target="_blank" rel="noopener" class="tile t-s bg-[var(--tile-2)] transition-colors hover:bg-[#d1d5db]">
                        <span class="font-semibold block">Jl. By Pass Ir. Soekarno</span>
                        <span class="link-arrow">Lihat peta <?= $arrow ?></span>
                    </a>
                    <a href="tel:+6287779928897" class="tile col-span-2 lg:col-span-1 t-s bg-[var(--ink)] text-white transition-colors hover:bg-black">
                        <span class="block">Telepon</span>
                        <span class="font-semibold">0877-7992-8897</span>
                    </a>
                    <a href="#lacak" class="tile hidden lg:block t-s bg-[var(--deep)] text-white transition-colors hover:bg-[#5c0000]">
                        <span class="block font-semibold">Lacak service</span>
                        <span>Pakai kode service</span>
                    </a>
                    <a href="<?= $waHello ?>" target="_blank" rel="noopener" class="tile hidden lg:flex t-s bg-[var(--accent)] text-white flex-col justify-between gap-3 transition-colors hover:bg-[var(--deep)]">
                        <span class="font-semibold">Chat WhatsApp</span>
                        <span class="link-arrow">Tanya stok <?= $arrow ?></span>
                    </a>
                </div>

            </div>
        </section>

        <!-- ============ JUAL & SERVICE ============ -->
        <section id="layanan" class="max-w-7xl mx-auto px-4 sm:px-6 mt-[var(--gap)]">
            <div class="board lg:[grid-auto-rows:96px]" data-reveal>

                <div class="tile col-span-2 lg:col-start-1 lg:col-span-6 lg:row-start-1 lg:row-span-3">
                    <h2 class="t-h">Jual dan service, satu tempat</h2>
                    <p class="t-s mt-4 max-w-md">Kami menyalurkan produk elektronik resmi ke toko dan rumah tangga, lalu merawatnya lewat service center kami sendiri.</p>
                </div>

                <div class="tile tile--photo col-span-2 aspect-[4/3] lg:aspect-auto lg:col-start-7 lg:col-span-6 lg:row-start-1 lg:row-span-5">
                    <img src="assets/img/slider5.webp" width="1920" height="1075" loading="lazy" alt="Barang elektronik dimuat untuk dikirim ke toko">
                </div>

                <div class="tile bg-[var(--ink)] text-white flex flex-col justify-between lg:col-start-1 lg:col-span-3 lg:row-start-4 lg:row-span-2">
                    <p class="t-display"><?= $brandCount ?></p>
                    <p class="t-s">merek resmi yang kami salurkan</p>
                </div>

                <ul class="tile bg-[var(--tile-2)] t-s font-medium space-y-1 lg:col-start-7 lg:col-span-3 lg:row-start-9 lg:row-span-2">
                    <li>Televisi</li>
                    <li>AC dan air cooler</li>
                    <li>Kulkas, showcase, freezer</li>
                    <li>Mesin cuci, kipas angin</li>
                </ul>

                <div class="tile col-span-2 lg:col-span-3 bg-[var(--tile-2)] flex flex-col justify-between gap-4 lg:col-start-4 lg:row-start-4 lg:row-span-2">
                    <p class="t-m">Stok original untuk toko dan rumah.</p>
                    <a href="products.php" class="link-arrow hover:text-[var(--accent)]">Lihat produk <?= $arrow ?></a>
                </div>

                <div class="tile tile--photo col-span-2 aspect-[4/3] lg:aspect-auto lg:col-start-1 lg:col-span-6 lg:row-start-6 lg:row-span-5">
                    <img src="assets/img/promo1.webp" width="1384" height="1040" loading="lazy" alt="Teknisi memeriksa TV di service center">
                </div>

                <div class="tile col-span-2 flex flex-col justify-between gap-6 lg:col-start-7 lg:col-span-6 lg:row-start-6 lg:row-span-3">
                    <p class="t-l max-lg:!text-2xl max-w-xl">Service oleh teknisi berpengalaman, dengan prosedur yang jelas dan hasil yang dicek ulang.</p>
                    <a href="services.php" class="link-arrow hover:text-[var(--accent)]">Layanan service <?= $arrow ?></a>
                </div>

                <div class="tile col-span-2 lg:col-span-3 bg-[var(--deep)] text-white t-s lg:col-start-10 lg:row-start-9 lg:row-span-2">
                    <p class="font-semibold">Service center resmi</p>
                    <p><?= $e($partnerList) ?></p>
                </div>

            </div>
        </section>

        <!-- ============ KATALOG ============ -->
        <section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 mt-28 lg:mt-40">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-[var(--gap)]">

                <div class="lg:col-span-7 lg:pr-10" data-reveal>
                    <h2 class="t-display">Katalog</h2>
                    <p class="t-s mt-5 max-w-lg">Semua produk yang kami jual, menurut jenisnya. Buka satu jenis untuk melihat produk dan mereknya.</p>

                    <div class="mt-8 space-y-[var(--gap)]">
                        <?php $first = true;
                        foreach ($catalog as $slug => $group): ?>
                            <details class="bar" <?= $first ? 'open' : '' ?>>
                                <summary>
                                    <span><?= $e($group['name']) ?> <span class="text-[var(--soft)] font-normal">· <?= count($group['items']) ?> produk</span></span>
                                    <svg class="plus" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                                        <path d="M12 5v14M5 12h14" />
                                    </svg>
                                </summary>
                                <ul class="px-[18px] pb-5 pt-1 space-y-3.5">
                                    <?php foreach (array_slice($group['items'], 0, 6) as $item): ?>
                                        <li class="flex items-baseline justify-between gap-4">
                                            <a href="detail-product.php?slug=<?= $e($item['slug']) ?>" class="hover:text-[var(--accent)] underline-offset-4 hover:underline"><?= $e($item['name']) ?></a>
                                            <span class="text-[var(--soft)] text-right shrink-0"><?= $e($brandName($item['brand'] ?? '')) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                    <li>
                                        <a href="products.php?subcategory=<?= $e($slug) ?>" class="link-arrow text-[var(--accent)]">Semua <?= $e(strtolower($group['name'])) ?> <?= $arrow ?></a>
                                    </li>
                                </ul>
                            </details>
                        <?php $first = false;
                        endforeach; ?>
                    </div>
                </div>

                <div class="lg:col-span-5" data-reveal>
                    <h3 class="t-m"><?= $brandCount ?> merek resmi</h3>
                    <ul class="mt-5 grid grid-cols-3 sm:grid-cols-4 gap-[var(--gap)]">
                        <?php foreach ($brands as $brand): ?>
                            <li>
                                <a href="brand-product.php?brand=<?= $e($brand['slug']) ?>"
                                    class="tile !p-3 flex items-center justify-center aspect-[3/2] transition-colors hover:bg-[var(--tile-2)]"
                                    title="Produk <?= $e($brandName($brand['name'])) ?>">
                                    <img src="admin/uploads/brands/<?= $e($brand['logo']) ?>" alt="<?= $e($brandName($brand['name'])) ?>"
                                        loading="lazy" decoding="async" class="blend max-h-full max-w-full object-contain">
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </section>

        <!-- ============ MARQUEE ============ -->
        <div class="marquee mt-28 lg:mt-48 t-display text-[var(--ink)]" aria-hidden="true">
            <div class="marquee__track">
                <span>Distributor &amp; service elektronik resmi · Tabanan, Bali ·</span>
                <span>Distributor &amp; service elektronik resmi · Tabanan, Bali ·</span>
            </div>
        </div>

        <!-- ============ PRODUK UNGGULAN ============ -->
        <section id="produk" class="max-w-7xl mx-auto px-4 sm:px-6 mt-16 lg:mt-24">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <h2 class="t-h">Produk unggulan</h2>
                <a href="products.php" class="link-arrow hover:text-[var(--accent)]">Semua <?= $productCount ?> produk <?= $arrow ?></a>
            </div>

            <div class="board lg:[grid-auto-rows:120px]" data-reveal>
                <?php foreach ($featured as $i => $p):
                    $big = $i === 0;
                    $place = [
                        'lg:col-start-1 lg:col-span-6 lg:row-start-1 lg:row-span-4 col-span-2',
                        'lg:col-start-7 lg:col-span-3 lg:row-start-1 lg:row-span-2',
                        'lg:col-start-10 lg:col-span-3 lg:row-start-1 lg:row-span-2',
                        'lg:col-start-7 lg:col-span-3 lg:row-start-3 lg:row-span-2',
                    ][$i]; ?>
                    <a href="detail-product.php?slug=<?= $e($p['slug']) ?>"
                        class="tile group flex flex-col <?= $place ?> <?= $big ? 'aspect-square lg:aspect-auto' : 'aspect-[3/4] lg:aspect-auto' ?>">
                        <div class="flex-1 min-h-0 flex items-center justify-center <?= $big ? 'p-6 lg:p-10' : 'p-2' ?>">
                            <img src="<?= $e($productImg($p['image'])) ?>" alt="<?= $e($p['name']) ?>"
                                loading="lazy" decoding="async"
                                class="blend max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="pt-3">
                            <p class="<?= $big ? 't-l' : 't-m' ?> group-hover:text-[var(--accent)] transition-colors"><?= $e($p['name']) ?></p>
                            <p class="t-s text-[var(--soft)]"><?= $e(trim($brandName($p['brand'] ?? '') . ' · ' . ($p['sub_name'] ?? ''), ' ·')) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>

                <a href="products.php" class="tile bg-[var(--accent)] text-white flex flex-col justify-between gap-4 aspect-[3/4] lg:aspect-auto lg:col-start-10 lg:col-span-3 lg:row-start-3 lg:row-span-2 transition-colors hover:bg-[var(--deep)]">
                    <span class="t-m">Lihat semua <?= $productCount ?> produk di katalog</span>
                    <span class="link-arrow">Buka katalog <?= $arrow ?></span>
                </a>
            </div>
        </section>

        <!-- ============ SERVICE & LACAK ============ -->
        <section id="lacak" class="max-w-7xl mx-auto px-4 sm:px-6 mt-28 lg:mt-40 scroll-mt-6">
            <div class="grid lg:grid-cols-12 gap-[var(--gap)] gap-y-10 lg:gap-y-[var(--gap)]" data-reveal>

                <div class="lg:col-start-1 lg:col-span-7 lg:row-start-1 lg:self-start lg:pr-8">
                    <h2 class="t-h">Service yang bisa Anda pantau</h2>
                    <p class="t-s mt-4 max-w-lg">Setiap barang yang masuk mendapat kode service. Masukkan kodenya untuk melihat progres terbaru.</p>

                    <form action="services.php#track-service" method="post" class="mt-6 flex flex-col sm:flex-row gap-[var(--gap)] max-w-xl">
                        <label for="kode-service" class="sr-only">Kode service</label>
                        <input id="kode-service" type="text" name="service_code" required autocomplete="off"
                            placeholder="Kode service, mis. SRV-20260216-001"
                            class="flex-1 min-w-0 rounded-[var(--r)] bg-[var(--tile)] px-5 py-4 text-[var(--ink)] placeholder:text-[var(--soft)] focus:bg-[var(--tile-2)] focus:outline-none">
                        <button type="submit" class="btn">Cek status <?= $arrow ?></button>
                    </form>
                </div>

                <figure class="lg:col-start-1 lg:col-span-3 lg:row-start-2 lg:self-end">
                    <div class="tile tile--photo h-[46vw] lg:h-[260px]">
                        <img src="assets/img/h4.webp" width="1600" height="896" loading="lazy" alt="Barang service diterima dan dicatat">
                    </div>
                    <figcaption class="mt-4">
                        <p class="t-m">Diterima dan dicek</p>
                        <p class="t-s text-[var(--soft)] mt-1">Barang dicatat, Anda menerima kode service, lalu teknisi memeriksa kerusakannya.</p>
                    </figcaption>
                </figure>

                <figure class="lg:col-start-4 lg:col-span-4 lg:row-start-2 lg:self-end">
                    <div class="tile tile--photo h-[58vw] lg:h-[400px]">
                        <img src="assets/img/slider1.webp" width="1600" height="896" loading="lazy" class="object-[40%_50%]" alt="Dua teknisi menangani perbaikan TV">
                    </div>
                    <figcaption class="mt-4">
                        <p class="t-m">Dikerjakan</p>
                        <p class="t-s text-[var(--soft)] mt-1">Bila menunggu suku cadang atau persetujuan Anda, statusnya tertulis di kode service.</p>
                    </figcaption>
                </figure>

                <figure class="lg:col-start-8 lg:col-span-5 lg:row-start-1 lg:row-span-2 lg:self-end">
                    <div class="tile tile--photo h-[72vw] lg:h-[600px]">
                        <img src="assets/img/slider7.webp" width="1536" height="864" loading="lazy" class="object-[88%_40%]" alt="Staf Kusuma Trisna Bali siap menyerahkan barang">
                    </div>
                    <figcaption class="mt-4">
                        <p class="t-m">Selesai</p>
                        <p class="t-s text-[var(--soft)] mt-1">Hasil dicek ulang sebelum barang diserahkan kembali kepada Anda.</p>
                    </figcaption>
                </figure>

            </div>

            <?php if ($partners): ?>
                <div class="mt-16 grid lg:grid-cols-12 gap-[var(--gap)] items-center" data-reveal>
                    <h3 class="t-m lg:col-span-3 mb-4 lg:mb-0">Service center resmi untuk</h3>
                    <ul class="lg:col-span-9 grid grid-cols-3 sm:grid-cols-6 gap-[var(--gap)]">
                        <?php foreach ($partners as $partner): ?>
                            <li class="tile !p-3 flex items-center justify-center aspect-[3/2]">
                                <img src="admin/uploads/partners/<?= $e($partner['logo']) ?>" alt="<?= $e($brandName($partner['name'])) ?>"
                                    loading="lazy" decoding="async" class="blend max-h-full max-w-full object-contain">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </section>

        <!-- ============ TENTANG ============ -->
        <section id="tentang" class="max-w-7xl mx-auto px-4 sm:px-6 mt-28 lg:mt-40">
            <div data-reveal>
                <h2 class="t-h">Di Tabanan sejak 2019</h2>
                <p class="t-m font-normal mt-6 max-w-2xl">Kusuma Trisna Bali menyalurkan produk elektronik resmi untuk toko dan rumah tangga di Bali, dan merawatnya di tempat yang sama.</p>
            </div>

            <div class="mt-12 lg:mt-16 grid lg:grid-cols-12 gap-[var(--gap)] lg:gap-4" data-reveal>
                <div class="lg:col-span-8">
                    <div class="tile tile--photo aspect-[4/3] lg:aspect-[16/10]">
                        <img src="assets/img/slider2.webp" width="1920" height="1075" loading="lazy" alt="Ruang pamer produk elektronik">
                        <div class="hidden lg:block absolute top-0 right-0 w-[320px] bg-[var(--ground)] p-5 rounded-bl-[var(--r)]">
                            <p class="t-s">Tim teknisi kami bekerja dengan prosedur yang jelas, sehingga setiap service rapi, bertanggung jawab, dan dapat diandalkan.</p>
                            <a href="about.php" class="link-arrow mt-3 hover:text-[var(--accent)]">Tentang kami <?= $arrow ?></a>
                        </div>
                    </div>
                    <div class="lg:hidden mt-4">
                        <p class="t-s">Tim teknisi kami bekerja dengan prosedur yang jelas, sehingga setiap service rapi, bertanggung jawab, dan dapat diandalkan.</p>
                        <a href="about.php" class="link-arrow mt-3">Tentang kami <?= $arrow ?></a>
                    </div>
                </div>

                <div class="lg:col-span-4 mt-6 lg:mt-0">
                    <div class="tile bg-[var(--ink)] text-white aspect-[3/2] lg:aspect-auto lg:h-[60%] flex items-center justify-center">
                        <svg viewBox="0 0 540 340" class="w-full max-h-full" role="img" aria-label="Peta Pulau Bali, titik merah menandai Tabanan">
                            <path fill="#374151" d="M10 40 L100 36 L248 44 L276 20 L372 36 L476 92 L504 116 L524 140 L516 160 L468 184 L444 192 L400 204 L368 228 L344 256 L332 272 L332 284 L336 300 L312 320 L276 312 L304 288 L304 268 L292 240 L276 228 L260 220 L232 192 L164 148 L88 140 L72 136 L40 92 Z" />
                            <circle cx="286" cy="200" r="11" fill="#c1121f" />
                            <text x="304" y="186" fill="#ffffff" font-size="22" font-weight="600" font-family="IBM Plex Sans, sans-serif">Tabanan</text>
                        </svg>
                    </div>
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-5 mt-6 t-s">
                        <div>
                            <dt class="text-[var(--soft)]">Alamat</dt>
                            <dd class="font-medium">Jl. By Pass Ir. Soekarno, Dauh Peken</dd>
                        </div>
                        <div>
                            <dt class="text-[var(--soft)]">Jam buka</dt>
                            <dd class="font-medium">Sen–Sab, 08.00–17.00</dd>
                        </div>
                        <div>
                            <dt class="text-[var(--soft)]">Berdiri</dt>
                            <dd class="font-medium">2019</dd>
                        </div>
                        <div>
                            <dt class="text-[var(--soft)]">Waktu setempat</dt>
                            <dd class="font-medium" data-clock>WITA (UTC+8)</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <!-- ============ KONTAK ============ -->
        <section id="kontak" class="mt-28 lg:mt-40 bg-[var(--deep)] text-white py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6" data-reveal>
                <h2 class="t-h">Tanya stok atau jadwal service</h2>
                <p class="t-s mt-4 max-w-lg">Tulis nama dan keperluan Anda. Pesannya terbuka di WhatsApp, siap dikirim ke kami.</p>

                <form action="https://wa.me/<?= $waNumber ?>" method="get" target="_blank" data-wa-form
                    class="mt-10 grid lg:grid-cols-3 gap-[var(--gap)]">
                    <label for="wa-nama" class="sr-only">Nama Anda</label>
                    <input id="wa-nama" name="nama" type="text" autocomplete="name" placeholder="Nama Anda"
                        class="h-[60px] lg:h-[96px] rounded-[var(--r)] bg-[#8f1414] px-5 text-lg text-white placeholder:text-white/80 lg:text-center focus:bg-white focus:text-[var(--ink)] focus:placeholder:text-[var(--soft)] focus:outline-none transition-colors">
                    <label for="wa-perlu" class="sr-only">Keperluan</label>
                    <input id="wa-perlu" name="text" type="text" placeholder="Keperluan, mis. service TV Hisense"
                        class="h-[60px] lg:h-[96px] rounded-[var(--r)] bg-[#8f1414] px-5 text-lg text-white placeholder:text-white/80 lg:text-center focus:bg-white focus:text-[var(--ink)] focus:placeholder:text-[var(--soft)] focus:outline-none transition-colors">
                    <button type="submit"
                        class="h-[60px] lg:h-[96px] rounded-[var(--r)] bg-white text-[var(--deep)] text-lg font-semibold inline-flex items-center justify-center gap-3 hover:bg-[var(--tile)] active:scale-[.98] transition">
                        Kirim lewat WhatsApp <?= $arrow ?>
                    </button>
                </form>
                <div class="grid lg:grid-cols-3 gap-[var(--gap)] mt-4 t-s text-white/90">
                    <p>Dibalas pada jam kerja, Senin–Sabtu 08.00–17.00.</p>
                    <p class="hidden lg:block"></p>
                    <p>Atau telepon <a href="tel:+6287779928897" class="underline underline-offset-4 hover:text-white">0877-7992-8897</a></p>
                </div>
            </div>
        </section>

    </main>

    <?php include 'footer-board.php'; ?>

    <script src="assets/main.js?v=<?= filemtime(__DIR__ . '/assets/main.js'); ?>"></script>
</body>

</html>
