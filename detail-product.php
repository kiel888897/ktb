<?php
require 'admin/config/database.php';
require_once __DIR__ . '/image-helper.php';

/*
|--------------------------------------------------------------------------
| VALIDASI SLUG
|--------------------------------------------------------------------------
*/
$slug = trim($_GET['slug'] ?? '');
if ($slug === '') {
    header('Location: products.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| AMBIL DATA PRODUK
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT
        p.*,
        b.name AS brand_name,
        b.slug AS brand_slug,
        c.name AS category_name,
        s.name AS subcategory_name
    FROM products p
    JOIN brands b ON b.id = p.brand_id
    JOIN categories c ON c.id = p.category_id
    JOIN subcategories s ON s.id = p.subcategory_id
    WHERE p.slug = ? AND p.is_active = 1
    LIMIT 1
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$slug]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    include __DIR__ . '/404.php';
    exit;
}
$product['brand_name'] = nice_brand($product['brand_name']);

/*
|--------------------------------------------------------------------------
| AMBIL GAMBAR PRODUK
|--------------------------------------------------------------------------
*/
$imgStmt = $pdo->prepare("
    SELECT image
    FROM product_images
    WHERE product_id = ?
    ORDER BY is_main DESC, sort_order ASC
");
$imgStmt->execute([$product['id']]);
$images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

if (!$images) {
    $images = [['image' => 'product-placeholder.png']];
}
/*
|--------------------------------------------------------------------------
| PRODUK TERKAIT (SUBKATEGORI SAMA + IMAGE)
|--------------------------------------------------------------------------
*/
$relStmt = $pdo->prepare("
    SELECT
        p.id,
        p.name,
        p.slug,
        (
            SELECT pi.image
            FROM product_images pi
            WHERE pi.product_id = p.id
            ORDER BY pi.is_main DESC, pi.sort_order ASC
            LIMIT 1
        ) AS image
    FROM products p
    WHERE p.subcategory_id = ?
      AND p.id != ?
      AND p.is_active = 1
    ORDER BY RAND()
    LIMIT 3
");
$relStmt->execute([
    $product['subcategory_id'],
    $product['id']
]);

$related = $relStmt->fetchAll(PDO::FETCH_ASSOC);

$site = 'https://www.kusumatrisnabali.com';
$clean = fn($s) => trim(preg_replace('/\s+/u', ' ', strip_tags((string) $s)));

// URL gambar (relatif untuk <img>, absolut untuk meta/schema)
$imgSrc = fn(string $file): string => $file === 'product-placeholder.png'
    ? 'assets/img/product-placeholder.webp'
    : 'admin/uploads/products/' . rawurlencode($file);

// Judul SEO: "<Nama> <Varian> - <Brand> | Kusuma Trisna Bali" (maks ~65 karakter)
// Kolom model berisi varian (ukuran/warna); pilihan ganda dengan "|" tidak masuk judul.
$titleCore = $clean($product['name']);
if (!empty($product['model']) && strpos($product['model'], '|') === false && mb_stripos($titleCore, $clean($product['model'])) === false) {
    $titleCore .= ' ' . $clean($product['model']);
}
if (mb_stripos($titleCore, $clean($product['brand_name'])) === false) {
    $titleCore .= ' - ' . $clean($product['brand_name']);
}
$seoTitle = $titleCore . ' | Kusuma Trisna Bali';
if (mb_strlen($seoTitle) > 65) {
    $seoTitle = $titleCore;
}

// Description
$seoDescription = $clean(
    (!empty($product['tagline']) ? $clean($product['tagline']) . '. ' : '')
        . $clean($product['short_description'])
        . ' Tersedia di Kusuma Trisna Bali, distributor '
        . mb_strtolower($product['subcategory_name'])
        . ' ' . $product['brand_name'] . ' di Tabanan, Bali.'
);
$seoDescription = mb_strimwidth($seoDescription, 0, 160, '…', 'UTF-8');

$seoImages = array_map(fn($i) => $site . '/' . $imgSrc($i['image']), $images);
$seoImage = $seoImages[0];

$seoUrl = $site . '/detail-product.php?slug=' . rawurlencode($product['slug']);
$seoImageAlt = $product['name'] . ' - ' . $product['brand_name'];

$productLd = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    '@id' => $seoUrl . '#product',
    'name' => $clean($product['name']),
    'url' => $seoUrl,
    'image' => $seoImages,
    'description' => $clean($product['short_description'] ?: $seoDescription),
    'brand' => ['@type' => 'Brand', 'name' => $clean($product['brand_name'])],
    'category' => $clean($product['category_name'] . ' > ' . $product['subcategory_name']),
];

$breadcrumbItems = [
    ['Beranda', $site . '/'],
    ['Produk', $site . '/products.php'],
];
if (!empty($product['brand_slug'] ?? '')) {
    $breadcrumbItems[] = [$product['brand_name'], $site . '/brand-product.php?brand=' . rawurlencode($product['brand_slug'])];
}
$breadcrumbItems[] = [$clean($product['name']), $seoUrl];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($seoTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seoDescription) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($seoUrl, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:type" content="product">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="<?= htmlspecialchars($seoImage, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image:alt" content="<?= htmlspecialchars($seoImageAlt, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($seoUrl, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">
    <meta name="theme-color" content="#c1121f">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <!-- twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($seoDescription) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($seoImage, ENT_QUOTES, 'UTF-8') ?>">

    <script>document.documentElement.classList.add('js');</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'"><noscript><link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>
    <?php
    include 'schema-store.php';
    jsonld($productLd);
    jsonld(breadcrumb_ld($breadcrumbItems));
    ?>
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>

<?php
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$niceName = function ($n) {
    $n = trim((string) $n);
    return strlen($n) <= 3 ? strtoupper($n) : preg_replace('/\bTv\b/', 'TV', ucwords(strtolower($n), " -"));
};
// Deskripsi dari admin bisa berupa HTML: izinkan tag teks saja, tanpa atribut. h1/h2 diturunkan agar struktur judul halaman tetap benar.
$richText = function ($html) {
    $html = trim((string) $html);
    $allowed = '<p><br><strong><b><em><i><u><ul><ol><li><h1><h2><h3><h4><table><thead><tbody><tr><th><td>';
    $html = preg_replace('#<(script|style)\b[^>]*>.*?</\1>#is', '', $html);
    $safe = strip_tags($html, $allowed);
    $safe = preg_replace('/<([a-z][a-z0-9]*)\b[^>]*?(\/?)>/i', '<$1$2>', $safe);
    $safe = preg_replace('#<(/?)h[12]>#i', '<$1h3>', $safe);
    return preg_match('#<(p|ul|ol|table|h3|h4)>#i', $safe) ? $safe : nl2br($safe);
};
$arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
$brandNice = $niceName($product['brand_name']);
$hasModel = trim((string) ($product['model'] ?? '')) !== '';
$waText = 'Halo Kusuma Trisna Bali, saya tertarik dengan produk ' . $clean($product['name'])
    . (!empty($product['model']) ? ' (' . $clean($product['model']) . ')' : '') . '. Apakah stoknya tersedia dan berapa harganya?';
$waUrl = 'https://wa.me/6287779928897?text=' . rawurlencode($waText);
?>
<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <?php $hbCurrent = 'produk'; include 'header-board.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6">

        <nav aria-label="Breadcrumb" class="pt-6 lg:pt-8 t-s text-[var(--soft)]">
            <a href="/" class="hover:text-[var(--ink)]">Beranda</a> /
            <a href="products.php" class="hover:text-[var(--ink)]">Produk</a> /
            <?php if (!empty($product['brand_slug'])): ?>
                <a href="brand-product.php?brand=<?= urlencode($product['brand_slug']) ?>" class="hover:text-[var(--ink)]"><?= $e($brandNice) ?></a> /
            <?php endif; ?>
            <span class="text-[var(--ink)]" aria-current="page"><?= $e($product['name']) ?></span>
        </nav>

        <!-- Produk -->
        <section class="mt-6 grid lg:grid-cols-12 gap-[var(--gap)] lg:gap-x-10 items-start">

            <!-- Foto -->
            <div class="lg:col-span-7 min-w-0">
                <div class="tile aspect-square sm:aspect-[4/3] flex items-center justify-center !p-6 lg:!p-12">
                    <img id="mainImg" src="<?= $e(thumb_src($imgSrc($images[0]['image']), 900)) ?>"
                        alt="<?= $e($seoImageAlt) ?>" width="600" height="600" fetchpriority="high"
                        class="blend max-h-full max-w-full object-contain">
                </div>
                <?php if (count($images) > 1): ?>
                    <ul class="mt-[var(--gap)] grid grid-cols-4 sm:grid-cols-6 gap-[var(--gap)]">
                        <?php foreach ($images as $i => $img): ?>
                            <li>
                                <button type="button" data-thumb="<?= $e(thumb_src($imgSrc($img['image']), 900)) ?>" aria-label="Lihat foto <?= $i + 1 ?>" <?= $i === 0 ? 'aria-current="true"' : '' ?>
                                    class="thumb tile w-full aspect-square !p-2 flex items-center justify-center transition-colors hover:bg-[var(--tile-2)]">
                                    <img src="<?= $e(thumb_src($imgSrc($img['image']), 240)) ?>" alt="" loading="lazy" class="blend max-h-full max-w-full object-contain">
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="lg:col-span-5 min-w-0 mt-6 lg:mt-0 lg:sticky lg:top-28">
                <p class="t-s text-[var(--soft)]">
                    <?php if (!empty($product['brand_slug'])): ?>
                        <a href="brand-product.php?brand=<?= urlencode($product['brand_slug']) ?>" class="hover:text-[var(--ink)]"><?= $e($brandNice) ?></a>
                    <?php else: ?><?= $e($brandNice) ?><?php endif; ?>
                    · <?= $e($product['subcategory_name']) ?>
                </p>
                <h1 class="t-l mt-2"><?= $e($product['name']) ?></h1>
                <?php if (!empty($product['tagline'])): ?>
                    <p class="t-m font-normal mt-3"><?= $e($product['tagline']) ?></p>
                <?php endif; ?>
                <?php if (!empty($product['short_description'])): ?>
                    <div class="t-s mt-4"><?= nl2br($product['short_description']) ?></div>
                <?php endif; ?>

                <dl class="mt-6 grid grid-cols-2 gap-[var(--gap)] t-s">
                    <div class="tile !p-4">
                        <dt class="text-[var(--soft)]">Merek</dt>
                        <dd class="font-semibold"><?= $e($brandNice) ?></dd>
                    </div>
                    <?php if ($hasModel): ?>
                        <div class="tile !p-4">
                            <dt class="text-[var(--soft)]">Varian</dt>
                            <dd class="font-semibold break-words"><?= $e($product['model']) ?></dd>
                        </div>
                    <?php endif; ?>
                    <div class="tile !p-4">
                        <dt class="text-[var(--soft)]">Kategori</dt>
                        <dd class="font-semibold"><?= $e($product['category_name']) ?></dd>
                    </div>
                    <div class="tile !p-4 <?= $hasModel ? '' : 'col-span-2' ?>">
                        <dt class="text-[var(--soft)]">Jenis</dt>
                        <dd class="font-semibold"><?= $e($product['subcategory_name']) ?></dd>
                    </div>
                </dl>

                <a href="<?= $e($waUrl) ?>" target="_blank" rel="noopener" class="btn w-full mt-6 !py-4">Tanya stok &amp; harga di WhatsApp <?= $arrow ?></a>
                <div class="mt-[var(--gap)] grid grid-cols-2 gap-[var(--gap)]">
                    <a href="tel:+6287779928897" class="tile !p-4 t-s font-semibold transition-colors hover:bg-[var(--tile-2)]">Telepon<span class="block font-normal">0877-7992-8897</span></a>
                    <a href="services.php" class="tile !p-4 t-s font-semibold transition-colors hover:bg-[var(--tile-2)]">Butuh service?<span class="block font-normal">Lacak atau ajukan</span></a>
                </div>
            </div>
        </section>

        <!-- Deskripsi & spesifikasi -->
        <?php if (!empty($product['description']) || !empty($product['specifications'])): ?>
            <section class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-10 lg:gap-[var(--gap)]" data-reveal>
                <?php if (!empty($product['description'])): ?>
                    <div class="<?= !empty($product['specifications']) ? 'lg:col-span-6 lg:pr-10' : 'lg:col-span-8' ?>">
                        <h2 class="t-h">Deskripsi</h2>
                        <div class="spec t-s mt-6"><?= $richText($product['description']) ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product['specifications'])): ?>
                    <div class="<?= !empty($product['description']) ? 'lg:col-span-6' : 'lg:col-span-8' ?>">
                        <h2 class="t-h">Spesifikasi</h2>
                        <div class="spec t-s mt-6"><?= $product['specifications'] ?></div>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <!-- Produk terkait -->
        <?php if ($related): ?>
            <section class="mt-24 lg:mt-32">
                <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                    <h2 class="t-h">Produk sejenis</h2>
                    <a href="products.php" class="link-arrow hover:text-[var(--accent)]">Semua produk <?= $arrow ?></a>
                </div>
                <ul class="board !grid-cols-2 lg:!grid-cols-3" data-reveal>
                    <?php foreach ($related as $r): ?>
                        <li>
                            <a href="detail-product.php?slug=<?= urlencode($r['slug']) ?>" class="tile group flex flex-col h-full !p-4 lg:!p-6">
                                <div class="aspect-square flex items-center justify-center p-2 lg:p-6">
                                    <img src="<?= $e(thumb_src($imgSrc($r['image'] ?: 'product-placeholder.png'), 480)) ?>" alt="<?= $e($r['name']) ?>"
                                        loading="lazy" decoding="async" class="blend max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <h3 class="t-m mt-3 group-hover:text-[var(--accent)] transition-colors"><?= $e($r['name']) ?></h3>
                                <span class="link-arrow mt-3 t-s">Lihat detail <?= $arrow ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <div class="h-24 lg:h-32"></div>
    </main>

    <?php include 'footer-board.php'; ?>

    <script src="assets/main.js?v=<?= filemtime(__DIR__ . '/assets/main.js'); ?>"></script>
</body>

</html>
