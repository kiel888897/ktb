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

    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">

            <!-- Filter Bar -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-12"
                data-aos="fade-up">

                <!-- Search -->
                <div class="relative w-full md:w-1/3">
                    <input type="text"
                        placeholder="Cari produk..."
                        class="w-full border border-gray-200 rounded-lg px-4 py-3 pl-11 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/30">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Category Filter -->
                <div class="flex flex-wrap gap-3">
                    <button class="px-5 py-2 rounded-full bg-primary text-white text-sm">
                        Semua
                    </button>
                    <button class="px-5 py-2 rounded-full bg-gray-100 text-gray-700 text-sm hover:bg-gray-200">
                        Produk A
                    </button>
                    <button class="px-5 py-2 rounded-full bg-gray-100 text-gray-700 text-sm hover:bg-gray-200">
                        Produk B
                    </button>
                    <button class="px-5 py-2 rounded-full bg-gray-100 text-gray-700 text-sm hover:bg-gray-200">
                        Produk C
                    </button>
                </div>

            </div>

            <!-- Product Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

                <!-- Card -->
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition"
                    data-aos="fade-up">
                    <img src="assets/img/tv1.webp"
                        alt="Product 1"
                        class="w-full h-56 object-contain">

                    <div class="p-6">
                        <span class="text-sm text-primary font-medium">
                            Produk A
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 mt-2 mb-3">
                            Nama Produk Satu
                        </h3>
                        <p class="text-gray-600 text-sm mb-5">
                            Deskripsi singkat produk yang menjelaskan
                            manfaat utama secara ringkas.
                        </p>

                        <a href="#"
                            class="inline-flex items-center text-primary font-medium text-sm hover:underline">
                            Lihat Detail
                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Card -->
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition"
                    data-aos="fade-up" data-aos-delay="100">
                    <img src="assets/img/product1.jpg"
                        alt="Product 2"
                        class="w-full h-56 object-contain">

                    <div class="p-6">
                        <span class="text-sm text-primary font-medium">
                            Produk B
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 mt-2 mb-3">
                            Nama Produk Dua
                        </h3>
                        <p class="text-gray-600 text-sm mb-5">
                            Produk dengan kualitas terbaik untuk
                            mendukung kebutuhan pelanggan.
                        </p>

                        <a href="#"
                            class="inline-flex items-center text-primary font-medium text-sm hover:underline">
                            Lihat Detail
                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Card -->
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition"
                    data-aos="fade-up" data-aos-delay="200">
                    <img src="assets/img/product-3.jpg"
                        alt="Product 3"
                        class="w-full h-56 object-contain">

                    <div class="p-6">
                        <span class="text-sm text-primary font-medium">
                            Produk C
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 mt-2 mb-3">
                            Nama Produk Tiga
                        </h3>
                        <p class="text-gray-600 text-sm mb-5">
                            Solusi yang dirancang untuk memberikan
                            hasil maksimal secara efisien.
                        </p>

                        <a href="#"
                            class="inline-flex items-center text-primary font-medium text-sm hover:underline">
                            Lihat Detail
                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
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