<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <?php include __DIR__ . '/tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title>Halaman Tidak Ditemukan | Kusuma Trisna Bali</title>
    <meta name="robots" content="noindex, follow">
    <link rel="icon" href="/assets/favicon.ico">
    <meta name="theme-color" content="#c1121f">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>

<body class="text-gray-800 bg-gray-50">
    <?php include __DIR__ . '/header.php'; ?>
    <main>
        <section class="bg-gray-900 pt-40 pb-24 text-center text-white">
            <div class="max-w-3xl mx-auto px-6">
                <p class="text-primary font-semibold tracking-widest mb-3">404</p>
                <h1 class="text-4xl md:text-5xl font-semibold mb-6">Halaman tidak ditemukan</h1>
                <p class="text-gray-300 mb-10">
                    Halaman atau produk yang Anda cari tidak tersedia atau sudah dipindahkan.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="products.php" class="px-6 py-3 bg-primary rounded-lg font-medium hover:bg-darkred transition">Lihat Produk</a>
                    <a href="/" class="px-6 py-3 border border-white rounded-lg font-medium hover:bg-white hover:text-gray-900 transition">Ke Beranda</a>
                </div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/footer.php'; ?>
    <script src="assets/main.js"></script>
</body>

</html>
