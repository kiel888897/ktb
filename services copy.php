<?php
require 'admin/config/database.php';

$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_code'])) {

    $service_code = trim($_POST['service_code']);

    $stmt = $pdo->prepare("SELECT * FROM services WHERE service_code = ?");
    $stmt->execute([$service_code]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        $error = "Kode service tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Kami | Kusuma Trisna Bali</title>

    <link rel="icon" href="admin/favicon.ico">
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

    <!-- HERO SERVICE -->
    <section class="relative py-32">
        <div class="absolute inset-0">
            <img src="assets/img/slider1.jpg"
                alt="Layanan Kusuma Trisna Bali"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-semibold text-primary mb-6"
                data-aos="fade-up">
                Layanan Kami
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-white"
                data-aos="fade-up" data-aos-delay="150">
                Layanan perbaikan dan penanganan produk elektronik
                yang disesuaikan dengan kebutuhan pelanggan.
            </p>
        </div>
    </section>
    <!-- TRACK SERVICE -->
    <section class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-6 text-center">

            <h2 class="text-3xl font-semibold text-gray-900 mb-4">
                Lacak Status Service
            </h2>
            <p class="text-gray-600 mb-8">
                Masukkan kode service Anda untuk mengetahui progres terbaru.
            </p>

            <!-- Form -->
            <form method="POST" class="flex flex-col sm:flex-row gap-4 justify-center">
                <input type="text" name="service_code" required
                    placeholder="Contoh: SRV-20260216-001"
                    class="flex-1 rounded-lg border border-gray-300 px-4 py-3
                       focus:ring-2 focus:ring-primary focus:outline-none">

                <button type="submit"
                    class="bg-primary text-white px-6 py-3 rounded-lg
                       hover:bg-darkred transition">
                    Cek Status
                </button>
            </form>

            <!-- RESULT -->
            <?php if ($result): ?>
                <div class="mt-10 p-6 rounded-xl border border-gray-200 bg-gray-50 text-left">

                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Detail Service
                    </h3>

                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong>Nama Customer:</strong> <?= htmlspecialchars($result['customer_name']); ?></p>
                        <p><strong>Produk:</strong> <?= htmlspecialchars($result['product_name']); ?></p>
                        <p><strong>Status:</strong>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        <?=
                        match ($result['status']) {
                            'done' => 'bg-green-100 text-green-700',
                            'cancel' => 'bg-red-100 text-red-700',
                            'on progress' => 'bg-yellow-100 text-yellow-700',
                            'pending part' => 'bg-orange-100 text-orange-700',
                            'pending customer' => 'bg-purple-100 text-purple-700',
                            default => 'bg-gray-100 text-gray-700'
                        };
                        ?>">
                                <?= ucfirst($result['status']); ?>
                            </span>
                        </p>
                        <p><strong>Tanggal Masuk:</strong>
                            <?= date('d M Y', strtotime($result['created_at'])); ?>
                        </p>
                        <p><strong>Update Terakhir:</strong>
                            <?= date('d M Y', strtotime($result['updated_at'])); ?>
                        </p>
                    </div>

                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="mt-8 text-red-600 font-medium">
                    <?= $error; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- SERVICE LIST -->
    <section class="py-24">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">
                <h2 class="text-3xl font-semibold text-gray-900 mb-4"
                    data-aos="fade-up">
                    Apa yang Kami Tawarkan
                </h2>
                <p class="text-gray-600"
                    data-aos="fade-up" data-aos-delay="100">
                    Layanan yang kami sediakan untuk mendukung produk dan pelanggan
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">

                <!-- Service Item -->
                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm hover:shadow-md transition"
                    data-aos="fade-up">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-6">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                        Konsultasi Produk
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Memberikan informasi dan arahan terkait penggunaan,
                        perawatan, dan penanganan produk elektronik.
                    </p>
                </div>

                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm hover:shadow-md transition"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-6">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                        Service & Perbaikan
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Menangani perbaikan produk elektronik dengan proses kerja
                        yang rapi dan pengecekan sebelum digunakan kembali.
                    </p>
                </div>

                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm hover:shadow-md transition"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-6">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                        Dukungan Teknis
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Membantu penanganan kendala teknis agar produk
                        dapat berfungsi dengan baik.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SERVICE PROCESS -->
    <section class="bg-gray-50 py-24">
        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">
                <h2 class="text-3xl font-semibold text-gray-900 mb-4"
                    data-aos="fade-up">
                    Alur Layanan
                </h2>
                <p class="text-gray-600"
                    data-aos="fade-up" data-aos-delay="100">
                    Proses kerja yang jelas dan transparan
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-10">

                <div class="text-center" data-aos="fade-up">
                    <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white font-semibold mb-5">
                        1
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Konsultasi</h4>
                    <p class="text-sm text-gray-600">
                        Diskusi awal untuk memahami kebutuhan.
                    </p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white font-semibold mb-5">
                        2
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Perencanaan</h4>
                    <p class="text-sm text-gray-600">
                        Menyusun strategi dan solusi.
                    </p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white font-semibold mb-5">
                        3
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Implementasi</h4>
                    <p class="text-sm text-gray-600">
                        Pelaksanaan layanan secara profesional.
                    </p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 mx-auto flex items-center justify-center rounded-full bg-primary text-white font-semibold mb-5">
                        4
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Evaluasi</h4>
                    <p class="text-sm text-gray-600">
                        Monitoring dan peningkatan berkelanjutan.
                    </p>
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