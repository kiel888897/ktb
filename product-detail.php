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
| PRODUK TERKAIT (KATEGORI SAMA)
|--------------------------------------------------------------------------
*/
$relStmt = $pdo->prepare("
    SELECT id, name, slug
    FROM products
    WHERE category_id = ?
      AND id != ?
      AND is_active = 1
    ORDER BY RAND()
    LIMIT 3
");
$relStmt->execute([$product['category_id'], $product['id']]);
$related = $relStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']); ?> | Kusuma Trisna Bali</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lib -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

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
</head>

<body class="text-gray-800 bg-gray-50">
    <?php include 'header.php'; ?>

    <!-- HERO -->
    <section class="relative pt-40 pb-28">
        <div class="absolute inset-0">
            <img src="assets/img/slider1.jpg" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-6 text-white">
            <div class="mb-4 text-sm">
                <a href="index.php" class="hover:text-primary">Home</a> /
                <a href="products.php" class="hover:text-primary">Produk</a> /
                <span class="text-primary font-semibold"><?= htmlspecialchars($product['name']); ?></span>
            </div>

            <h1 class="text-3xl md:text-4xl font-semibold">
                <?= htmlspecialchars($product['name']); ?>
            </h1>
        </div>
    </section>

    <!-- DETAIL -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16">

            <!-- IMAGE -->
            <div data-aos="fade-right">
                <div class="bg-white border rounded-xl p-6">

                    <div class="swiper productMain mb-4">
                        <div class="swiper-wrapper">
                            <?php foreach ($images as $img): ?>
                                <div class="swiper-slide">
                                    <div class="swiper-zoom-container">
                                        <img src="admin/uploads/products/<?= htmlspecialchars($img['image']); ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="swiper-button-next text-primary"></div>
                        <div class="swiper-button-prev text-primary"></div>
                    </div>

                    <div class="swiper productThumbs">
                        <div class="swiper-wrapper">
                            <?php foreach ($images as $img): ?>
                                <div class="swiper-slide cursor-pointer">
                                    <img src="admin/uploads/products/<?= htmlspecialchars($img['image']); ?>"
                                        class="h-20 object-contain mx-auto">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>

            <!-- INFO -->
            <div data-aos="fade-left">
                <span class="text-sm text-primary font-medium">
                    <?= htmlspecialchars($product['brand_name']); ?> • <?= htmlspecialchars($product['subcategory_name']); ?>
                </span>

                <h2 class="text-3xl font-semibold mt-3 mb-5">
                    <?= htmlspecialchars($product['name']); ?>
                </h2>

                <p class="text-gray-600">
                    <?= nl2br($product['description']); ?>
                </p>

                <div class="grid grid-cols-2 gap-4 text-sm mt-4 mb-8">
                    <div><b>Brand:</b> <?= htmlspecialchars($product['brand_name']); ?></div>
                    <div><b>Kategori:</b> <?= htmlspecialchars($product['category_name']); ?></div>
                    <div><b>Subkategori:</b> <?= htmlspecialchars($product['subcategory_name']); ?></div>
                </div>

                <div class="flex gap-4">
                    <a href="mailto:info@kusumatrismabali.com"
                        class="px-6 py-3 bg-primary text-white rounded-lg">
                        <i class="fa-solid fa-envelope mr-2"></i>Email
                    </a>
                    <a href="https://wa.me/6281234567890"
                        target="_blank"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg">
                        <i class="fa-brands fa-whatsapp mr-2"></i>WhatsApp
                    </a>
                </div>
            </div>

        </div>
    </section>
    <!-- PRODUCT DESCRIPTION -->
    <section class="bg-gray-50 py-20">
        <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16">

            <div data-aos="fade-up">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                    Deskripsi Produk
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    <?= ($product['description']); ?>
                </p>
            </div>

            <div data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                    Spesifikasi
                </h2>

                <ul class="space-y-3 text-gray-600">
                    <li>• Ukuran Layar: 55 Inch</li>
                    <li>• Resolusi: 4K Ultra HD</li>
                    <li>• Sistem Operasi: Smart TV</li>
                    <li>• Konektivitas: HDMI, USB, WiFi</li>
                    <li>• Konsumsi Daya: Hemat Energi</li>
                </ul>
            </div>

        </div>
    </section>
    <!-- RELATED -->
    <?php if ($related): ?>
        <section class="py-20 bg-gray-50">
            <div class="max-w-6xl mx-auto px-6">
                <h2 class="text-2xl font-semibold mb-10">Produk Terkait</h2>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($related as $r): ?>
                        <div class="bg-white border rounded-xl p-5">
                            <h3 class="font-medium mb-2"><?= htmlspecialchars($r['name']); ?></h3>
                            <a href="product-detail.php?slug=<?= urlencode($r['slug']); ?>"
                                class="text-primary text-sm">
                                Lihat Detail →
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php include 'footer.php'; ?>

    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });

        const thumbs = new Swiper('.productThumbs', {
            slidesPerView: 4,
            spaceBetween: 10,
            freeMode: true,
        });

        new Swiper('.productMain', {
            loop: true,
            zoom: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbs
            }
        });
    </script>

    <script src="assets/main.js"></script>

</body>

</html>