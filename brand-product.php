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
    <meta name="robots" content="index, follow, max-image-preview:large">
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

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#c1121f'
                    }
                }
            }
        }
    </script>
</head>

<body class="text-gray-800 bg-gray-50">

    <?php include 'header.php'; ?>
    <main>

        <!-- HERO -->
        <section class="relative py-28">
            <div class="absolute inset-0">
                <img src="assets/img/slider5.webp" width="1920" height="1080" fetchpriority="high" class="w-full h-full object-cover" alt="Brand produk elektronik resmi Kusuma Trisna Bali">
                <div class="absolute inset-0 bg-black/50"></div>
            </div>

            <div class="relative max-w-6xl mx-auto px-6 text-center text-white">
                <h1 class="text-4xl font-semibold mb-4">
                    <?= $current_brand ? 'Produk ' . htmlspecialchars($brandName) . ' Resmi' : 'Brand & Produk Resmi'; ?>
                </h1>
                <p class="max-w-xl mx-auto text-white/90">
                    Pilih brand yang Anda butuhkan dan temukan berbagai produk original
                    dengan dukungan distribusi resmi dan terpercaya.
                </p>
            </div>
        </section>

        <!-- CONTENT -->
        <section class="py-16">
            <div class="max-w-6xl mx-auto px-6">

                <!-- BRAND TAB -->
                <div class="flex flex-wrap justify-center gap-3 mb-12">
                    <?php foreach ($brands as $b): ?>
                        <?php $active = ($b['id'] == $brand_id); ?>
                        <a href="brand-product.php?brand=<?= urlencode($b['slug']); ?>"
                            class="px-5 py-2 rounded-full text-sm font-medium transition
                   <?= $active
                            ? 'bg-primary text-white shadow-md'
                            : 'bg-white border text-gray-600 hover:bg-primary hover:text-white'; ?>">
                            <?= htmlspecialchars($b['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- BRAND DETAIL -->
                <?php if ($current_brand): ?>

                    <?php
                    $brandLogo = !empty($current_brand['logo'])
                        ? "admin/uploads/brands/" . $current_brand['logo']
                        : "assets/img/logo.png";
                    ?>

                    <div class="mb-14">

                        <div class="bg-white border rounded-2xl p-8 shadow-sm">

                            <div class="flex flex-col md:flex-row items-start gap-8">

                                <!-- LOGO -->
                                <div class="flex-shrink-0">
                                    <div class="w-40 h-28 flex items-center justify-center bg-gray-50 rounded-xl border">
                                        <img src="<?= htmlspecialchars($brandLogo); ?>"
                                            alt="Logo <?= htmlspecialchars($current_brand['name']); ?>"
                                            loading="lazy"
                                            class="max-h-20 object-contain">
                                    </div>
                                </div>

                                <!-- TEXT CONTENT -->
                                <div class="flex-1">

                                    <h2 class="text-3xl font-bold text-gray-800 mb-4">
                                        <?= htmlspecialchars($current_brand['name']); ?>
                                    </h2>

                                    <?php if (!empty($current_brand['description'])): ?>
                                        <p class="text-gray-600 leading-relaxed">
                                            <?= nl2br($current_brand['description']); ?>
                                        </p>
                                    <?php else: ?>
                                        <p class="text-gray-500 italic">
                                            Informasi brand sedang diperbarui.
                                        </p>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

                <!-- PRODUCT GRID -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    <?php if (empty($products)): ?>
                        <div class="col-span-full text-center text-gray-500">
                            Tidak ada produk untuk brand ini.
                        </div>
                    <?php endif; ?>

                    <?php foreach ($products as $p): ?>
                        <?php
                        $img = $p['image'] ?? '';
                        $imgPath = $img
                            ? "admin/uploads/products/" . $img
                            : "assets/img/product-placeholder.webp";
                        ?>

                        <div class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition">

                            <div class="relative h-56 flex items-center justify-center bg-gray-50">

                                <?php if (!empty($p['model'])): ?>
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-white/90 backdrop-blur-sm text-primary text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                            <?= htmlspecialchars($p['model']); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <img src="<?= htmlspecialchars($imgPath); ?>"
                                    alt="<?= htmlspecialchars($p['name']); ?>"
                                    loading="lazy" decoding="async"
                                    class="max-h-44 object-contain">
                            </div>

                            <div class="p-6">

                                <div class="text-sm text-primary font-medium mb-1">
                                    <?= htmlspecialchars($p['brand_name']); ?> • <?= htmlspecialchars($p['subcategory_name']); ?>
                                </div>

                                <h3 class="text-lg font-semibold mb-1">
                                    <?= htmlspecialchars($p['name']); ?>
                                </h3>

                                <?php if (!empty($p['tagline'])): ?>
                                    <p class="text-sm text-gray-600 italic line-clamp-2 mb-2">
                                        <?= htmlspecialchars($p['tagline']); ?>
                                    </p>
                                <?php endif; ?>

                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs text-gray-500 uppercase tracking-wide">
                                        <?= htmlspecialchars($p['category_name']); ?>
                                    </span>

                                    <a href="detail-product.php?slug=<?= urlencode($p['slug']); ?>"
                                        class="text-primary text-sm font-medium hover:underline">
                                        Detail <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

            </div>
        </section>

    </main>
    <?php include 'footer.php'; ?>

    <script src="assets/main.js"></script>
</body>

</html>