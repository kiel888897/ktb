<?php
$root = dirname(__DIR__);
require $root . '/admin/config/database.php';
require_once $root . '/image-helper.php';

$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
$arrow = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';

$partners = $pdo->query("SELECT name, logo FROM partners WHERE is_active = 1 ORDER BY sort_order ASC, id DESC")->fetchAll(PDO::FETCH_ASSOC);
$partnerNames = array_map(fn($p) => nice_brand($p['name']), $partners);
$partnerList = count($partnerNames) > 1
    ? implode(', ', array_slice($partnerNames, 0, -1)) . ' and ' . end($partnerNames)
    : implode('', $partnerNames);

$brandCount = (int) $pdo->query("SELECT COUNT(*) FROM brands")->fetchColumn();

$waBase = 'https://wa.me/6287779928897?text=';
$waService = $waBase . rawurlencode('Hello Kusuma Trisna Bali, I would like to arrange an electronics service for my property. Location: ');
$waSupply = $waBase . rawurlencode('Hello Kusuma Trisna Bali, I am looking for electronics for my property. Items needed: ');

$title = 'Electronics Service for Villas & Hotels in Bali | Kusuma Trisna Bali';
$desc = 'Authorized electronics service and supply for villas and hotels in Bali. Free pickup across Bali, on-site checks, and no charge if you decline the repair cost.';
$url = 'https://www.kusumatrisnabali.com/en/';

$faqs = [
    ['Do you serve villas and hotels outside Tabanan?',
        'Yes. Pickup is free and covers all of Bali. Visits are scheduled, so our team does not arrive at the same moment you contact us.'],
    ['Which brands are you an authorized service center for?',
        'We are an authorized service center for ' . $partnerList . '.'],
    ['What happens if the item is still under warranty?',
        'Our team checks the fault on site. If it is covered, we take the item to our office, request the spare part from the brand, and replace it.'],
    ['What if the item is out of warranty?',
        'We tell you the repair cost during the check. If you agree, we take the item and repair it. If you decline, we leave it with you and there is no charge.'],
    ['How long does a repair take?',
        'We cannot give a fixed time in advance, because it depends on spare part delivery. Once the item reaches our office you receive a service code to follow its progress.'],
    ['Is a repair on an out-of-warranty item guaranteed?',
        'That depends on the policy of the brand concerned.'],
    ['Can we bring the item to you instead?',
        'Yes. You can bring it directly to our store in Tabanan, Monday to Saturday, 08:00 to 17:00 WITA.'],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include $root . '/tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/">
    <title><?= $e($title) ?></title>
    <meta name="description" content="<?= $e($desc) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="<?= $url ?>">
    <link rel="alternate" hreflang="en" href="<?= $url ?>">
    <link rel="alternate" hreflang="id" href="https://www.kusumatrisnabali.com/">
    <link rel="alternate" hreflang="x-default" href="https://www.kusumatrisnabali.com/">

    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">
    <meta name="theme-color" content="#c1121f">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="id_ID">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:title" content="<?= $e($title) ?>">
    <meta property="og:description" content="<?= $e($desc) ?>">
    <meta property="og:url" content="<?= $url ?>">
    <meta property="og:image" content="https://www.kusumatrisnabali.com/assets/services-og.jpg">
    <meta name="twitter:card" content="summary_large_image">

    <?php
    include $root . '/schema-store.php';
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => 'Electronics service for villas and hotels',
        'serviceType' => 'Electronics repair and maintenance',
        'description' => $desc,
        'url' => $url,
        'inLanguage' => 'en',
        'provider' => ['@id' => SITE_URL . '/#store'],
        'areaServed' => ['@type' => 'AdministrativeArea', 'name' => 'Bali'],
    ]);
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'inLanguage' => 'en',
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
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/tailwind.css?v=<?= filemtime($root . '/assets/tailwind.css'); ?>">
</head>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <header class="sticky top-0 z-40 bg-[var(--ground)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 lg:h-20 flex items-center justify-between gap-3">
            <a href="/en/" class="flex items-center gap-3 min-w-0">
                <img src="assets/img/logo.webp" width="96" height="96" alt="" class="w-9 h-9 lg:w-11 lg:h-11 rounded-full shrink-0">
                <span class="text-lg lg:text-xl font-bold tracking-tight truncate">Kusuma Trisna Bali</span>
            </a>
            <nav aria-label="Language and contact" class="flex items-center gap-[var(--gap)] shrink-0">
                <a href="/" hreflang="id" lang="id" class="px-3 lg:px-4 py-2.5 rounded-[var(--r)] font-semibold bg-[var(--tile)] hover:bg-[var(--tile-2)] transition-colors"><span class="lg:hidden">ID</span><span class="hidden lg:inline">Bahasa Indonesia</span></a>
                <a href="<?= $e($waService) ?>" target="_blank" rel="noopener" class="btn !py-2.5 hidden sm:inline-flex">Chat on WhatsApp</a>
            </nav>
        </div>
    </header>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6">

        <!-- Opening -->
        <section class="pt-4 lg:pt-6 board lg:[grid-auto-rows:minmax(120px,auto)]" data-reveal>
            <div class="tile col-span-2 lg:col-span-7 lg:row-span-3 flex flex-col justify-between gap-8 lg:!p-10">
                <div>
                    <h1 class="t-h">Electronics service for villas &amp; hotels</h1>
                    <p class="t-s mt-4 max-w-xl">Authorized service and supply from Tabanan, since 2019. We come to your property anywhere in Bali, with free pickup.</p>
                </div>
                <div class="grid sm:grid-cols-2 gap-[var(--gap)] sm:max-w-lg">
                    <a href="<?= $e($waService) ?>" target="_blank" rel="noopener" class="btn">Arrange a service</a>
                    <a href="tel:+6281238300513" class="btn !bg-[var(--ink)] hover:!bg-black">Call 0812-3830-0513</a>
                </div>
            </div>
            <div class="tile tile--photo col-span-2 lg:col-span-5 lg:row-span-3 aspect-[4/3] lg:aspect-auto">
                <img src="assets/img/promo1.webp" width="1384" height="1040" fetchpriority="high" alt="Technician checking a TV">
            </div>
        </section>

        <!-- Why -->
        <section aria-label="Why property managers call us" class="mt-[var(--gap)] board" data-reveal>
            <div class="tile lg:col-span-3 bg-[var(--ink)] text-white lg:!p-8">
                <h2 class="t-m">Free pickup, all of Bali</h2>
                <p class="t-s mt-3">No area limit. Visits are scheduled in advance.</p>
            </div>
            <div class="tile lg:col-span-3 bg-[var(--tile-2)] lg:!p-8">
                <h2 class="t-m">Checked on site</h2>
                <p class="t-s mt-3">Our team finds the fault at your property first.</p>
            </div>
            <div class="tile lg:col-span-3 lg:!p-8">
                <h2 class="t-m">No charge if you decline</h2>
                <p class="t-s mt-3">Out of warranty, you hear the cost before anything is taken.</p>
            </div>
            <div class="tile lg:col-span-3 bg-[var(--deep)] text-white lg:!p-8">
                <h2 class="t-m">Trackable repairs</h2>
                <p class="t-s mt-3">A service code lets you follow each item once it reaches us.</p>
            </div>
        </section>

        <!-- How it works -->
        <section id="how" class="mt-24 lg:mt-32 scroll-mt-24">
            <h2 class="t-h">How it works</h2>
            <div class="mt-10 grid lg:grid-cols-12 gap-[var(--gap)] gap-y-10 items-end" data-reveal>
                <figure class="lg:col-span-3">
                    <div class="tile tile--photo h-[46vw] lg:h-[260px]"><img src="assets/img/slider7.webp" width="1536" height="864" loading="lazy" class="object-[88%_40%]" alt="Staff member with a tablet"></div>
                    <figcaption class="mt-4">
                        <p class="t-m">You contact us</p>
                        <p class="t-s text-[var(--soft)] mt-1">We note your contact details, location, and the items to service.</p>
                    </figcaption>
                </figure>
                <figure class="lg:col-span-4">
                    <div class="tile tile--photo h-[58vw] lg:h-[380px]"><img src="assets/img/slider1.webp" width="1600" height="896" loading="lazy" class="object-[40%_50%]" alt="Service team checking a TV in a living room"></div>
                    <figcaption class="mt-4">
                        <p class="t-m">We check on site</p>
                        <p class="t-s text-[var(--soft)] mt-1">Our team visits as scheduled and identifies the fault.</p>
                    </figcaption>
                </figure>
                <figure class="lg:col-span-5">
                    <div class="tile tile--photo h-[70vw] lg:h-[500px]"><img src="assets/img/h4.webp" width="1600" height="896" loading="lazy" alt="Items at the service office"></div>
                    <figcaption class="mt-4">
                        <p class="t-m">Repaired at our office</p>
                        <p class="t-s text-[var(--soft)] mt-1">You receive a service code. Timing depends on spare part delivery.</p>
                    </figcaption>
                </figure>
            </div>

            <div class="mt-10 grid lg:grid-cols-2 gap-[var(--gap)]" data-reveal>
                <div class="tile bg-[var(--ink)] text-white lg:!p-8">
                    <h3 class="t-l">Under warranty</h3>
                    <p class="t-s mt-3 max-w-lg">We take the item to our office, request the spare part from the brand, and replace it.</p>
                </div>
                <div class="tile bg-[var(--deep)] text-white lg:!p-8">
                    <h3 class="t-l">Out of warranty</h3>
                    <p class="t-s mt-3 max-w-lg">We quote the repair cost during the check. If you agree, we take it and repair it. If not, it stays with you at no charge.</p>
                </div>
            </div>
        </section>

        <?php if ($partners): ?>
            <section class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-[var(--gap)] items-center" data-reveal>
                <h2 class="t-m lg:col-span-3 mb-4 lg:mb-0">Authorized service center for</h2>
                <ul class="lg:col-span-9 grid grid-cols-3 sm:grid-cols-6 gap-[var(--gap)]">
                    <?php foreach ($partners as $partner): ?>
                        <li class="tile !p-3 flex items-center justify-center aspect-[3/2]">
                            <img src="<?= $e(thumb_src('admin/uploads/partners/' . $partner['logo'], 240)) ?>" alt="<?= $e(nice_brand($partner['name'])) ?>" loading="lazy" decoding="async" class="blend max-h-full max-w-full object-contain">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <!-- Supply -->
        <section class="mt-24 lg:mt-32 board" data-reveal>
            <div class="tile tile--photo col-span-2 lg:col-span-6 aspect-[4/3] lg:aspect-auto lg:min-h-[320px]">
                <img src="assets/img/slider3.webp" width="1920" height="1075" loading="lazy" alt="Showroom with refrigerators, air conditioners, TVs, and audio equipment">
            </div>
            <div class="tile col-span-2 lg:col-span-6 flex flex-col justify-between gap-8 lg:!p-10">
                <div>
                    <h2 class="t-h">Equipping a property?</h2>
                    <p class="t-s mt-4 max-w-lg">We also supply official products from <?= $brandCount ?> brands, including TVs, air conditioners, display coolers, and fans. Send us your list and location, and we will check availability.</p>
                </div>
                <div class="flex flex-wrap gap-[var(--gap)]">
                    <a href="<?= $e($waSupply) ?>" target="_blank" rel="noopener" class="btn">Send your list</a>
                    <a href="products.php" hreflang="id" class="px-4 py-3 rounded-[var(--r)] bg-[var(--tile-2)] font-semibold hover:bg-[#d1d5db] transition-colors">Catalog (in Indonesian)</a>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="mt-24 lg:mt-32 grid lg:grid-cols-12 gap-[var(--gap)] gap-y-6 scroll-mt-24">
            <h2 class="t-h lg:col-span-4 lg:pr-8">Common questions</h2>
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

        <!-- Contact -->
        <section id="contact" class="mt-24 lg:mt-32 mb-24 lg:mb-32 grid lg:grid-cols-12 gap-[var(--gap)] scroll-mt-24">
            <div class="tile lg:col-span-8 bg-[var(--ink)] text-white flex flex-col justify-between gap-8 lg:min-h-[260px] lg:!p-10">
                <h2 class="t-h">Tell us what needs fixing</h2>
                <p class="t-s max-w-lg">Share the brand, the item, the fault, and your location. We reply during working hours, Monday to Saturday, 08:00 to 17:00 WITA.</p>
            </div>
            <a href="<?= $e($waService) ?>" target="_blank" rel="noopener" class="tile lg:col-span-4 bg-[var(--accent)] text-white flex flex-col justify-between gap-6 transition-colors hover:bg-[var(--deep)] lg:!p-10">
                <span class="t-m">Chat on WhatsApp</span>
                <span class="link-arrow">0877-7992-8897 <?= $arrow ?></span>
            </a>
        </section>
    </main>

    <footer class="bg-[#111827] text-white py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid sm:grid-cols-2 lg:grid-cols-12 gap-x-6 gap-y-8 text-gray-300">
            <div class="lg:col-span-5">
                <p class="t-m text-white">Kusuma Trisna Bali</p>
                <p class="mt-3">Electronics distributor and authorized service center in Tabanan, Bali.</p>
            </div>
            <address class="not-italic lg:col-span-4">
                <span class="block font-semibold text-white mb-3">Address</span>
                Jl. By Pass Dr. Ir. Soekarno, Banjar Tegal Belodan, Dauh Peken, Tabanan, Bali 82113<br>
                <a href="https://share.google/LNnFVBGg7wU9klqp3" target="_blank" rel="noopener noreferrer" class="underline underline-offset-4 hover:text-white">Open in Google Maps</a>
            </address>
            <div class="lg:col-span-3">
                <span class="block font-semibold text-white mb-3">Contact</span>
                Service: <a href="tel:+6281238300513" class="hover:text-white">0812-3830-0513</a><br>
                Sales: <a href="tel:+6287779928897" class="hover:text-white">0877-7992-8897</a><br>
                <a href="mailto:info@kusumatrisnabali.com" class="hover:text-white break-all">info@kusumatrisnabali.com</a>
            </div>
            <p class="sm:col-span-2 lg:col-span-12">© <?= date('Y') ?> Kusuma Trisna Bali</p>
        </div>
    </footer>

    <a href="<?= $e($waService) ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp"
        class="fixed bottom-4 right-4 lg:bottom-5 lg:right-5 z-50 w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-[#1f9d55] hover:bg-[#188046] text-white shadow-lg flex items-center justify-center transition-colors">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35zM12.05 21.5h-.01a9.4 9.4 0 0 1-4.8-1.32l-.34-.2-3.57.94.95-3.48-.22-.36a9.4 9.4 0 0 1-1.44-5.02c0-5.2 4.23-9.43 9.44-9.43 2.52 0 4.89.98 6.67 2.77a9.37 9.37 0 0 1 2.76 6.67c0 5.2-4.24 9.43-9.44 9.43zm8.03-17.46A11.27 11.27 0 0 0 12.05.72C5.79.72.7 5.8.7 12.06c0 2 .52 3.95 1.52 5.67L.6 23.6l6.01-1.58a11.3 11.3 0 0 0 5.43 1.38h.01c6.25 0 11.34-5.09 11.34-11.34 0-3.03-1.18-5.88-3.32-8.02z" />
        </svg>
    </a>

    <script src="assets/main.js?v=<?= filemtime($root . '/assets/main.js'); ?>"></script>
</body>

</html>
