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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <?php include __DIR__ . '/header-board.php'; ?>
    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 pt-4 lg:pt-6 pb-24 lg:pb-32">
        <section class="board">
            <div class="tile col-span-2 lg:col-span-8 lg:row-span-2 bg-[var(--ink)] text-white flex flex-col justify-between gap-10 lg:min-h-[420px] lg:!p-10">
                <p class="t-display">404</p>
                <div>
                    <h1 class="t-h">Halaman tidak ditemukan</h1>
                    <p class="t-s mt-4 max-w-lg">Halaman atau produk yang Anda cari tidak tersedia atau sudah dipindahkan.</p>
                </div>
            </div>
            <a href="products.php" class="tile lg:col-span-4 bg-[var(--accent)] text-white flex flex-col justify-between gap-6 transition-colors hover:bg-[var(--deep)] lg:!p-8">
                <span class="t-m">Lihat katalog produk</span>
                <span class="font-semibold">Produk &rarr;</span>
            </a>
            <a href="/" class="tile lg:col-start-9 lg:col-span-4 flex flex-col justify-between gap-6 transition-colors hover:bg-[var(--tile-2)] lg:!p-8">
                <span class="t-m">Kembali ke beranda</span>
                <span class="font-semibold">Beranda &rarr;</span>
            </a>
        </section>
    </main>
    <?php include __DIR__ . '/footer-board.php'; ?>
    <script src="assets/main.js"></script>
</body>

</html>
