<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | Kusuma Trisna Bali</title>

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
    <style>
        .productMain img {
            max-height: 380px;
            object-fit: contain;
        }


        /* Kecilkan arrow */
        .productMain .swiper-button-next,
        .productMain .swiper-button-prev {
            width: 36px;
            height: 36px;
        }

        .productMain .swiper-button-next::after,
        .productMain .swiper-button-prev::after {
            font-size: 16px;
            font-weight: bold;
        }



        .thumb-box {
            height: 80px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        .thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Active thumbnail */
        .productThumbs .swiper-slide-thumb-active .thumb-box {
            border: 2px solid #c1121f;
            /* primary */
        }

        .productMain .swiper-zoom-container {
            cursor: zoom-in;
        }

        .swiper-zoomed .swiper-zoom-container {
            cursor: zoom-out;
        }

        .swiper-button-next {
            right: 1px;
        }

        .swiper-button-prev {
            left: 1px;
        }
    </style>
</head>

<body class="font-['IBM_Plex_Sans'] text-gray-800 tracking-tight leading-relaxed">
    <?php include 'header.php'; ?>

    <!-- HERO -->
    <section class="relative pt-40 pb-32">
        <!-- Background -->
        <div class="absolute inset-0">
            <img src="assets/img/slider1.jpg"
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

                            <div class="swiper-slide">
                                <div class="swiper-zoom-container">
                                    <img src="assets/img/tv1.webp" alt="Smart TV Depan">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="swiper-zoom-container">
                                    <img src="assets/img/tv2.webp" alt="Smart TV Samping">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="swiper-zoom-container">
                                    <img src="assets/img/tv3.webp" alt="Smart TV Belakang">
                                </div>
                            </div>

                        </div>

                        <!-- Navigation -->
                        <div class="swiper-button-next text-primary"></div>
                        <div class="swiper-button-prev text-primary"></div>
                    </div>

                    <!-- THUMBNAIL -->
                    <div class="swiper productThumbs">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide cursor-pointer">
                                <div class="thumb-box">
                                    <img src="assets/img/tv1.webp" alt="">
                                </div>
                            </div>

                            <div class="swiper-slide cursor-pointer">
                                <div class="thumb-box">
                                    <img src="assets/img/tv2.webp" alt="">
                                </div>
                            </div>

                            <div class="swiper-slide cursor-pointer">
                                <div class="thumb-box">
                                    <img src="assets/img/tv3.webp" alt="">
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>

            <!-- PRODUCT INFO -->
            <div data-aos="fade-left">
                <span class="text-sm text-primary font-medium">
                    Samsung • Televisi
                </span>

                <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 mt-3 mb-5">
                    Smart TV 55 Inch UHD
                </h1>

                <p class="text-gray-600 mb-6 leading-relaxed">
                    Smart TV dengan resolusi Ultra HD yang menghadirkan kualitas
                    gambar tajam, warna natural, dan teknologi terkini untuk
                    kebutuhan rumah, hotel, dan bisnis.
                </p>

                <!-- PRODUCT META -->
                <div class="grid grid-cols-2 gap-6 text-sm text-gray-700 mb-8">
                    <div><span class="font-medium">Brand:</span> Samsung</div>
                    <div><span class="font-medium">Kategori:</span> Audio Visual</div>
                    <div><span class="font-medium">Subkategori:</span> Televisi</div>
                    <div><span class="font-medium">Garansi:</span> 1 Tahun</div>
                </div>

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
                    <a href="https://wa.me/6281234567890"
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
    <section class="bg-gray-50 py-20">
        <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16">

            <div data-aos="fade-up">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                    Deskripsi Produk
                </h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Produk ini dirancang untuk memberikan pengalaman visual terbaik
                    dengan teknologi terbaru. Cocok digunakan untuk berbagai
                    kebutuhan, baik personal maupun profesional.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Dengan desain modern dan fitur pintar, produk ini menawarkan
                    kemudahan penggunaan serta efisiensi tinggi.
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

    <!-- RELATED PRODUCTS -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900"
                    data-aos="fade-up">
                    Produk Terkait
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition"
                    data-aos="fade-up">
                    <div class="h-48 flex items-center justify-center bg-gray-50">
                        <img src="assets/img/product1.jpg"
                            alt="Product"
                            class="max-h-36 object-contain">
                    </div>
                    <div class="p-5">
                        <h3 class="font-medium text-gray-900 mb-2">
                            Monitor Profesional 27”
                        </h3>
                        <a href="detail-produk.php"
                            class="text-primary text-sm font-medium hover:underline">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="h-48 flex items-center justify-center bg-gray-50">
                        <img src="assets/img/product-3.jpg"
                            alt="Product"
                            class="max-h-36 object-contain">
                    </div>
                    <div class="p-5">
                        <h3 class="font-medium text-gray-900 mb-2">
                            Speaker Aktif Premium
                        </h3>
                        <a href="detail-produk.php"
                            class="text-primary text-sm font-medium hover:underline">
                            Lihat Detail
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>
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