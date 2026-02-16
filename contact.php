<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Kusuma Trisna Bali</title>

    <link rel="icon" href="admin/favicon.ico">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Icons & Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

    <!-- HERO CONTACT -->
    <section class="relative py-32">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="assets/img/slider7.jpg"
                alt="Contact Kusuma Trisna Bali"
                class="w-full h-full object-cover">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-semibold text-primary mb-6"
                data-aos="fade-up">
                Hubungi Kami
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-white"
                data-aos="fade-up" data-aos-delay="150">
                Kami siap membantu dan menjawab pertanyaan Anda.
                Silakan hubungi kami melalui form atau informasi di bawah ini.
            </p>
        </div>
    </section>
    <!-- CONTACT CONTENT -->
    <section class="py-24">
        <div class="max-w-6xl mx-auto px-6 pb-16">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.491802868451!2d115.1211551!3d-8.5486154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23bbcadf71b29%3A0x47932c18a19d26e4!2sCV.%20Kusuma%20Trisna%20Bali!5e0!3m2!1sid!2sid!4v1770969154441!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-start">

            <!-- CONTACT INFO -->
            <div data-aos="fade-right">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                    Informasi Kontak
                </h2>

                <p class="text-gray-600 mb-8">
                    Jangan ragu untuk menghubungi kami. Tim kami akan merespons
                    secepat mungkin dengan solusi terbaik.
                </p>

                <div class="space-y-6">

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Alamat</h4>
                            <p class="text-gray-600 text-sm">
                                Bali, Indonesia
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Telepon</h4>
                            <p class="text-gray-600 text-sm">
                                +62 812-3456-7890
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Email</h4>
                            <p class="text-gray-600 text-sm">
                                info@kusumatrisnabali.com
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CONTACT FORM -->
            <div data-aos="fade-left">
                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        Kirim Pesan
                    </h3>

                    <form action="#" method="post" class="space-y-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap
                            </label>
                            <input type="text"
                                placeholder="Nama Anda"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email"
                                placeholder="email@contoh.com"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pesan
                            </label>
                            <textarea rows="5"
                                placeholder="Tulis pesan Anda..."
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/30"></textarea>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-darkred transition">
                            Kirim Pesan
                            <i class="fa-solid fa-paper-plane ml-2 text-sm"></i>
                        </button>

                    </form>
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

    <script src="assets/main.js"></script>
</body>

</html>