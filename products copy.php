<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product | Kusuma Trisna Bali</title>

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
            <img src="assets/img/slider1.jpg"
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
                Produk Kami
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-white"
                data-aos="fade-up" data-aos-delay="150">
                Beragam produk dan layanan yang kami sediakan untuk
                mendukung kebutuhan bisnis dan pelanggan Anda.
            </p>
        </div>
    </section>
    <!-- PRODUCT LIST -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">

            <!-- FILTER BAR -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 mb-12"
                data-aos="fade-up">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                    <!-- Search -->
                    <div class="md:col-span-2">
                        <div class="relative">
                            <input type="text"
                                placeholder="Nama produk..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-11 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option>Semua Brand</option>
                            <option>Samsung</option>
                            <option>LG</option>
                            <option>Sony</option>
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option>Semua Kategori</option>
                            <option>Elektronik</option>
                            <option>Audio Visual</option>
                            <option>Peralatan Rumah</option>
                        </select>
                    </div>

                    <!-- Subkategori -->
                    <div>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option>Semua</option>
                            <option>Televisi</option>
                            <option>Speaker</option>
                            <option>Monitor</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- PRODUCT GRID -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- PRODUCT CARD -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition"
                    data-aos="fade-up">
                    <div class="h-56 flex items-center justify-center bg-gray-50">
                        <img src="assets/img/tv1.webp"
                            alt="TV"
                            class="max-h-44 object-contain">
                    </div>

                    <div class="p-6">
                        <div class="text-sm text-primary font-medium mb-1">
                            Samsung • Televisi
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Smart TV 55 Inch UHD
                        </h3>
                        <p class="text-gray-600 text-sm mb-5">
                            Televisi pintar dengan resolusi tinggi dan
                            teknologi modern untuk kebutuhan rumah dan bisnis.
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                Audio Visual
                            </span>
                            <a href="detail-product.php"
                                class="text-primary font-medium text-sm hover:underline">
                                Detail
                                <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- PRODUCT CARD -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="h-56 flex items-center justify-center bg-gray-50">
                        <img src="assets/img/product1.jpg"
                            alt="Product"
                            class="max-h-44 object-contain">
                    </div>

                    <div class="p-6">
                        <div class="text-sm text-primary font-medium mb-1">
                            LG • Monitor
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Monitor Profesional 27”
                        </h3>
                        <p class="text-gray-600 text-sm mb-5">
                            Monitor berkualitas tinggi untuk kebutuhan
                            kerja profesional dan multimedia.
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                Elektronik
                            </span>
                            <a href="#"
                                class="text-primary font-medium text-sm hover:underline">
                                Detail
                                <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- PRODUCT CARD -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="h-56 flex items-center justify-center bg-gray-50">
                        <img src="assets/img/product-3.jpg"
                            alt="Product"
                            class="max-h-44 object-contain">
                    </div>

                    <div class="p-6">
                        <div class="text-sm text-primary font-medium mb-1">
                            Sony • Speaker
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Speaker Aktif Premium
                        </h3>
                        <p class="text-gray-600 text-sm mb-5">
                            Speaker dengan kualitas suara jernih dan
                            desain elegan untuk berbagai kebutuhan.
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                Audio
                            </span>
                            <a href="#"
                                class="text-primary font-medium text-sm hover:underline">
                                Detail
                                <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
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