<?php

require 'admin/config/database.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang Kami | Kusuma Trisna Bali - Distributor & Service Elektronik</title>

    <meta name="description" content="Kenali Kusuma Trisna Bali, perusahaan yang berdiri sejak tahun 2019 dan bergerak di bidang distribusi serta layanan perbaikan berbagai produk elektronik di Tabanan, Bali. Kami menyediakan produk resmi, layanan teknis profesional, dan pelayanan terbaik bagi pelanggan.">

    <meta name="keywords" content="Tentang Kusuma Trisna Bali, Profil Kusuma Trisna Bali, Distributor Elektronik Bali, Service Elektronik Tabanan, Elektronik Bali, Toko Elektronik Tabanan">

    <meta name="author" content="Kusuma Trisna Bali">
    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">

    <link rel="canonical" href="https://www.kusumatrisnabali.com/about.php">

    <link rel="icon" href="admin/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">

    <meta name="theme-color" content="#0056b3">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="Tentang Kami | Kusuma Trisna Bali">
    <meta property="og:description" content="Kusuma Trisna Bali telah melayani pelanggan sejak tahun 2019 sebagai distributor dan pusat layanan perbaikan elektronik terpercaya di Tabanan, Bali.">
    <meta property="og:url" content="https://www.kusumatrisnabali.com/about.php">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:image" content="https://www.kusumatrisnabali.com/assets/about-og.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Tentang Kusuma Trisna Bali">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Tentang Kami | Kusuma Trisna Bali">
    <meta name="twitter:description" content="Mengenal lebih dekat Kusuma Trisna Bali sebagai distributor dan pusat layanan elektronik terpercaya di Bali.">
    <meta name="twitter:image" content="https://www.kusumatrisnabali.com/assets/about-og.jpg">

    <!-- Schema.org -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "AboutPage",
            "name": "Tentang Kusuma Trisna Bali",
            "url": "https://www.kusumatrisnabali.com/about.php",
            "description": "Profil Kusuma Trisna Bali, distributor dan pusat layanan perbaikan elektronik di Tabanan, Bali sejak tahun 2019.",
            "mainEntity": {
                "@type": "ElectronicsStore",
                "name": "Kusuma Trisna Bali",
                "url": "https://www.kusumatrisnabali.com/",
                "logo": "https://www.kusumatrisnabali.com/assets/logo.png",
                "image": "https://www.kusumatrisnabali.com/assets/about-og.jpg",
                "foundingDate": "2019",
                "telephone": "+6287779928897",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Tabanan",
                    "addressRegion": "Bali",
                    "addressCountry": "ID"
                }
            }
        }
    </script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Icons & Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

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
    <!-- //konten about here -->
    <section class="relative py-32">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="assets/img/slider4.jpg"
                alt="About Kusuma Trisna Bali"
                class="w-full h-full object-cover">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/20"></div>
            <!-- 
            Kalau mau sedikit lebih kontras:
            ganti bg-white/80 → bg-black/40
        -->
        </div>

        <!-- Content -->
        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-semibold text-primary mb-6"
                data-aos="fade-up">
                Tentang Kami
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-white"
                data-aos="fade-up" data-aos-delay="150">
                Kusuma Trisna Bali merupakan usaha yang bergerak di bidang
                distribusi dan layanan elektronik, dengan fokus pada
                pelayanan yang baik, dapat diandalkan, dan berorientasi
                pada kebutuhan pelanggan.
            </p>
        </div>
    </section>


    <section class="py-24">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-14 items-center">

            <div data-aos="fade-right">
                <span class="text-primary font-medium uppercase tracking-wider text-sm">
                    Who We Are
                </span>
                <h2 class="text-3xl font-semibold text-gray-900 mt-3 mb-5">
                    Distribusi & Layanan Elektronik
                </h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Kami melayani kebutuhan distribusi dan perbaikan produk
                    elektronik dengan proses kerja yang jelas, rapi,
                    dan sesuai dengan kebutuhan pelanggan.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Dengan pengalaman yang terus berkembang, kami berupaya
                    memberikan layanan yang konsisten dan dapat diandalkan
                    dalam setiap pekerjaan.
                </p>
            </div>

            <div data-aos="fade-left">
                <img src="assets/img/slider1.jpg"
                    alt="Team Kusuma Trisna Bali"
                    class="rounded-xl shadow-md">
            </div>

        </div>
    </section>

    <section class="bg-gray-50 py-24">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-14">
                <h2 class="text-3xl font-semibold text-gray-900 mb-4"
                    data-aos="fade-up">
                    Nilai Perusahaan
                </h2>
                <p class="text-gray-600"
                    data-aos="fade-up" data-aos-delay="100">
                    Nilai yang menjadi pedoman kami dalam bekerja dan melayani pelanggan
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">

                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm"
                    data-aos="fade-up">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-5">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Cara Kerja yang Baik
                    </h3>
                    <p class="text-gray-600">
                        Setiap pekerjaan dilakukan dengan tertib, jelas,
                        dan penuh tanggung jawab.
                    </p>
                </div>

                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-5">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Terus Berkembang
                    </h3>
                    <p class="text-gray-600">
                        Kami terus belajar dan menyesuaikan layanan
                        sesuai dengan kebutuhan pelanggan.
                    </p>
                </div>

                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-5">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Dapat Diandalkan
                    </h3>
                    <p class="text-gray-600">
                        Berusaha menjaga kepercayaan pelanggan melalui
                        hasil kerja yang konsisten dan bertanggung jawab.
                    </p>
                </div>

            </div>
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
                            <a href="products.php?partner=<?= $partner['slug']; ?>">
                                <img
                                    src="admin/uploads/partners/<?= htmlspecialchars($partner['logo']); ?>"
                                    alt="<?= htmlspecialchars($partner['name']); ?>"
                                    class="h-auto object-contain                            hover:grayscale-0 hover:opacity-100 transition">

                            </a>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>


        </div>
    </section>
    <?php include 'footer.php'; ?>

    <!-- Script -->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 900,
            once: true,
            easing: 'ease-out-cubic'
        });
    </script>

    <script src="assets/main.js"></script>
</body>

</html>