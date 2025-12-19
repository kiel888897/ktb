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
                Hubungi
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
                        src="https://images.unsplash.com/photo-1581090700227-1e37b190418e"
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


    <!-- PRODUK TERBARU -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10" data-aos="fade-up">
                Produk Terbaru
            </h2>

            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-xl shadow" data-aos="zoom-in">
                    <img src="https://via.placeholder.com/300" class="rounded mb-3">
                    <h3 class="font-semibold">Produk A</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- IKLAN / PROMO -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center gap-10">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold mb-4">
                    Promo Service Resmi
                </h2>
                <p>Dapatkan layanan terbaik dari teknisi bersertifikat.</p>
            </div>
            <img src="https://via.placeholder.com/500" data-aos="fade-up">
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
        const header = document.getElementById('mainHeader');
        const desktopNav = document.getElementById('desktopNav');
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
                desktopCTA.classList.remove('border-white', 'text-white');
                desktopCTA.classList.add('bg-primary', 'text-white');
                openBtn.classList.remove('text-white');
                openBtn.classList.add('text-gray-900');
            } else {
                header.classList.add('bg-transparent');
                header.classList.remove('bg-white', 'shadow');
                desktopNav.classList.add('text-white');
                desktopNav.classList.remove('text-gray-900');
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