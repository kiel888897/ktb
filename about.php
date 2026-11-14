<?php

require 'admin/config/database.php';
require_once __DIR__ . '/image-helper.php';

$stmt = $pdo->prepare("
    SELECT name, logo, slug
    FROM partners
    WHERE is_active = 1
    ORDER BY sort_order ASC, id DESC
");
$stmt->execute();
$partners = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang Kusuma Trisna Bali | Distributor Elektronik Tabanan</title>

    <meta name="description" content="Profil Kusuma Trisna Bali: distributor dan pusat service elektronik di Tabanan, Bali sejak 2019, dengan produk resmi dan teknisi berpengalaman.">


    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <link rel="canonical" href="https://www.kusumatrisnabali.com/about.php">

    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">

    <meta name="theme-color" content="#c1121f">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="Tentang Kami | Kusuma Trisna Bali">
    <meta property="og:description" content="Kusuma Trisna Bali telah melayani pelanggan sejak tahun 2019 sebagai distributor dan pusat layanan perbaikan elektronik terpercaya di Tabanan, Bali.">
    <meta property="og:url" content="https://www.kusumatrisnabali.com/about.php">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:image" content="https://www.kusumatrisnabali.com/assets/about-og.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="674">
    <meta property="og:image:alt" content="Tentang Kusuma Trisna Bali">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Tentang Kami | Kusuma Trisna Bali">
    <meta name="twitter:description" content="Mengenal lebih dekat Kusuma Trisna Bali sebagai distributor dan pusat layanan elektronik terpercaya di Bali.">
    <meta name="twitter:image" content="https://www.kusumatrisnabali.com/assets/about-og.jpg">

    <?php
    include 'schema-store.php';
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => 'Tentang Kusuma Trisna Bali',
        'url' => SITE_URL . '/about.php',
        'description' => 'Profil Kusuma Trisna Bali, distributor dan pusat layanan perbaikan elektronik di Tabanan, Bali sejak tahun 2019.',
        'isPartOf' => ['@id' => SITE_URL . '/#website'],
        'mainEntity' => ['@id' => SITE_URL . '/#store'],
    ]);
    jsonld(breadcrumb_ld([['Beranda', SITE_URL . '/'], ['Tentang Kami', SITE_URL . '/about.php']]));
    ?>


    <!-- Icons & Library -->
    <script>document.documentElement.classList.add('js');</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'"><noscript><link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>
<?php
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$niceName = function ($n) {
    $n = trim((string) $n);
    return strlen($n) <= 3 ? strtoupper($n) : preg_replace('/\bTv\b/', 'TV', ucwords(strtolower($n), " -"));
};
$arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
?>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <?php $hbCurrent = 'tentang'; include 'header-board.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6">

        <section class="pt-4 lg:pt-6 board lg:[grid-auto-rows:minmax(110px,auto)]">
            <div class="tile col-span-2 lg:col-span-7 lg:row-span-3 flex flex-col justify-end lg:!p-10">
                <nav aria-label="Breadcrumb" class="t-s text-[var(--soft)] mb-4">
                    <a href="/" class="hover:text-[var(--ink)]">Beranda</a> / <span class="text-[var(--ink)]">Tentang kami</span>
                </nav>
                <h1 class="t-h">Distribusi dan service elektronik sejak 2019</h1>
                <p class="t-s mt-4 max-w-xl">Kusuma Trisna Bali bergerak di bidang distribusi dan layanan elektronik di Tabanan, dengan fokus pada pelayanan yang baik, dapat diandalkan, dan sesuai kebutuhan pelanggan.</p>
            </div>
            <div class="tile tile--photo col-span-2 lg:col-span-5 lg:row-span-3 aspect-[4/3] lg:aspect-auto">
                <img src="assets/img/slider4.webp" width="1920" height="1075" fetchpriority="high" alt="Gudang dan ruang pamer Kusuma Trisna Bali">
            </div>
            <div class="tile bg-[var(--ink)] text-white lg:col-span-3">
                <p class="t-display">2019</p>
                <p class="t-s mt-2">tahun berdiri</p>
            </div>
            <div class="tile bg-[var(--tile-2)] lg:col-span-3">
                <p class="t-display"><?= count($partners) ?></p>
                <p class="t-s mt-2">merek dengan service resmi</p>
            </div>
            <div class="tile col-span-2 lg:col-span-6 bg-[var(--deep)] text-white flex flex-col justify-between gap-6">
                <p class="t-l max-lg:!text-2xl">Distribusi dan perbaikan dengan proses kerja yang jelas dan rapi.</p>
                <a href="products.php" class="link-arrow">Lihat produk <?= $arrow ?></a>
            </div>
        </section>

        <!-- Nilai -->
        <section class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-[var(--gap)]" data-reveal>
            <h2 class="t-h lg:col-span-4 lg:pr-8 mb-6 lg:mb-0">Cara kami bekerja</h2>
            <div class="tile lg:col-span-4 lg:!p-8">
                <h3 class="t-m">Tertib dan jelas</h3>
                <p class="t-s mt-3">Setiap pekerjaan dilakukan dengan tertib, jelas, dan penuh tanggung jawab.</p>
            </div>
            <div class="tile lg:col-span-4 bg-[var(--tile-2)] lg:!p-8">
                <h3 class="t-m">Dapat diandalkan</h3>
                <p class="t-s mt-3">Menjaga kepercayaan pelanggan lewat hasil kerja yang konsisten dan bertanggung jawab.</p>
            </div>
            <div class="tile tile--photo lg:col-start-5 lg:col-span-5 aspect-[4/3] lg:aspect-auto lg:min-h-[280px]">
                <img src="assets/img/slider1.webp" width="1600" height="896" loading="lazy" alt="Tim teknisi Kusuma Trisna Bali">
            </div>
            <div class="tile lg:col-span-3 bg-[var(--ink)] text-white lg:!p-8">
                <h3 class="t-m">Terus berkembang</h3>
                <p class="t-s mt-3">Kami terus belajar dan menyesuaikan layanan dengan kebutuhan pelanggan.</p>
            </div>
        </section>

        <!-- Lokasi -->
        <section class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-[var(--gap)] lg:gap-4" data-reveal>
            <div class="lg:col-span-5">
                <h2 class="t-h">Di Tabanan, Bali</h2>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-5 mt-8 t-s">
                    <div class="col-span-2">
                        <dt class="text-[var(--soft)]">Alamat</dt>
                        <dd class="font-medium">Jl. By Pass Dr. Ir. Soekarno, Banjar Tegal Belodan, Dauh Peken, Tabanan, Bali 82113</dd>
                    </div>
                    <div>
                        <dt class="text-[var(--soft)]">Jam buka</dt>
                        <dd class="font-medium">Sen–Sab, 09.00–17.00</dd>
                    </div>
                    <div>
                        <dt class="text-[var(--soft)]">Waktu setempat</dt>
                        <dd class="font-medium" data-clock>WITA (UTC+8)</dd>
                    </div>
                </dl>
                <a href="contact.php" class="btn mt-8">Hubungi kami <?= $arrow ?></a>
            </div>
            <div class="lg:col-span-7 tile bg-[var(--ink)] aspect-[3/2] flex items-center justify-center mt-8 lg:mt-0">
                <svg viewBox="0 0 540 340" class="w-full max-h-full" role="img" aria-label="Peta Pulau Bali, titik merah menandai Tabanan">
                            <path fill="#374151" d="M10 40 L100 36 L248 44 L276 20 L372 36 L476 92 L504 116 L524 140 L516 160 L468 184 L444 192 L400 204 L368 228 L344 256 L332 272 L332 284 L336 300 L312 320 L276 312 L304 288 L304 268 L292 240 L276 228 L260 220 L232 192 L164 148 L88 140 L72 136 L40 92 Z" />
                            <circle cx="286" cy="200" r="11" fill="#c1121f" />
                            <text x="304" y="186" fill="#ffffff" font-size="22" font-weight="600" font-family="IBM Plex Sans, sans-serif">Tabanan</text>
                        </svg>
            </div>
        </section>

        <?php if ($partners): ?>
            <section class="mt-24 lg:mt-32 mb-24 lg:mb-32 grid lg:grid-cols-12 gap-[var(--gap)] items-center" data-reveal>
                <h2 class="t-m lg:col-span-3 mb-4 lg:mb-0">Service center resmi untuk</h2>
                <ul class="lg:col-span-9 grid grid-cols-3 sm:grid-cols-6 gap-[var(--gap)]">
                    <?php foreach ($partners as $partner): ?>
                        <li class="tile !p-3 flex items-center justify-center aspect-[3/2]">
                            <img src="<?= $e(thumb_src('admin/uploads/partners/' . $partner['logo'], 240)) ?>" alt="<?= $e($niceName($partner['name'])) ?>" loading="lazy" decoding="async" class="blend max-h-full max-w-full object-contain">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php else: ?>
            <div class="h-24 lg:h-32"></div>
        <?php endif; ?>
    </main>

    <?php include 'footer-board.php'; ?>

    <script src="assets/main.js?v=<?= filemtime(__DIR__ . '/assets/main.js'); ?>"></script>
</body>

</html>
