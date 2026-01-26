<?php

require 'admin/config/database.php';

$stmt = $pdo->prepare("
    SELECT name, logo 
    FROM partners
    WHERE is_active = 1
    ORDER BY sort_order ASC, id DESC
");
$stmt->execute();
$partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $pdo->prepare("
    SELECT
        p.id,
        p.name,
        p.slug,
        p.short_description,
        pi.image
    FROM products p
    LEFT JOIN product_images pi
        ON pi.product_id = p.id
        AND pi.is_main = 1
    WHERE p.is_active = 1
      AND p.is_featured = 1
      AND p.deleted_at IS NULL
    ORDER BY p.sort_order ASC, p.created_at DESC
    LIMIT 4
");

$stmt1->execute();
$featuredProducts = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare("
    SELECT
        p.id,
        p.name,
        p.slug,
        p.short_description,
        pi.image
    FROM products p
    LEFT JOIN product_images pi
        ON pi.product_id = p.id
        AND pi.is_main = 1
    WHERE p.is_active = 1
      AND p.deleted_at IS NULL
    ORDER BY p.created_at DESC
    LIMIT 4
");
$stmt2->execute();

$latestProducts = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kusuma Trisna Bali</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    <link rel="stylesheet" href="assets/style.css">
</head>

<body class="font-['IBM_Plex_Sans'] text-gray-800 tracking-tight leading-relaxed">
    <?php include 'header.php'; ?>

    <!-- HERO SLIDER -->
    <section class="h-screen relative">

        <div class="swiper heroSwiper h-full">

            <div class="swiper-wrapper">

                <!-- SLIDE 1 -->
                <div class="swiper-slide relative">

                    <img
                        src="assets/img/slider1.jpg"
                        class="w-full h-full object-cover"
                        alt="Authorized Service">

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/30"></div>

                    <!-- Content -->
                    <div class="absolute inset-0 flex items-center">
                        <div class="max-w-7xl mx-auto px-6 text-white">

                            <p class="text-sm md:text-base font-medium uppercase tracking-widest text-gray-300 mb-3">
                                Authorized Service Center
                            </p>

                            <h1 class="text-4xl md:text-6xl font-semibold leading-tight tracking-tight mb-6 max-w-3xl">
                                Solusi Layanan Resmi & Teknis
                                <span class="text-primary">Berkualitas Tinggi</span>
                            </h1>

                            <p class="text-gray-200 max-w-xl mb-8 text-base md:text-lg">
                                Kusuma Trisna Bali menyediakan produk dan layanan resmi
                                untuk kebutuhan industri dan komersial dengan standar profesional.
                            </p>

                            <div class="flex flex-wrap gap-4">
                                <a href="#service"
                                    class="inline-flex items-center gap-3 bg-primary px-6 py-3 rounded-md
                       font-semibold text-white transition hover:bg-darkred">
                                    Ajukan Layanan
                                    <i class="fa fa-arrow-right"></i>
                                </a>

                                <a href="#products"
                                    class="inline-flex items-center gap-3 border border-white/70
                       px-6 py-3 rounded-md font-medium text-white
                       hover:bg-white hover:text-gray-900 transition">
                                    Lihat Produk
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- SLIDE 2 -->
                <div class="swiper-slide relative">

                    <img
                        src="https://images.unsplash.com/photo-1604014237800-1c9102c219da"
                        class="w-full h-full object-cover"
                        alt="Produk Terlaris">

                    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/30"></div>

                    <div class="absolute inset-0 flex items-center">
                        <div class="max-w-7xl mx-auto px-6 text-white">

                            <p class="text-sm md:text-base font-medium uppercase tracking-widest text-gray-300 mb-3">
                                Produk & Brand Resmi
                            </p>

                            <h2 class="text-4xl md:text-6xl font-semibold leading-tight tracking-tight mb-6 max-w-3xl">
                                Produk Terlaris &
                                <span class="text-primary">Terpercaya</span>
                            </h2>

                            <p class="text-gray-200 max-w-xl mb-8 text-base md:text-lg">
                                Menyediakan berbagai produk elektronik resmi
                                dari brand ternama dengan dukungan teknis penuh.
                            </p>

                            <a href="#products"
                                class="inline-flex items-center gap-3 bg-primary px-6 py-3 rounded-md
                     font-semibold text-white hover:bg-darkred transition">
                                Jelajahi Produk
                                <i class="fa fa-arrow-right"></i>
                            </a>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

        </div>
    </section>

    <!-- TENTANG SINGKAT -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

            <!-- Text -->
            <div data-aos="fade-right">
                <span class="inline-block mb-3 text-sm font-semibold text-primary">
                    Tentang Kami
                </span>

                <h2 class="text-3xl md:text-4xl font-bold mb-5 leading-tight">
                    Authorized Service & Distribusi
                    Produk Elektronik Terpercaya
                </h2>

                <p class="text-gray-600 mb-4">
                    Kusuma Trisna Bali berdiri sejak tahun <strong>2019</strong> dan bergerak
                    di bidang <strong>distribusi serta authorized service</strong>
                    berbagai produk elektronik dari merek ternama.
                </p>

                <p class="text-gray-600 mb-6">
                    Dengan dukungan teknisi bersertifikat dan standar resmi pabrikan,
                    kami berkomitmen memberikan layanan yang profesional, terpercaya,
                    dan berkualitas bagi pelanggan serta mitra bisnis.
                </p>

                <a href="about.html"
                    class="inline-flex items-center px-6 py-3 rounded-lg
                      bg-primary text-white font-semibold
                      hover:bg-primary/90 transition">
                    Selengkapnya Tentang Kami
                </a>
            </div>

            <!-- Highlight Box -->
            <div data-aos="fade-up" class="grid grid-cols-2 gap-4 sm:gap-6">

                <div class="p-4 sm:p-6 bg-blue-50 rounded-2xl text-center
                shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-primary mb-1">
                        2019
                    </h3>
                    <p class="text-gray-600 text-xs sm:text-sm">
                        Tahun Berdiri
                    </p>
                </div>

                <div class="p-4 sm:p-6 bg-blue-50 rounded-2xl text-center
                shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-primary mb-1">
                        8+
                    </h3>
                    <p class="text-gray-600 text-xs sm:text-sm">
                        Brand Resmi
                    </p>
                </div>

                <div class="p-4 sm:p-6 bg-blue-50 rounded-2xl text-center
                shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-primary mb-1">
                        Authorized
                    </h3>
                    <p class="text-gray-600 text-xs sm:text-sm">
                        Service Center
                    </p>
                </div>

                <div class="p-4 sm:p-6 bg-blue-50 rounded-2xl text-center
                shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-primary mb-1">
                        Profesional
                    </h3>
                    <p class="text-gray-600 text-xs sm:text-sm">
                        Teknisi Bersertifikat
                    </p>
                </div>

            </div>

        </div>
    </section>
    <!-- LAYANAN UTAMA -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-14">
                <span class="inline-block mb-3 text-sm font-semibold text-primary">
                    Layanan Kami
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Layanan Utama
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Layanan resmi dengan standar pabrikan untuk memastikan performa
                    dan keandalan produk elektronik Anda.
                </p>
            </div>

            <!-- Grid -->
            <div class="grid md:grid-cols-3 gap-8">

                <!-- Service TV -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg
                        transition duration-300 text-center"
                    data-aos="fade-up">
                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary">
                        <!-- TV Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8"
                            fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="5" width="18" height="12" rx="2" />
                            <path d="M8 21h8" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">
                        Service TV
                    </h3>

                    <p class="text-gray-600 mb-6">
                        Layanan perbaikan TV LED, LCD, dan Smart TV dengan dukungan
                        teknisi bersertifikat serta suku cadang resmi.
                    </p>

                    <a href="service.html"
                        class="font-semibold text-primary hover:underline">
                        Selengkapnya →
                    </a>
                </div>

                <!-- Service AC -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg
                        transition duration-300 text-center"
                    data-aos="fade-up" data-aos-delay="100">


                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-snowflake"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">
                        Service AC
                    </h3>

                    <p class="text-gray-600 mb-6">
                        Perawatan dan perbaikan AC untuk menjaga kenyamanan serta
                        efisiensi pendingin ruangan Anda.
                    </p>

                    <a href="service.html"
                        class="font-semibold text-primary hover:underline">
                        Selengkapnya →
                    </a>
                </div>

                <!-- Elektronik Rumah Tangga -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg
                        transition duration-300 text-center"
                    data-aos="fade-up" data-aos-delay="200">

                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-plug"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">
                        Elektronik Rumah Tangga
                    </h3>

                    <p class="text-gray-600 mb-6">
                        Layanan perbaikan berbagai produk elektronik rumah tangga
                        dengan standar layanan resmi dan terpercaya.
                    </p>

                    <a href="service.html"
                        class="font-semibold text-primary hover:underline">
                        Selengkapnya →
                    </a>
                </div>

            </div>
        </div>
    </section>
    <!-- PRODUK UNGGULAN -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-14">
                <span class="inline-block mb-3 text-sm font-semibold text-primary">
                    Produk Kami
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Produk Unggulan
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Produk elektronik pilihan dengan kualitas terjamin dan dukungan
                    layanan resmi dari merek terpercaya.
                </p>
            </div>

            <!-- Grid Produk -->
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-8">

                <?php if ($featuredProducts): ?>
                    <?php foreach ($featuredProducts as $product): ?>

                        <div class="bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition">
                            <div class="aspect-[4/3] flex items-center justify-center p-4 bg-white rounded-t-2xl">
                                <img
                                    src="admin/uploads/products/<?= htmlspecialchars($product['image'] ?? 'default.png'); ?>"
                                    alt="<?= htmlspecialchars($product['name']); ?>"
                                    class="max-h-full object-contain">

                            </div>

                            <div class="p-5">
                                <h3 class="font-semibold text-lg mb-1">
                                    <?= htmlspecialchars($product['name']); ?>
                                </h3>

                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    <?= $product['short_description']; ?>
                                </p>

                                <a href="produk/<?= htmlspecialchars($product['slug']); ?>"
                                    class="inline-flex items-center font-semibold text-primary hover:underline mt-2">
                                    Lihat Detail
                                    <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="col-span-4 text-center text-gray-500">
                        Produk unggulan belum tersedia
                    </p>
                <?php endif; ?>

            </div>


            <!-- CTA -->
            <div class="text-center mt-14">
                <a href="produk.html"
                    class="inline-flex items-center px-8 py-3 rounded-lg
                      bg-primary text-white font-semibold
                      hover:bg-primary/90 transition">
                    Lihat Semua Produk
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>

        </div>
    </section>


    <!-- PRODUK TERBARU -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Heading -->
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-3" data-aos="fade-up">
                    Produk Terbaru
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Produk elektronik terbaru dengan kualitas terjamin dan dukungan layanan resmi.
                </p>
            </div>

            <!-- Grid Produk -->
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-8">

                <?php if ($latestProducts): ?>
                    <?php foreach ($latestProducts as $product): ?>

                        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition duration-300 group"
                            data-aos="zoom-in">

                            <div class="overflow-hidden rounded-t-2xl">
                                <img
                                    src="admin/uploads/products/<?= htmlspecialchars($product['image'] ?? 'default.png'); ?>"
                                    class="w-full h-48 object-contain bg-white p-4"
                                    alt="<?= htmlspecialchars($product['name']); ?>">
                            </div>

                            <div class="p-5">
                                <h3 class="font-semibold text-lg mb-1">
                                    <?= htmlspecialchars($product['name']); ?>
                                </h3>

                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                    <?= $product['short_description']; ?>
                                </p>

                                <ul class="text-sm text-gray-500 mb-4 space-y-1">
                                    <!-- <li>✔ Garansi Resmi</li>
                                    <li>✔ Layanan Authorized Service</li>
                                    <li>✔ Kualitas Terpercaya</li> -->
                                </ul>

                                <a href="produk/<?= htmlspecialchars($product['slug']); ?>"
                                    class="inline-block w-full text-center px-4 py-2 rounded-lg
                              bg-primary text-white font-semibold
                              hover:bg-primary/90 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="col-span-4 text-center text-gray-500">
                        Produk terbaru belum tersedia
                    </p>
                <?php endif; ?>

            </div>

        </div>
    </section>
    <!-- IKLAN / PROMO -->
    <section class="py-20 bg-primary text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center gap-12">

            <!-- Content -->
            <div data-aos="fade-right">
                <span class="inline-block mb-3 px-4 py-1 text-sm rounded-full
                         bg-white/20 text-white">
                    Authorized Service
                </span>

                <h2 class="text-3xl md:text-4xl font-bold mb-4 leading-tight">
                    Promo Service Resmi
                </h2>

                <p class="text-white/90 mb-6 max-w-md">
                    Dapatkan layanan perbaikan produk elektronik dengan teknisi
                    bersertifikat dan standar resmi pabrikan.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#"
                        class="px-6 py-3 rounded-lg bg-white text-primary
                          font-semibold hover:bg-gray-100 transition">
                        Ajukan Service
                    </a>

                    <a href="#"
                        class="px-6 py-3 rounded-lg border border-white
                          text-white font-semibold
                          hover:bg-white hover:text-primary transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="rounded-2xl overflow-hidden shadow-xl h-[320px] md:h-[380px] relative">
                <img src="assets/img/promo1.jpg"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/10"></div>
            </div>


        </div>
    </section>
    <!-- KENAPA MEMILIH KAMI -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-14">
                <span class="inline-block mb-3 text-sm font-semibold text-primary">
                    Keunggulan Kami
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Kenapa Memilih Kami
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Komitmen kami adalah memberikan layanan resmi yang terpercaya
                    dengan standar kualitas terbaik.
                </p>
            </div>

            <!-- Grid -->
            <div class="grid md:grid-cols-3 gap-8">

                <!-- Authorized Service -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg transition text-center"
                    data-aos="fade-up">

                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-certificate"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">
                        Authorized Service
                    </h3>

                    <p class="text-gray-600">
                        Layanan resmi yang sesuai standar pabrikan untuk menjamin
                        keaslian suku cadang dan kualitas perbaikan.
                    </p>
                </div>

                <!-- Teknisi Bersertifikat -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg transition text-center"
                    data-aos="fade-up" data-aos-delay="100">

                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">
                        Teknisi Bersertifikat
                    </h3>

                    <p class="text-gray-600">
                        Ditangani oleh teknisi berpengalaman dan bersertifikat
                        untuk memastikan proses perbaikan yang aman dan tepat.
                    </p>
                </div>

                <!-- Garansi & Standar Pabrikan -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg transition text-center"
                    data-aos="fade-up" data-aos-delay="200">

                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">
                        Garansi & Standar Pabrikan
                    </h3>

                    <p class="text-gray-600">
                        Setiap layanan diberikan dengan garansi dan mengikuti
                        standar resmi pabrikan untuk hasil yang maksimal.
                    </p>
                </div>

            </div>
        </div>
    </section>
    <!-- KENAPA MEMILIH KAMI -->
    <section class="relative py-24
                bg-gradient-to-b from-primary/5 via-white to-gray-50
                overflow-hidden">

        <!-- Top Wave -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[60px]"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1440 90"
                preserveAspectRatio="none">
                <path fill="#ffffff"
                    d="M0,30 C240,70 480,10 720,20 960,30 1200,60 1440,40 L1440,0 L0,0 Z">
                </path>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-16">
                <span class="inline-block mb-3 text-sm font-semibold text-primary">
                    Keunggulan Kami
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Kenapa Memilih Kami
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Komitmen kami adalah memberikan layanan resmi yang terpercaya
                    dengan standar kualitas terbaik.
                </p>
            </div>

            <!-- Grid -->
            <div class="grid md:grid-cols-3 gap-8">

                <!-- Authorized Service -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg transition text-center"
                    data-aos="fade-up">

                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-certificate"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">
                        Authorized Service
                    </h3>

                    <p class="text-gray-600">
                        Layanan resmi sesuai standar pabrikan untuk menjamin
                        keaslian suku cadang dan kualitas perbaikan.
                    </p>
                </div>

                <!-- Teknisi Bersertifikat -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg transition text-center"
                    data-aos="fade-up" data-aos-delay="100">

                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">
                        Teknisi Bersertifikat
                    </h3>

                    <p class="text-gray-600">
                        Ditangani oleh teknisi berpengalaman dan bersertifikat
                        untuk memastikan perbaikan yang aman dan tepat.
                    </p>
                </div>

                <!-- Garansi -->
                <div class="bg-white p-8 rounded-2xl
                        shadow-md hover:shadow-lg transition text-center"
                    data-aos="fade-up" data-aos-delay="200">

                    <div class="w-16 h-16 mx-auto mb-6
                            flex items-center justify-center
                            rounded-full bg-primary/10 text-primary text-2xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">
                        Garansi & Standar Pabrikan
                    </h3>

                    <p class="text-gray-600">
                        Setiap layanan diberikan dengan garansi dan mengikuti
                        standar resmi pabrikan.
                    </p>
                </div>

            </div>
        </div>

        <!-- Bottom Wave -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[60px]"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1440 90"
                preserveAspectRatio="none">
                <path fill="#f9fafb"
                    d="M0,40 C240,10 480,60 720,50 960,40 1200,20 1440,30 L1440,90 L0,90 Z">
                </path>
            </svg>
        </div>

    </section>
    <!-- BRAND PARTNER -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Heading -->
            <div class="text-center mb-14">
                <span class="inline-block mb-3 text-sm font-semibold text-primary">
                    Brand Partner
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Authorized Brand Partner
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Kami merupakan mitra resmi dan authorized service untuk berbagai
                    merek elektronik terpercaya.
                </p>
            </div>


            <!-- Slider -->
            <div class="swiper brandSwiper">
                <div class="swiper-wrapper items-center">

                    <?php foreach ($partners as $partner): ?>
                        <div class="swiper-slide flex justify-center">
                            <img
                                src="admin/uploads/partners/<?= htmlspecialchars($partner['logo']); ?>"
                                alt="<?= htmlspecialchars($partner['name']); ?>"
                                class="h-14 object-contain grayscale opacity-70
                           hover:grayscale-0 hover:opacity-100 transition">
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>


        </div>
    </section>
    <!-- FOOTER -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="assets/main.js"></script>
</body>

</html>