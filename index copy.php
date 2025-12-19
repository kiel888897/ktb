<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kusuma Trisna Bali</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0f766e', // bisa diganti warna brand KTB
                        secondary: '#facc15'
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans text-gray-800">

    <!-- HEADER -->
    <header class="bg-white shadow-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <h1 class="text-xl font-bold text-primary">Kusuma Trisna Bali</h1>
            <nav class="hidden md:flex space-x-6 font-medium">
                <a href="#" class="hover:text-primary">Home</a>
                <a href="#" class="hover:text-primary">About Us</a>
                <a href="#" class="hover:text-primary">Produk & Brand</a>
                <a href="#" class="hover:text-primary">Service</a>
                <a href="#" class="hover:text-primary">Kontak</a>
            </nav>
            <a href="#contact" class="hidden md:inline-block bg-primary text-white px-5 py-2 rounded-lg hover:bg-teal-700">
                Hubungi Kami
            </a>
        </div>
    </header>

    <!-- HERO -->
    <section class="pt-28 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    Authorized Service & Produk Berkualitas
                </h2>
                <p class="text-gray-600 mb-6">
                    Kusuma Trisna Bali adalah mitra terpercaya untuk produk dan layanan
                    resmi dengan standar profesional.
                </p>
                <div class="flex gap-4">
                    <a href="#services" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-teal-700">
                        Layanan Kami
                    </a>
                    <a href="#products" class="border border-primary text-primary px-6 py-3 rounded-lg hover:bg-primary hover:text-white">
                        Produk & Brand
                    </a>
                </div>
            </div>

            <div>
                <img src="https://images.unsplash.com/photo-1581090700227-1e37b190418e"
                    alt="Service"
                    class="rounded-xl shadow-lg">
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="p-6 shadow rounded-xl">
                    <i class="fa-solid fa-certificate text-4xl text-primary mb-4"></i>
                    <h3 class="font-semibold text-lg">Authorized Service</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Layanan resmi dengan standar pabrikan.
                    </p>
                </div>

                <div class="p-6 shadow rounded-xl">
                    <i class="fa-solid fa-users-gear text-4xl text-primary mb-4"></i>
                    <h3 class="font-semibold text-lg">Teknisi Profesional</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Ditangani oleh teknisi berpengalaman.
                    </p>
                </div>

                <div class="p-6 shadow rounded-xl">
                    <i class="fa-solid fa-handshake text-4xl text-primary mb-4"></i>
                    <h3 class="font-semibold text-lg">Partner Terpercaya</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        Dipercaya berbagai brand ternama.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-primary text-white py-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">
                Butuh Layanan Resmi & Cepat?
            </h2>
            <p class="mb-6">
                Hubungi kami sekarang untuk permintaan layanan atau informasi produk.
            </p>
            <a href="#contact" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Hubungi Sekarang
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300 py-10">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="mb-2 font-semibold">Kusuma Trisna Bali</p>
            <p class="text-sm">© 2025 All Rights Reserved</p>
        </div>
    </footer>

</body>

</html>