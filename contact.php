<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hubungi Kami | Kusuma Trisna Bali - Tabanan Bali</title>

    <meta name="description" content="Hubungi Kusuma Trisna Bali di Tabanan untuk info produk elektronik, service, dan penawaran. Telepon/WhatsApp +62 877-7992-8897.">


    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <link rel="canonical" href="https://www.kusumatrisnabali.com/contact.php">

    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">

    <meta name="theme-color" content="#c1121f">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Hubungi Kami | Kusuma Trisna Bali">
    <meta property="og:description" content="Hubungi Kusuma Trisna Bali untuk informasi produk elektronik dan layanan service di Tabanan, Bali.">
    <meta property="og:url" content="https://www.kusumatrisnabali.com/contact.php">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:image" content="https://www.kusumatrisnabali.com/assets/contact-og.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="887">
    <meta property="og:image:alt" content="Hubungi Kusuma Trisna Bali">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Hubungi Kami | Kusuma Trisna Bali">
    <meta name="twitter:description" content="Hubungi Kusuma Trisna Bali untuk informasi produk dan layanan elektronik di Bali.">
    <meta name="twitter:image" content="https://www.kusumatrisnabali.com/assets/contact-og.jpg">

    <?php
    include 'schema-store.php';
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => 'Hubungi Kusuma Trisna Bali',
        'url' => SITE_URL . '/contact.php',
        'description' => 'Halaman kontak resmi Kusuma Trisna Bali.',
        'isPartOf' => ['@id' => SITE_URL . '/#website'],
        'mainEntity' => ['@id' => SITE_URL . '/#store'],
    ]);
    jsonld(breadcrumb_ld([['Beranda', SITE_URL . '/'], ['Kontak', SITE_URL . '/contact.php']]));
    ?>


    <!-- Icons & Library -->
    <script>document.documentElement.classList.add('js');</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime(__DIR__ . '/assets/tailwind.css'); ?>">
</head>
<?php
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$niceName = function ($n) {
    $n = trim((string) $n);
    return strlen($n) <= 3 ? strtoupper($n) : preg_replace('/\bTv\b/', 'TV', ucwords(strtolower($n), " -"));
};
$arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
?>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <?php $hbCurrent = 'kontak'; include 'header-board.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6">

        <section class="pt-6 lg:pt-10">
            <nav aria-label="Breadcrumb" class="t-s text-[var(--soft)] mb-4">
                <a href="/" class="hover:text-[var(--ink)]">Beranda</a> / <span class="text-[var(--ink)]">Kontak</span>
            </nav>
            <h1 class="t-h">Hubungi Kusuma Trisna Bali</h1>
            <p class="t-s mt-4 max-w-xl">Tanya stok, harga, atau jadwal service. Cara tercepat lewat WhatsApp pada jam kerja.</p>
        </section>

        <?php if (isset($_GET['status'])):
            $contactStatus = $_GET['status'];
            $contactMessage = $contactStatus === 'success'
                ? 'Pesan berhasil dikirim. Kami akan segera menghubungi Anda.'
                : ($contactStatus === 'captcha' ? 'Verifikasi anti-spam gagal. Silakan coba lagi.' : 'Pesan tidak dapat dikirim. Silakan coba lagi nanti.'); ?>
            <p role="status" class="mt-6 tile t-s font-semibold <?= $contactStatus === 'success' ? '!bg-[#e6f4ea] text-[#14532d]' : '!bg-[#fde8e8] text-[var(--deep)]' ?>"><?= $e($contactMessage) ?></p>
        <?php endif; ?>

        <!-- Kanal kontak -->
        <section aria-label="Kontak" class="mt-8 board" data-reveal>
            <a href="https://wa.me/6287779928897" target="_blank" rel="noopener" class="tile col-span-2 lg:col-span-6 bg-[var(--accent)] text-white flex flex-col justify-between gap-8 lg:min-h-[220px] lg:!p-8 transition-colors hover:bg-[var(--deep)]">
                <span class="t-l">Chat WhatsApp</span>
                <span class="link-arrow">Sales · 0877-7992-8897 <?= $arrow ?></span>
            </a>
            <a href="tel:+6287779928897" class="tile lg:col-span-2 flex flex-col justify-between gap-6 lg:!p-6 transition-colors hover:bg-[var(--tile-2)]">
                <span class="font-semibold">Sales</span>
                <span class="t-s">0877-7992-8897</span>
            </a>
            <a href="tel:+6281238300513" class="tile lg:col-span-2 flex flex-col justify-between gap-6 bg-[var(--tile-2)] lg:!p-6 transition-colors hover:bg-[#d1d5db]">
                <span class="font-semibold">Service</span>
                <span class="t-s">0812-3830-0513</span>
            </a>
            <a href="mailto:info@kusumatrisnabali.com" class="tile col-span-2 lg:col-span-2 flex flex-col justify-between gap-6 bg-[var(--ink)] text-white lg:!p-6 transition-colors hover:bg-black">
                <span class="font-semibold">Email</span>
                <span class="t-s break-all">info@kusumatrisnabali.com</span>
            </a>
            <a href="https://shopee.co.id/trisnaelectronics" target="_blank" rel="noopener" class="tile col-span-2 lg:col-span-12 flex flex-wrap items-center justify-between gap-3 lg:!px-8 transition-colors hover:bg-[var(--tile-2)]">
                <span class="t-m">Toko Shopee: Trisna Electronics</span>
                <span class="link-arrow">Kunjungi toko <?= $arrow ?></span>
            </a>
        </section>

        <!-- Peta + form -->
        <section class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-24 lg:gap-[var(--gap)]" data-reveal>
            <div class="lg:col-span-6">
                <h2 class="t-h">Lokasi toko</h2>
                <p class="t-s mt-4 max-w-xl">Jl. By Pass Dr. Ir. Soekarno, Banjar Tegal Belodan, Dauh Peken, Tabanan, Bali 82113. Buka Senin–Sabtu, 08.00–17.00.</p>
                <div class="tile tile--photo mt-6 aspect-[4/3]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.491802868451!2d115.1211551!3d-8.5486154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23bbcadf71b29%3A0x47932c18a19d26e4!2sCV.%20Kusuma%20Trisna%20Bali!5e0!3m2!1sid!2sid!4v1770969154441!5m2!1sid!2sid" title="Lokasi Kusuma Trisna Bali di Google Maps" class="w-full h-full border-0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <a href="https://share.google/LNnFVBGg7wU9klqp3" target="_blank" rel="noopener" class="link-arrow mt-4 hover:text-[var(--accent)]">Buka di Google Maps <?= $arrow ?></a>
            </div>

            <div class="lg:col-span-5 lg:col-start-8">
                <h2 class="t-h">Kirim pesan</h2>
                <p class="t-s mt-4">Kami balas lewat email atau telepon pada jam kerja.</p>
                <form action="send-mail.php" method="post" class="mt-6 grid gap-[var(--gap)]">
                    <input type="text" name="company" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                    <div>
                        <label for="c-name" class="t-s font-semibold block mb-2">Nama lengkap</label>
                        <input id="c-name" type="text" name="name" required maxlength="100" autocomplete="name" class="w-full rounded-[var(--r)] bg-[var(--tile)] px-4 py-3.5 text-[var(--ink)] placeholder:text-[var(--soft)] focus:bg-[var(--tile-2)] focus:outline-none">
                    </div>
                    <div>
                        <label for="c-email" class="t-s font-semibold block mb-2">Email</label>
                        <input id="c-email" type="email" name="email" required maxlength="190" autocomplete="email" class="w-full rounded-[var(--r)] bg-[var(--tile)] px-4 py-3.5 text-[var(--ink)] placeholder:text-[var(--soft)] focus:bg-[var(--tile-2)] focus:outline-none">
                    </div>
                    <div>
                        <label for="c-phone" class="t-s font-semibold block mb-2">Nomor telepon / WhatsApp</label>
                        <input id="c-phone" type="tel" name="phone" required maxlength="30" autocomplete="tel" class="w-full rounded-[var(--r)] bg-[var(--tile)] px-4 py-3.5 text-[var(--ink)] placeholder:text-[var(--soft)] focus:bg-[var(--tile-2)] focus:outline-none">
                    </div>
                    <div>
                        <label for="c-msg" class="t-s font-semibold block mb-2">Pesan</label>
                        <textarea id="c-msg" name="message" rows="5" required maxlength="5000" class="w-full rounded-[var(--r)] bg-[var(--tile)] px-4 py-3.5 text-[var(--ink)] placeholder:text-[var(--soft)] focus:bg-[var(--tile-2)] focus:outline-none"></textarea>
                    </div>
                    <input type="hidden" name="recaptcha_token" id="recaptchaToken">
                    <button type="submit" class="btn mt-2 disabled:opacity-60">Kirim pesan <?= $arrow ?></button>
                </form>
            </div>
        </section>

        <div class="h-24 lg:h-32"></div>
    </main>

    <?php include 'footer-board.php'; ?>

    <script src="assets/main.js?v=<?= filemtime(__DIR__ . '/assets/main.js'); ?>"></script>

    <script>
        const contactForm = document.querySelector('form[action="send-mail.php"]');
        const recaptchaSiteKey = '6LdPkaYtAAAAAJDQYb3MtPpTl8m5pO98k1ZMLQAc';

        function loadRecaptcha() {
            if (window.grecaptcha) {
                return Promise.resolve(window.grecaptcha);
            }

            return new Promise(function(resolve, reject) {
                const script = document.createElement('script');
                script.src = 'https://www.google.com/recaptcha/api.js?render=' + recaptchaSiteKey;
                script.onload = function() {
                    resolve(window.grecaptcha);
                };
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }

        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            loadRecaptcha()
                .then(function(recaptcha) {
                    recaptcha.ready(function() {
                        recaptcha.execute(recaptchaSiteKey, {
                                action: 'contact'
                            })
                            .then(function(token) {
                                document.getElementById('recaptchaToken').value = token;
                                form.submit();
                            })
                            .catch(function() {
                                submitButton.disabled = false;
                                window.location.href = 'contact.php?status=captcha';
                            });
                    });
                })
                .catch(function() {
                    submitButton.disabled = false;
                    window.location.href = 'contact.php?status=captcha';
                });
        });
    </script>
</body>

</html>
