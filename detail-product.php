<?php
require 'admin/config/database.php';

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

// Judul SEO: "<Nama> <Model> - <Brand> | Kusuma Trisna Bali" (maks ~65 karakter)
$titleCore = $clean($product['name']);
if (!empty($product['model']) && mb_stripos($titleCore, $clean($product['model'])) === false) {
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
if (!empty($product['model'])) {
    $productLd['model'] = $clean($product['model']);
    $productLd['mpn'] = $clean($product['model']);
}

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

    <!-- Icons & Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.css" />

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .swiper {
            width: 100% !important;
            max-width: 100%;
        }

        .swiper-slide {
            width: 100% !important;
        }

        .swiper-wrapper {
            max-width: 100%;
        }
    </style>
    <?php
    include 'schema-store.php';
    jsonld($productLd);
    jsonld(breadcrumb_ld($breadcrumbItems));
    ?>
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>

<body class="font-['IBM_Plex_Sans'] text-gray-800 tracking-tight leading-relaxed">
    <?php include 'header.php'; ?>
    <main>
        <!-- HERO -->
        <section class="relative pt-40 pb-32">
            <!-- Background -->
            <div class="absolute inset-0">
                <img src="assets/img/slider8.webp" width="1920" height="1080" fetchpriority="high"
                    class="w-full h-full object-cover"
                    alt="Produk Kusuma Trisna Bali">
                <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/20"></div>
            </div>

            <!-- Content -->
            <div class="relative max-w-6xl mx-auto px-6 text-center">

                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb" class="inline-flex items-center gap-2 px-4 py-2 text-white mb-6"
                    data-aos="fade-up">

                    <a href="/"
                        class="hover:text-primary transition">
                        Home
                    </a>

                    <span class="opacity-70">/</span>

                    <a href="products.php"
                        class="hover:text-primary transition">
                        Produk
                    </a>

                    <span class="opacity-70">/</span>

                    <?php if (!empty($product['brand_slug'])): ?>
                    <a href="brand-product.php?brand=<?= urlencode($product['brand_slug']); ?>" class="hover:text-primary transition"><?= htmlspecialchars($product['brand_name']); ?></a>
                    <span class="opacity-70">/</span>
                    <?php endif; ?>
                    <span class="font-semibold text-primary" aria-current="page"><?= htmlspecialchars($product['name']); ?></span>

                </nav>

            </div>

        </section>

        <!-- PRODUCT DETAIL -->
        <section class="py-20">
            <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-start">

                <!-- PRODUCT IMAGE -->
                <div data-aos="fade-right">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 overflow-hidden w-full max-w-full">

                        <!-- MAIN SLIDER -->
                        <div class="swiper productMain mb-4 w-full max-w-full">
                            <div class="swiper-wrapper">


                                <?php foreach ($images as $i => $img): ?>
                                    <div class="swiper-slide">
                                        <div class="flex items-center justify-center">
                                            <img
                                                src="<?= htmlspecialchars($imgSrc($img['image'])); ?>"
                                                alt="<?= htmlspecialchars($seoImageAlt . ($i ? ' - foto ' . ($i + 1) : '')); ?>"
                                                width="600" height="420" <?= $i ? 'loading="lazy"' : '' ?>
                                                class="w-full h-[300px] md:h-[420px] object-contain">
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <!-- Navigation -->
                            <div class="swiper-button-next text-primary"></div>
                            <div class="swiper-button-prev text-primary"></div>
                        </div>
                    </div>
                </div>

                <!-- PRODUCT INFO -->
                <div data-aos=" fade-left">
                    <span class="text-sm text-primary font-medium">
                        <?= htmlspecialchars($product['brand_name']); ?> • <?= htmlspecialchars($product['subcategory_name']); ?>
                    </span>

                    <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 mt-3 mb-5">
                        <?= htmlspecialchars($product['name']); ?>
                    </h1>

                    <!-- Tagline -->
                    <?php if (!empty($product['tagline'])): ?>
                        <p class="text-sm text-gray-600 italic line-clamp-2 mb-2">
                            <?= htmlspecialchars($product['tagline']); ?>
                        </p>
                    <?php endif; ?>

                    <p class="text-gray-600 mb-6 leading-relaxed">
                        <?= nl2br($product['short_description']); ?>
                    </p>

                    <!-- PRODUCT META -->
                    <div class="grid grid-cols-2 gap-6 text-sm text-gray-700 mb-8">
                        <div><span class="font-medium">Brand:</span> <?= htmlspecialchars($product['brand_name']); ?></div>
                        <div><span class="font-medium">Kategori:</span> <?= htmlspecialchars($product['category_name']); ?></div>
                        <div><span class="font-medium">Subkategori:</span> <?= htmlspecialchars($product['subcategory_name']); ?></div>
                    </div>
                    <!-- Floating Model Badge -->
                    <?php if (!empty($product['model'])): ?>
                        <p class="text-primary mb-8"><?= htmlspecialchars($product['model']); ?></p>
                    <?php endif; ?>
                    <!-- CTA -->
                    <div class="flex flex-wrap gap-4">

                        <!-- EMAIL -->
                        <a href="mailto:info@kusumatrisnabali.com"
                            class="inline-flex items-center px-6 py-3 bg-primary text-white
                          rounded-lg font-medium hover:bg-darkred transition">
                            <i class="fa-solid fa-envelope mr-2"></i>
                            Email Kami
                        </a>

                        <!-- WHATSAPP -->
                        <a href="https://wa.me/6287779928897?text=Halo%20Kusuma%20Trisna%20Bali%2C%20saya%20tertarik%20dengan%20produk%20<?= urlencode($product['name']); ?>.%20Bisakah%20saya%20mendapatkan%20informasi%20lebih%20lanjut%3F"
                            target="_blank"
                            class="inline-flex items-center px-6 py-3 bg-green-700 text-white
                                                    rounded-lg font-medium hover:bg-green-800 transition">
                            <i class="fa-brands fa-whatsapp mr-2 text-lg"></i>
                            WhatsApp
                        </a>

                    </div>
                </div>

            </div>
        </section>
        <!-- PRODUCT DESCRIPTION -->
        <?php if (!empty($product['description']) || !empty($product['specifications'])): ?>
            <section class="bg-gray-50 py-20">
                <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16">

                    <?php if (!empty($product['description'])): ?>
                        <div data-aos="fade-up">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                                Deskripsi Produk
                            </h2>
                            <p class="text-gray-600 leading-relaxed">
                                <?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($product['specifications'])): ?>
                        <div data-aos="fade-up" data-aos-delay="100">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                                Spesifikasi
                            </h2>
                            <p class="text-gray-600">
                                <?= $product['specifications']; ?>
                            </p>
                        </div>
                    <?php endif; ?>

                </div>
            </section>
        <?php endif; ?>
        <!-- RELATED PRODUCTS -->
        <?php if ($related): ?>
            <section class="py-20">
                <div class="max-w-6xl mx-auto px-6">

                    <div class="mb-12">
                        <h2 class="text-2xl font-semibold text-gray-900"
                            data-aos="fade-up">
                            Produk Terkait
                        </h2>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php foreach ($related as $r): ?>
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition"
                                data-aos="fade-up">
                                <div class="h-48 flex items-center justify-center bg-gray-50">
                                    <img
                                        src="<?= htmlspecialchars($imgSrc($r['image'] ?: 'product-placeholder.png')); ?>"
                                        alt="<?= htmlspecialchars($r['name']); ?>"
                                        loading="lazy" decoding="async"
                                        class="object-contain">

                                </div>

                                <div class="p-5 mt-2">
                                    <h3 class="font-medium text-gray-900 mb-2">
                                        <?= htmlspecialchars($r['name']); ?>
                                    </h3>
                                    <a href="detail-product.php?slug=<?= urlencode($r['slug']); ?>"
                                        class="text-primary text-sm font-medium hover:underline">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

        <?php endif; ?>
    </main>
    <?php include 'footer.php'; ?>

    <!-- Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 900,
            once: true,
            easing: 'ease-out-cubic'
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js"></script>
    <script>
        const mainSwiper = new Swiper('.productMain', {
            loop: true,
            spaceBetween: 20,

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    </script>

    <script src="assets/main.js"></script>
</body>

</html>