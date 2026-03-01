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
    header('Location: products.php');
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

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> | Kusuma Trisna Bali</title>
    <link rel="icon" href="admin/favicon.ico">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Icons & Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <!-- Swiper -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css" />

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#c1121f',
                        darkred: '#780000'
                    }
                }
            }
        }
    </script>

    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/style.css">
</head>

<body class="font-['IBM_Plex_Sans'] text-gray-800 tracking-tight leading-relaxed">
    <?php include 'header.php'; ?>

    <!-- HERO -->
    <section class="relative pt-40 pb-32">
        <!-- Background -->
        <div class="absolute inset-0">
            <img src="assets/img/slider8.jpg"
                class="w-full h-full object-cover"
                alt="Produk Kusuma Trisna Bali">
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/20"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-6xl mx-auto px-6 text-center">

            <!-- Breadcrumb -->
            <div class="inline-flex items-center gap-2 px-4 py-2 text-white mb-6"
                data-aos="fade-up">

                <a href="index.php"
                    class="hover:text-primary transition">
                    Home
                </a>

                <span class="opacity-70">/</span>

                <a href="produk.php"
                    class="hover:text-primary transition">
                    Produk
                </a>

                <span class="opacity-70">/</span>

                <span class="font-semibold text-primary">
                    Detail Produk
                </span>

            </div>

        </div>

    </section>
    <!-- PRODUCT DETAIL -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-start">

            <!-- PRODUCT IMAGE -->
            <div data-aos="fade-right">

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">

                    <!-- MAIN SLIDER -->
                    <div class="swiper productMain mb-4">
                        <div class="swiper-wrapper">


                            <?php foreach ($images as $img): ?>
                                <div class="swiper-slide">
                                    <div class="swiper-zoom-container flex items-center justify-center">
                                        <img
                                            src="admin/uploads/products/<?= htmlspecialchars($img['image']); ?>"
                                            alt="<?= htmlspecialchars($product['name']); ?>"
                                            class="w-full h-[300px] md:h-[420px] object-contain">
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>

                        <!-- Navigation -->
                        <div class="swiper-button-next text-primary"></div>
                        <div class="swiper-button-prev text-primary"></div>
                    </div>

                    <!-- THUMBNAIL -->
                    <div class="swiper productThumbs">
                        <div class="swiper-wrapper">


                            <?php foreach ($images as $img): ?>
                                <div class="swiper-slide cursor-pointer">
                                    <img src="admin/uploads/products/<?= htmlspecialchars($img['image']); ?>"
                                        class="h-16 md:h-20 object-contain mx-auto">
                                </div>
                            <?php endforeach; ?>

                        </div>
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
                    <a href="mailto:info@kusumatrismabali.com"
                        class="inline-flex items-center px-6 py-3 bg-primary text-white
                          rounded-lg font-medium hover:bg-darkred transition">
                        <i class="fa-solid fa-envelope mr-2"></i>
                        Email Kami
                    </a>

                    <!-- WHATSAPP -->
                    <a href="https://wa.me/6287779928897?text=Halo%20Kusuma%20Trisna%20Bali%2C%20saya%20tertarik%20dengan%20produk%20<?= urlencode($product['name']); ?>.%20Bisakah%20saya%20mendapatkan%20informasi%20lebih%20lanjut%3F"
                        target="_blank"
                        class="inline-flex items-center px-6 py-3 bg-green-600 text-white
                          rounded-lg font-medium hover:bg-green-700 transition">
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
                            <?= $product['description']; ?>
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
                                    src="admin/uploads/products/<?= htmlspecialchars($r['image'] ?? 'default.png'); ?>"
                                    alt="<?= htmlspecialchars($r['name']); ?>"
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

    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const thumbsSwiper = new Swiper('.productThumbs', {
            spaceBetween: 12,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                640: {
                    slidesPerView: 4
                },
                1024: {
                    slidesPerView: 5
                }
            }
        });

        const mainSwiper = new Swiper('.productMain', {
            loop: true,
            spaceBetween: 20,
            zoom: {
                maxRatio: 2.5
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
        });
    </script>

    <script src="assets/main.js"></script>
</body>

</html>