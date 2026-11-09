<?php
require 'admin/config/database.php';

/*
|--------------------------------------------------------------------------
| FILTER INPUT
|--------------------------------------------------------------------------
*/
$brand_slug = $_GET['brand'] ?? '';

/*
|--------------------------------------------------------------------------
| GET ALL BRANDS
|--------------------------------------------------------------------------
*/
$brands = $pdo->query("SELECT id, slug, name, description, logo FROM brands ORDER BY name")
    ->fetchAll(PDO::FETCH_ASSOC);

$brand_id = 0;
$current_brand = null;

/*
|--------------------------------------------------------------------------
| GET SELECTED BRAND
|--------------------------------------------------------------------------
*/
if ($brand_slug !== '') {
    $stmt = $pdo->prepare("SELECT id, slug, name, description, logo FROM brands WHERE slug = ?");
    $stmt->execute([$brand_slug]);
    $current_brand = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($current_brand) {
        $brand_id = $current_brand['id'];
    } else {
        include __DIR__ . '/404.php';
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| DEFAULT TO FIRST BRAND
|--------------------------------------------------------------------------
*/
if (!$current_brand && !empty($brands)) {
    $current_brand = $brands[0];
    $brand_id = $current_brand['id'];
}

/*
|--------------------------------------------------------------------------
| GET PRODUCTS
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT
        p.id,
        p.name,
        p.slug,
        p.tagline,
        p.model,
        b.name AS brand_name,
        c.name AS category_name,
        s.name AS subcategory_name,
        (
            SELECT pi.image
            FROM product_images pi
            WHERE pi.product_id = p.id
            ORDER BY pi.is_main DESC, pi.sort_order ASC
            LIMIT 1
        ) AS image
    FROM products p
    JOIN brands b ON b.id = p.brand_id
    JOIN categories c ON c.id = p.category_id
    JOIN subcategories s ON s.id = p.subcategory_id
    WHERE p.is_active = 1
      AND p.brand_id = ?
    ORDER BY p.sort_order ASC, p.id DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$brand_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$site = 'https://www.kusumatrisnabali.com';
$brandName = $current_brand['name'] ?? '';
$page_title = $current_brand
    ? "Produk {$brandName} Resmi di Tabanan Bali | Kusuma Trisna Bali"
    : "Brand Produk | Kusuma Trisna Bali";
$canonical = $current_brand
    ? $site . '/brand-product.php?brand=' . rawurlencode($current_brand['slug'])
    : $site . '/brand-product.php';
$brandDesc = trim(preg_replace('/\s+/u', ' ', strip_tags((string) ($current_brand['description'] ?? ''))));
$metaDesc = mb_strimwidth(
    $current_brand
        ? "Daftar produk {$brandName} resmi di Kusuma Trisna Bali, distributor elektronik di Tabanan, Bali. " . $brandDesc
        : 'Brand elektronik resmi yang didistribusikan Kusuma Trisna Bali di Tabanan, Bali.',
    0, 160, '…', 'UTF-8'
);
$ogImage = !empty($current_brand['logo'])
    ? $site . '/admin/uploads/brands/' . rawurlencode($current_brand['logo'])
    : $site . '/assets/products-og.jpg';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDesc); ?>">
    <meta name="robots" content="<?= $products ? 'index, follow, max-image-preview:large' : 'noindex, follow' ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical); ?>">

    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">
    <meta name="theme-color" content="#c1121f">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="<?= htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDesc); ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical); ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDesc); ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage); ?>">

    <?php
    include 'schema-store.php';
    $itemList = [];
    foreach (array_values($products) as $n => $p) {
        $itemList[] = [
            '@type' => 'ListItem',
            'position' => $n + 1,
            'url' => $site . '/detail-product.php?slug=' . rawurlencode($p['slug']),
            'name' => $p['name'],
        ];
    }
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $page_title,
        'url' => $canonical,
        'description' => $metaDesc,
        'isPartOf' => ['@id' => $site . '/#website'],
        'about' => $current_brand ? ['@type' => 'Brand', 'name' => $brandName] : null,
        'provider' => ['@id' => $site . '/#store'],
        'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => count($itemList), 'itemListElement' => $itemList],
    ]);
    jsonld(breadcrumb_ld(array_filter([
        ['Beranda', $site . '/'],
        ['Produk', $site . '/products.php'],
        $current_brand ? [$brandName, $canonical] : null,
    ])));
    ?>

    <script>document.documentElement.classList.add('js');</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>
<?php
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$niceName = function ($n) {
    $n = trim((string) $n);
    return strlen($n) <= 3 ? strtoupper($n) : preg_replace('/\bTv\b/', 'TV', ucwords(strtolower($n), " -"));
};
$arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
$brandNice = $niceName($brandName);
$brandLogo = !empty($current_brand['logo']) ? 'admin/uploads/brands/' . $current_brand['logo'] : 'assets/img/logo.png';
// Apakah merek ini juga service center resmi?
$isPartner = false;
try {
    $ps = $pdo->prepare("SELECT COUNT(*) FROM partners WHERE is_active = 1 AND LOWER(name) = LOWER(?)");
    $ps->execute([$brandName]);
    $isPartner = (int) $ps->fetchColumn() > 0;
} catch (Throwable $t) {
    $isPartner = false;
}
$waUrl = 'https://wa.me/6287779928897?text=' . rawurlencode('Halo Kusuma Trisna Bali, saya ingin bertanya tentang produk ' . $brandNice . '.');
?>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <?php $hbCurrent = 'produk'; include 'header-board.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6">

        <nav aria-label="Breadcrumb" class="pt-6 lg:pt-10 t-s text-[var(--soft)]">
            <a href="/" class="hover:text-[var(--ink)]">Beranda</a> /
            <a href="products.php" class="hover:text-[var(--ink)]">Produk</a> /
            <span class="text-[var(--ink)]" aria-current="page"><?= $e($brandNice) ?></span>
        </nav>

        <!-- Merek -->
        <section class="mt-6 grid lg:grid-cols-12 gap-[var(--gap)]">
            <div class="tile lg:col-span-4 aspect-[3/2] lg:aspect-auto lg:min-h-[260px] flex items-center justify-center !p-8">
                <img src="<?= $e($brandLogo) ?>" alt="Logo <?= $e($brandNice) ?>" class="blend max-h-28 max-w-full object-contain">
            </div>
            <div class="tile lg:col-span-8 flex flex-col justify-between gap-6 lg:!p-10">
                <div>
                    <h1 class="t-h">Produk <?= $e($brandNice) ?> resmi</h1>
                    <div class="t-s mt-4 max-w-2xl">
                        <?php if (!empty($current_brand['description'])): ?>
                            <?= nl2br($current_brand['description']) ?>
                        <?php else: ?>
                            Produk <?= $e($brandNice) ?> original yang kami salurkan untuk toko dan rumah tangga di Tabanan dan sekitarnya.
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex flex-wrap gap-[var(--gap)] items-center">
                    <a href="<?= $e($waUrl) ?>" target="_blank" rel="noopener" class="btn">Tanya produk <?= $e($brandNice) ?></a>
                    <?php if ($isPartner): ?>
                        <a href="services.php" class="px-4 py-3 rounded-[var(--r)] bg-[var(--deep)] text-white font-semibold hover:bg-[#5c0000] transition-colors">Service center resmi <?= $e($brandNice) ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Produk merek -->
        <section class="mt-16 lg:mt-24">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <h2 class="t-h"><?= $products ? count($products) . ' produk ' : 'Produk ' ?><?= $e($brandNice) ?></h2>
                <a href="products.php?brand=<?= urlencode($current_brand['slug'] ?? '') ?>" class="link-arrow hover:text-[var(--accent)]">Cari &amp; filter <?= $arrow ?></a>
            </div>
            <?php if (empty($products)): ?>
                <div class="tile py-14 text-center">
                    <p class="t-m">Belum ada produk <?= $e($brandNice) ?> di katalog online</p>
                    <p class="t-s mt-2">Tanyakan langsung, kami bantu cek ketersediaannya.</p>
                    <a href="<?= $e($waUrl) ?>" target="_blank" rel="noopener" class="btn mt-6">Chat WhatsApp</a>
                </div>
            <?php else: ?>
                <ul class="board !grid-cols-2 lg:!grid-cols-3" data-reveal>
                    <?php foreach ($products as $p):
                        $imgPath = !empty($p['image']) ? 'admin/uploads/products/' . $p['image'] : 'assets/img/product-placeholder.webp'; ?>
                        <li>
                            <a href="detail-product.php?slug=<?= urlencode($p['slug']) ?>" class="tile group flex flex-col h-full !p-4 lg:!p-6">
                                <div class="aspect-square flex items-center justify-center p-1 lg:p-3">
                                    <img src="<?= $e($imgPath) ?>" alt="<?= $e($p['name'] . ' - ' . $brandNice) ?>" loading="lazy" decoding="async"
                                        class="blend max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <div class="mt-3 flex-1">
                                    <h3 class="t-m group-hover:text-[var(--accent)] transition-colors"><?= $e($p['name']) ?></h3>
                                    <p class="t-s text-[var(--soft)] mt-1"><?= $e($p['subcategory_name']) ?></p>
                                </div>
                                <span class="link-arrow mt-4 t-s">Lihat detail <?= $arrow ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <!-- Merek lain -->
        <section class="mt-24 lg:mt-32 mb-24 lg:mb-32">
            <h2 class="t-h"><?= count($brands) ?> merek resmi</h2>
            <ul class="mt-8 grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-7 gap-[var(--gap)]">
                <?php foreach ($brands as $b): $on = (int) $b['id'] === (int) $brand_id; ?>
                    <li>
                        <a href="brand-product.php?brand=<?= urlencode($b['slug']) ?>" <?= $on ? 'aria-current="page"' : '' ?>
                            class="tile !p-3 flex items-center justify-center aspect-[3/2] transition-colors <?= $on ? '!bg-[var(--tile-2)] outline outline-2 outline-[var(--ink)] -outline-offset-2' : 'hover:bg-[var(--tile-2)]' ?>"
                            title="Produk <?= $e($niceName($b['name'])) ?>">
                            <img src="admin/uploads/brands/<?= $e($b['logo']) ?>" alt="<?= $e($niceName($b['name'])) ?>" loading="lazy" decoding="async" class="blend max-h-full max-w-full object-contain">
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <?php include 'footer-board.php'; ?>

    <script src="assets/main.js?v=<?= filemtime(__DIR__ . '/assets/main.js'); ?>"></script>
</body>

</html>
