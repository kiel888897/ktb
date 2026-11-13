<?php
require 'admin/config/database.php';
require_once __DIR__ . '/image-helper.php';

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

// Merek service center resmi + FAQ (dipakai di tampilan dan schema FAQPage)
$partners = $pdo->query("SELECT name, logo FROM partners WHERE is_active = 1 ORDER BY sort_order ASC, id DESC")->fetchAll(PDO::FETCH_ASSOC);
$niceName = function ($n) {
    $n = trim((string) $n);
    return strlen($n) <= 3 ? strtoupper($n) : preg_replace('/\bTv\b/', 'TV', ucwords(strtolower($n), " -"));
};
$partnerNames = array_map(fn($p) => $niceName($p['name']), $partners);
$partnerList = count($partnerNames) > 1
    ? implode(', ', array_slice($partnerNames, 0, -1)) . ' dan ' . end($partnerNames)
    : implode('', $partnerNames);

$faqs = [
    ['Elektronik apa saja yang bisa diservis di Kusuma Trisna Bali?',
        'Kami menangani service dan perbaikan TV, mesin cuci, kulkas, audio, dan perangkat elektronik lain di Tabanan, Bali.'],
];
if ($partnerList !== '') {
    $faqs[] = ['Kusuma Trisna Bali service center resmi untuk merek apa saja?',
        'Kami service center resmi untuk ' . $partnerList . '.'];
}
$faqs = array_merge($faqs, [
    ['Bagaimana cara mengajukan service elektronik?',
        'Hubungi bagian service di 0812-3830-0513 atau chat WhatsApp 0877-7992-8897. Tim kami mencatat kontak Anda dan produk yang akan diservice, lalu datang ke lokasi Anda. Anda juga bisa membawa barang langsung ke toko.'],
    ['Apakah penjemputan service gratis dan sampai mana wilayahnya?',
        'Penjemputan gratis dan melayani seluruh Bali, tanpa batas wilayah. Tim kami tidak langsung datang saat Anda menghubungi, karena kunjungan perlu dijadwalkan.'],
    ['Bagaimana service untuk barang yang masih garansi?',
        'Tim kami mengecek kerusakan di lokasi. Jika masih masuk garansi, barang kami bawa ke kantor, suku cadang diajukan ke merek terkait, lalu diganti.'],
    ['Bagaimana service untuk barang yang tidak bergaransi?',
        'Tim kami menyampaikan biaya perbaikan saat pengecekan di lokasi. Jika cocok, barang kami bawa dan perbaiki. Jika tidak cocok, barang tidak kami bawa dan tidak ada biaya.'],
    ['Apakah hasil perbaikan barang tidak bergaransi mendapat garansi?',
        'Tergantung kebijakan dari merek terkait.'],
    ['Berapa lama proses service?',
        'Lamanya tidak bisa ditentukan di awal, karena tergantung pengiriman suku cadang. Progresnya bisa Anda pantau dengan kode service.'],
    ['Bagaimana cara mengecek status service?',
        'Masukkan kode service Anda, misalnya SRV-20260216-001, pada kolom Lacak status service di halaman ini. Kode didapat setelah barang masuk ke kantor kami.'],
    ['Apa saja tahapan status service?',
        'Barang diterima, pemeriksaan, dikerjakan, menunggu suku cadang, menunggu persetujuan Anda, lalu selesai. Dua status menunggu hanya muncul bila diperlukan.'],
    ['Di mana lokasi service center dan kapan buka?',
        'Jl. By Pass Dr. Ir. Soekarno, Banjar Tegal Belodan, Dauh Peken, Tabanan, Bali 82113. Buka Senin sampai Sabtu, pukul 08.00 sampai 17.00 WITA.'],
]);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Service Elektronik &amp; Hisense di Tabanan Bali | Kusuma Trisna Bali</title>

    <meta name="description" content="Service TV, mesin cuci, kulkas, audio, dan elektronik lain di Tabanan, Bali oleh teknisi berpengalaman. Cek status service dengan kode service Anda.">


    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <link rel="canonical" href="https://www.kusumatrisnabali.com/services.php">

    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">

    <meta name="theme-color" content="#c1121f">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Layanan Service Elektronik | Kusuma Trisna Bali">
    <meta property="og:description" content="Layanan service dan perbaikan berbagai produk elektronik dengan teknisi profesional di Tabanan, Bali.">
    <meta property="og:url" content="https://www.kusumatrisnabali.com/services.php">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:image" content="https://www.kusumatrisnabali.com/assets/services-og.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="674">
    <meta property="og:image:alt" content="Layanan Service Elektronik Kusuma Trisna Bali">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Layanan Service Elektronik | Kusuma Trisna Bali">
    <meta name="twitter:description" content="Service dan perbaikan berbagai perangkat elektronik dengan dukungan teknisi profesional di Bali.">
    <meta name="twitter:image" content="https://www.kusumatrisnabali.com/assets/services-og.jpg">

    <?php
    include 'schema-store.php';
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => 'Service dan Perbaikan Elektronik',
        'serviceType' => 'Perbaikan dan service produk elektronik',
        'description' => 'Layanan service dan perbaikan TV, mesin cuci, kulkas, audio, dan perangkat elektronik lain oleh teknisi berpengalaman di Tabanan, Bali.',
        'url' => SITE_URL . '/services.php',
        'provider' => ['@id' => SITE_URL . '/#store'],
        'areaServed' => ['@type' => 'AdministrativeArea', 'name' => 'Bali'],
    ]);
    jsonld(breadcrumb_ld([['Beranda', SITE_URL . '/'], ['Layanan Service', SITE_URL . '/services.php']]));
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type' => 'Question',
            'name' => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ]);
    ?>

    <script>document.documentElement.classList.add('js');</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'"><noscript><link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>
<?php
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
$steps = ['barang diterima', 'checking/diagnose', 'on progress', 'pending part', 'pending customer', 'done'];
$stepLabel = [
    'barang diterima' => 'Barang diterima',
    'checking/diagnose' => 'Pemeriksaan',
    'on progress' => 'Dikerjakan',
    'pending part' => 'Menunggu suku cadang',
    'pending customer' => 'Menunggu persetujuan Anda',
    'done' => 'Selesai',
    'cancel' => 'Dibatalkan',
];
$waUrl = 'https://wa.me/6287779928897?text=' . rawurlencode('Halo Kusuma Trisna Bali, saya ingin mengajukan service untuk: ');
?>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <?php $hbCurrent = 'service'; include 'header-board.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6">

        <!-- Pembuka + lacak -->
        <section class="pt-4 lg:pt-6 board lg:[grid-auto-rows:minmax(96px,auto)]">
            <div class="tile col-span-2 lg:col-span-7 lg:row-span-3 flex flex-col justify-between gap-8 lg:!p-10">
                <div>
                    <nav aria-label="Breadcrumb" class="t-s text-[var(--soft)] mb-4">
                        <a href="/" class="hover:text-[var(--ink)]">Beranda</a> / <span class="text-[var(--ink)]">Service</span>
                    </nav>
                    <h1 class="t-h">Service elektronik di Tabanan</h1>
                    <p class="t-s mt-4 max-w-xl">Penjemputan gratis di seluruh Bali, atau bawa langsung ke toko. Setelah barang masuk ke kantor kami, progresnya bisa Anda pantau lewat kode service.</p>
                </div>

                <div id="track-service" class="scroll-mt-24">
                    <h2 class="t-m">Lacak status service</h2>
                    <form method="POST" action="#track-service" class="mt-4 flex flex-col sm:flex-row gap-[var(--gap)]">
                        <label for="kode-service" class="sr-only">Kode service</label>
                        <input id="kode-service" type="text" name="service_code" required autocomplete="off"
                            value="<?= $e($_POST['service_code'] ?? '') ?>"
                            placeholder="Kode service, mis. SRV-20260216-001"
                            class="w-full sm:w-auto sm:flex-1 min-w-0 h-[56px] shrink-0 rounded-[var(--r)] bg-[var(--ground)] px-5 text-[var(--ink)] placeholder:text-[var(--soft)] focus:outline-none focus:ring-2 focus:ring-[var(--ink)]">
                        <button type="submit" class="btn h-[56px]">Cek status <?= $arrow ?></button>
                    </form>
                    <?php if ($error): ?>
                        <p class="mt-3 t-s font-semibold text-[var(--accent)]" role="alert"><?= $e($error) ?> Periksa lagi kodenya atau tanyakan lewat WhatsApp.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="tile tile--photo col-span-2 lg:col-span-5 lg:row-span-3 aspect-[4/3] lg:aspect-auto">
                <img src="assets/img/promo1.webp" width="1384" height="1040" fetchpriority="high" alt="Teknisi memeriksa TV di service center Kusuma Trisna Bali">
            </div>
        </section>

        <!-- Hasil lacak -->
        <?php if ($result):
            $status = $result['status'] ?? '';
            $currentIndex = array_search($status, $steps, true); ?>
            <section aria-label="Status service" class="mt-[var(--gap)] tile bg-[var(--ink)] text-white lg:!p-10">
                <div class="grid lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-4">
                        <p class="t-s text-white/70">Status saat ini</p>
                        <p class="t-h mt-1"><?= $e($stepLabel[$status] ?? ucfirst($status)) ?></p>
                        <p class="t-s text-white/70 mt-3">Diperbarui <?= $e(date('d M Y', strtotime($result['updated_at']))) ?></p>
                    </div>
                    <dl class="lg:col-span-8 grid grid-cols-2 sm:grid-cols-3 gap-[var(--gap)] t-s">
                        <div class="rounded-[var(--r)] bg-white/10 p-4"><dt class="text-white/70">Pelanggan</dt><dd class="font-semibold"><?= $e($result['customer_name']) ?></dd></div>
                        <div class="rounded-[var(--r)] bg-white/10 p-4"><dt class="text-white/70">Produk</dt><dd class="font-semibold"><?= $e($result['product_name']) ?></dd></div>
                        <div class="rounded-[var(--r)] bg-white/10 p-4"><dt class="text-white/70">Masuk</dt><dd class="font-semibold"><?= $e(date('d M Y', strtotime($result['created_at']))) ?></dd></div>
                    </dl>
                </div>
                <?php if ($status !== 'cancel'): ?>
                    <ol class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-[var(--gap)] t-s">
                        <?php foreach ($steps as $i => $st):
                            $done = $currentIndex !== false && $i <= $currentIndex;
                            $now = $currentIndex !== false && $i === $currentIndex; ?>
                            <li class="rounded-[var(--r)] p-4 <?= $now ? 'bg-[var(--accent)]' : ($done ? 'bg-white/25' : 'bg-white/5 text-white/60') ?>" <?= $now ? 'aria-current="step"' : '' ?>>
                                <?= $e($stepLabel[$st]) ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <!-- Yang kami kerjakan -->
        <section class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-[var(--gap)]" data-reveal>
            <h2 class="t-h lg:col-span-4 lg:pr-8 mb-6 lg:mb-0">Yang kami kerjakan</h2>
            <div class="tile lg:col-span-4 lg:!p-8">
                <h3 class="t-m">Service &amp; perbaikan</h3>
                <p class="t-s mt-3">Perbaikan produk elektronik dengan proses kerja yang rapi dan pengecekan sebelum digunakan kembali.</p>
            </div>
            <div class="tile lg:col-span-4 bg-[var(--tile-2)] lg:!p-8">
                <h3 class="t-m">Konsultasi produk</h3>
                <p class="t-s mt-3">Informasi dan arahan soal penggunaan, perawatan, dan penanganan produk elektronik.</p>
            </div>
            <div class="tile lg:col-start-5 lg:col-span-8 bg-[var(--deep)] text-white lg:!p-8">
                <h3 class="t-m">Dukungan teknis</h3>
                <p class="t-s mt-3 max-w-2xl">Membantu menangani kendala teknis agar produk kembali berfungsi dengan baik.</p>
            </div>
        </section>

        <!-- Alur -->
        <section class="mt-24 lg:mt-32">
            <h2 class="t-h">Alur service</h2>
            <p class="t-s mt-4 max-w-xl">Penjemputan gratis, tanpa batas wilayah di seluruh Bali. Kunjungan dijadwalkan, jadi tim tidak langsung datang saat Anda menghubungi.</p>
            <div class="mt-10 grid lg:grid-cols-12 gap-[var(--gap)] gap-y-10 items-end" data-reveal>
                <figure class="lg:col-span-3">
                    <div class="tile tile--photo h-[46vw] lg:h-[260px]"><img src="assets/img/slider7.webp" width="1536" height="864" loading="lazy" class="object-[88%_40%]" alt="Staf Kusuma Trisna Bali mencatat data pelanggan"></div>
                    <figcaption class="mt-4">
                        <p class="t-m">Anda menghubungi kami</p>
                        <p class="t-s text-[var(--soft)] mt-1">Tim kami mencatat kontak Anda dan produk yang akan diservice.</p>
                    </figcaption>
                </figure>
                <figure class="lg:col-span-4">
                    <div class="tile tile--photo h-[58vw] lg:h-[380px]"><img src="assets/img/slider1.webp" width="1600" height="896" loading="lazy" class="object-[40%_50%]" alt="Tim service mengecek TV di rumah pelanggan"></div>
                    <figcaption class="mt-4">
                        <p class="t-m">Dicek di lokasi</p>
                        <p class="t-s text-[var(--soft)] mt-1">Tim datang ke lokasi Anda dan mengecek jenis kerusakannya.</p>
                    </figcaption>
                </figure>
                <figure class="lg:col-span-5">
                    <div class="tile tile--photo h-[70vw] lg:h-[500px]"><img src="assets/img/h4.webp" width="1600" height="896" loading="lazy" alt="Barang service masuk ke kantor Kusuma Trisna Bali"></div>
                    <figcaption class="mt-4">
                        <p class="t-m">Masuk ke kantor</p>
                        <p class="t-s text-[var(--soft)] mt-1">Anda mendapat kode service. Lama pengerjaan tergantung pengiriman suku cadang.</p>
                    </figcaption>
                </figure>
            </div>

            <div class="mt-10 grid lg:grid-cols-2 gap-[var(--gap)]" data-reveal>
                <div class="tile bg-[var(--ink)] text-white lg:!p-8">
                    <h3 class="t-l">Masih garansi</h3>
                    <p class="t-s mt-3 max-w-lg">Barang kami bawa ke kantor, suku cadang diajukan ke merek terkait, lalu diganti.</p>
                </div>
                <div class="tile bg-[var(--deep)] text-white lg:!p-8">
                    <h3 class="t-l">Tidak bergaransi</h3>
                    <p class="t-s mt-3 max-w-lg">Biaya perbaikan kami sampaikan saat pengecekan. Jika cocok, barang kami bawa dan perbaiki. Jika tidak cocok, barang tidak kami bawa dan tidak ada biaya.</p>
                </div>
            </div>

            <p class="t-s mt-6">Lebih suka datang sendiri? Anda juga bisa <a href="contact.php" class="underline underline-offset-4 hover:text-[var(--accent)]">membawa barang langsung ke toko</a>.</p>
        </section>

        <?php if ($partners): ?>
            <section class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-[var(--gap)] items-center" data-reveal>
                <h2 class="t-m lg:col-span-3 mb-4 lg:mb-0">Service center resmi untuk</h2>
                <ul class="lg:col-span-9 grid grid-cols-3 sm:grid-cols-6 gap-[var(--gap)]">
                    <?php foreach ($partners as $partner): ?>
                        <li class="tile !p-3 flex items-center justify-center aspect-[3/2]">
                            <img src="<?= $e(thumb_src('admin/uploads/partners/' . $partner['logo'], 240)) ?>" alt="<?= $e($niceName($partner['name'])) ?>" loading="lazy" decoding="async" class="blend max-h-full max-w-full object-contain">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <!-- FAQ -->
        <section id="faq" class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-[var(--gap)] gap-y-6 scroll-mt-24">
            <h2 class="t-h lg:col-span-4 lg:pr-8">Tanya jawab service</h2>
            <div class="lg:col-span-8 space-y-[var(--gap)]">
                <?php foreach ($faqs as $i => $f): ?>
                    <details class="bar" <?= $i === 0 ? 'open' : '' ?>>
                        <summary class="!py-3">
                            <span class="font-semibold"><?= $e($f[0]) ?></span>
                            <svg class="plus shrink-0" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                        </summary>
                        <p class="t-s px-[18px] pb-5 max-w-2xl"><?= $e($f[1]) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Ajakan -->
        <section class="mt-24 lg:mt-32 mb-24 lg:mb-32 grid lg:grid-cols-12 gap-[var(--gap)]">
            <div class="tile lg:col-span-8 bg-[var(--ink)] text-white flex flex-col justify-between gap-8 lg:min-h-[260px] lg:!p-10">
                <h2 class="t-h">Ajukan service</h2>
                <p class="t-s max-w-lg">Ceritakan merek, jenis barang, dan kendalanya. Kami balas pada jam kerja, Senin–Sabtu 08.00–17.00.</p>
            </div>
            <a href="<?= $e($waUrl) ?>" target="_blank" rel="noopener" class="tile lg:col-span-4 bg-[var(--accent)] text-white flex flex-col justify-between gap-6 transition-colors hover:bg-[var(--deep)] lg:!p-10">
                <span class="t-m">Chat WhatsApp</span>
                <span class="link-arrow">0877-7992-8897 <?= $arrow ?></span>
            </a>
        </section>
    </main>

    <?php include 'footer-board.php'; ?>

    <script src="assets/main.js?v=<?= filemtime(__DIR__ . '/assets/main.js'); ?>"></script>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <script>
            window.addEventListener("load", function() {
                var el = document.getElementById("track-service");
                if (el) el.scrollIntoView();
            });
        </script>
    <?php endif; ?>
</body>

</html>
