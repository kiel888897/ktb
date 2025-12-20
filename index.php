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

    <style>
        .nav-blur {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, .8);
        }
    </style>
</head>

<body class="font-['IBM_Plex_Sans'] text-gray-800 tracking-tight leading-relaxed">
    <!-- HEADER -->
    <header id="mainHeader"
        class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent">

        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- LOGO -->
            <div class="flex items-center gap-3">
                <img src="assets/img/logo.png" class="h-9">
                <span id="logoNav" class="font-bold text-lg text-white transition-colors">Kusuma Trisna Bali</span>
            </div>

            <!-- DESKTOP NAV -->
            <nav id="desktopNav"
                class="hidden md:flex gap-10 font-medium text-white transition-colors duration-300">
                <a href="#" class="hover:text-primary">Home</a>
                <a href="#" class="hover:text-primary">About</a>
                <a href="#" class="hover:text-primary">Produk</a>
                <a href="#" class="hover:text-primary">Service</a>
                <a href="#" class="hover:text-primary">Kontak</a>
            </nav>

            <!-- CTA -->
            <a id="desktopCTA"
                class="hidden md:inline-block px-5 py-2 rounded-lg font-semibold transition
      border border-white text-white hover:bg-white hover:text-primary">
                <i class="fa-solid fa-phone-volume"></i>
                0812-3456-7890
            </a>

            <!-- MOBILE BUTTON -->
            <button id="openMenu"
                class="md:hidden text-2xl text-white transition">
                <i class="fa fa-bars"></i>
            </button>

        </div>
    </header>

    <!-- MOBILE MENU OVERLAY -->
    <div id="mobileMenu"
        class="fixed inset-0 bg-black/60 z-50 hidden">

        <!-- PANEL -->
        <div class="absolute right-0 top-0 w-4/5 max-w-sm h-full bg-white shadow-2xl
              translate-x-full transition-transform duration-300">

            <!-- HEADER MENU -->
            <div class="flex items-center justify-between p-6 border-b">
                <img src="assets/img/logo.png" class="h-9">
                <button id="closeMenu" class="text-2xl text-gray-700">
                    <i class="fa fa-xmark"></i>
                </button>
            </div>

            <!-- MENU ITEMS -->
            <nav class="p-6 flex flex-col gap-6 text-gray-900 font-semibold text-lg">

                <a href="#" class="flex items-center gap-4 hover:text-primary">
                    <i class="fa fa-house text-primary"></i> Home
                </a>

                <a href="#" class="flex items-center gap-4 hover:text-primary">
                    <i class="fa fa-building"></i> About
                </a>

                <a href="#" class="flex items-center gap-4 hover:text-primary">
                    <i class="fa fa-box"></i> Produk
                </a>

                <a href="#" class="flex items-center gap-4 hover:text-primary">
                    <i class="fa fa-screwdriver-wrench"></i> Service
                </a>

                <hr>

                <a href="#" class="flex items-center gap-4 text-primary font-bold">
                    <i class="fa fa-phone"></i> Kontak
                </a>

            </nav>

        </div>
    </div>


    <!-- HERO SLIDER -->
    <section class="h-screen relative">

        <div class="swiper h-full">

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
            <div data-aos="fade-up" class="grid grid-cols-2 gap-6">

                <div class="p-6 bg-blue-50 rounded-2xl text-center shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-3xl font-bold text-primary mb-1">2019</h3>
                    <p class="text-gray-600 text-sm">Tahun Berdiri</p>
                </div>

                <div class="p-6 bg-blue-50 rounded-2xl text-center shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-3xl font-bold text-primary mb-1">8+</h3>
                    <p class="text-gray-600 text-sm">Brand Resmi</p>
                </div>

                <div class="p-6 bg-blue-50 rounded-2xl text-center shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-3xl font-bold text-primary mb-1">Authorized</h3>
                    <p class="text-gray-600 text-sm">Service Center</p>
                </div>

                <div class="p-6 bg-blue-50 rounded-2xl text-center shadow-lg hover:shadow-xl transition duration-300">
                    <h3 class="text-3xl font-bold text-primary mb-1">Profesional</h3>
                    <p class="text-gray-600 text-sm">Teknisi Bersertifikat</p>
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

                <!-- Card Produk -->
                <div class="bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition">
                    <div class="aspect-[4/3] flex items-center justify-center p-4 bg-white rounded-t-2xl">
                        <img src="assets/img/product1.jpg"
                            alt="Smart TV LED 43 Inch"
                            class="max-h-full object-contain">
                    </div>

                    <div class="p-5">
                        <h3 class="font-semibold text-lg mb-1">
                            Smart TV LED 43"
                        </h3>

                        <p class="text-sm text-gray-600 mb-4">
                            Resolusi Full HD, Android TV, hemat energi.
                        </p>

                        <a href="produk.html"
                            class="inline-flex items-center font-semibold text-primary hover:underline">
                            Lihat Detail
                            <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Card Produk 2 -->
                <div class="bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition">
                    <div class="aspect-[4/3] flex items-center justify-center p-4 bg-white rounded-t-2xl">
                        <img src="assets/img/product2.jpg"
                            alt="AC Split"
                            class="max-h-full object-contain">
                    </div>

                    <div class="p-5">
                        <h3 class="font-semibold text-lg mb-1">
                            AC Split
                        </h3>

                        <p class="text-sm text-gray-600 mb-4">
                            Pendingin ruangan efisien dan tahan lama.
                        </p>

                        <a href="produk.html"
                            class="inline-flex items-center font-semibold text-primary hover:underline">
                            Lihat Detail
                            <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Card Produk 3 -->
                <div class="bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition">
                    <div class="aspect-[4/3] flex items-center justify-center p-4 bg-white rounded-t-2xl">
                        <img src="assets/img/product3.jpg"
                            alt="Mesin Cuci"
                            class="max-h-full object-contain">
                    </div>

                    <div class="p-5">
                        <h3 class="font-semibold text-lg mb-1">
                            Mesin Cuci
                        </h3>

                        <p class="text-sm text-gray-600 mb-4">
                            Kapasitas besar dengan performa optimal.
                        </p>

                        <a href="produk.html"
                            class="inline-flex items-center font-semibold text-primary hover:underline">
                            Lihat Detail
                            <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Card Produk 4 -->
                <div class="bg-gray-50 rounded-2xl shadow-md hover:shadow-lg transition">
                    <div class="aspect-[4/3] flex items-center justify-center p-4 bg-white rounded-t-2xl">
                        <img src="assets/img/product4.jpg"
                            alt="Water Heater"
                            class="max-h-full object-contain">
                    </div>

                    <div class="p-5">
                        <h3 class="font-semibold text-lg mb-1">
                            Water Heater
                        </h3>

                        <p class="text-sm text-gray-600 mb-4">
                            Pemanas air aman dan hemat energi.
                        </p>

                        <a href="produk.html"
                            class="inline-flex items-center font-semibold text-primary hover:underline">
                            Lihat Detail
                            <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

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

                <!-- Card Produk -->
                <div class="bg-white rounded-2xl shadow hover:shadow-xl transition duration-300 group"
                    data-aos="zoom-in">

                    <div class="overflow-hidden rounded-t-2xl">
                        <img src="assets/img/tv1.webp"
                            class="w-full h-48 object-contain bg-white p-4"
                            alt="Smart TV LED">

                    </div>

                    <div class="p-5">
                        <h3 class="font-semibold text-lg mb-1">
                            Smart TV LED 43"
                        </h3>

                        <p class="text-sm text-gray-600 mb-3">
                            Resolusi Full HD, Android TV, hemat energi.
                        </p>

                        <ul class="text-sm text-gray-500 mb-4 space-y-1">
                            <li>✔ Garansi Resmi</li>
                            <li>✔ Layanan Authorized Service</li>
                            <li>✔ Kualitas Terpercaya</li>
                        </ul>

                        <a href="#"
                            class="inline-block w-full text-center px-4 py-2 rounded-lg
                              bg-primary text-white font-semibold
                              hover:bg-primary/90 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                <!-- Duplicate card untuk produk lain -->
                <!-- Tinggal ganti gambar & konten -->

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
            <div data-aos="fade-up" class="relative">
                <div class="rounded-2xl overflow-hidden shadow-xl">
                    <img src="assets/img/promo1.jpg"
                        alt="Promo Service Resmi"
                        class="w-full h-[320px] object-contain bg-white p-6">
                </div>
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

                    <!-- Logo Item -->
                    <div class="swiper-slide flex justify-center">
                        <img src="assets/img/brands/tcl.png"
                            alt="TCL"
                            class="h-14 object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition">
                    </div>

                    <div class="swiper-slide flex justify-center">
                        <img src="assets/img/brands/coocaa.png"
                            alt="Coocaa"
                            class="h-14 object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition">
                    </div>

                    <div class="swiper-slide flex justify-center">
                        <img src="assets/img/brands/akari.png"
                            alt="Akari"
                            class="h-14 object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition">
                    </div>

                    <div class="swiper-slide flex justify-center">
                        <img src="assets/img/brands/aqua.png"
                            alt="Aqua"
                            class="h-14 object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition">
                    </div>

                    <div class="swiper-slide flex justify-center">
                        <img src="https://www.beko.com/etc.clientlibs/bekoglobal/clientlibs/bekoglobal-rainbow/resources/images/bekoLogoBlueDesktop.svg"
                            alt="Beko"
                            class="h-14 object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition">
                    </div>

                    <div class="swiper-slide flex justify-center">
                        <img src="assets/img/brands/ariston.png"
                            alt="Ariston"
                            class="h-14 object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition">
                    </div>

                    <div class="swiper-slide flex justify-center">
                        <img src="assets/img/brands/toshiba.png"
                            alt="Toshiba"
                            class="h-14 object-contain grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition">
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300 py-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold mb-4 text-white">KTB</h3>
                <p class="text-sm">Authorized Service & Produk Resmi</p>
            </div>
            <div>
                <h4 class="font-semibold mb-3 text-white">Menu</h4>
                <ul class="space-y-2 text-sm">
                    <li>Home</li>
                    <li>Produk</li>
                    <li>Service</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-3 text-white">Kontak</h4>
                <p class="text-sm">Bali, Indonesia</p>
            </div>
            <div>
                <h4 class="font-semibold mb-3 text-white">Sosial</h4>
                <div class="flex gap-4 text-xl">
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-facebook"></i>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        new Swiper('.swiper', {
            loop: true,
            speed: 800,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });
    </script>
    <script>
        const brandSwiper = new Swiper('.brandSwiper', {
            loop: true,
            speed: 3000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            slidesPerView: 2,
            spaceBetween: 30,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 6,
                },
            },
        });
    </script>

    <script>
        const header = document.getElementById('mainHeader');
        const desktopNav = document.getElementById('desktopNav');
        const logoNav = document.getElementById('logoNav');
        const desktopCTA = document.getElementById('desktopCTA');
        const openBtn = document.getElementById('openMenu');
        const closeBtn = document.getElementById('closeMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobilePanel = mobileMenu.querySelector('div');

        function setScrolled(state) {
            if (state) {
                header.classList.remove('bg-transparent');
                header.classList.add('bg-white', 'shadow');
                desktopNav.classList.remove('text-white');
                desktopNav.classList.add('text-gray-900');
                logoNav.classList.remove('text-white');
                logoNav.classList.add('text-gray-900');
                desktopCTA.classList.remove('border-white', 'text-white');
                desktopCTA.classList.add('bg-primary', 'text-white');
                openBtn.classList.remove('text-white');
                openBtn.classList.add('text-gray-900');
            } else {
                header.classList.add('bg-transparent');
                header.classList.remove('bg-white', 'shadow');
                desktopNav.classList.add('text-white');
                desktopNav.classList.remove('text-gray-900');

                logoNav.classList.add('text-white');
                logoNav.classList.remove('text-gray-900');
                desktopCTA.classList.add('border-white', 'text-white');
                desktopCTA.classList.remove('bg-primary');
                openBtn.classList.add('text-white');
                openBtn.classList.remove('text-gray-900');
            }
        }

        window.addEventListener('scroll', () => {
            setScrolled(window.scrollY > 60);
        });

        openBtn.onclick = () => {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => mobilePanel.classList.remove('translate-x-full'), 10);
            document.body.classList.add('overflow-hidden');
            setScrolled(true);
        };

        closeBtn.onclick = () => {
            mobilePanel.classList.add('translate-x-full');
            setTimeout(() => mobileMenu.classList.add('hidden'), 300);
            document.body.classList.remove('overflow-hidden');
        };
    </script>

</body>

</html>