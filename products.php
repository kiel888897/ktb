<?php
require 'admin/config/database.php';
require_once __DIR__ . '/image-helper.php';

/*
|--------------------------------------------------------------------------
| FILTER INPUT
|--------------------------------------------------------------------------
*/
$search = trim($_GET['search'] ?? '');
$brand_slug = $_GET['brand'] ?? '';
$partner_slug = $_GET['partner'] ?? '';
$category_slug = $_GET['category'] ?? '';
$subcategory_slug = $_GET['subcategory'] ?? '';

/*
|--------------------------------------------------------------------------
| DATA FILTER LIST
|--------------------------------------------------------------------------
*/
$brands = $pdo->query("SELECT id, slug, name FROM brands ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query("SELECT id, slug, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$subcategories = $pdo->query("SELECT id, slug, name FROM subcategories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| CONVERT SLUG TO ID
|--------------------------------------------------------------------------
*/
function getIdBySlug($pdo, $table, $slug)
{
    if ($slug === '') return 0;

    $stmt = $pdo->prepare("SELECT id FROM {$table} WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    return (int) $stmt->fetchColumn();
}

$brand_id = getIdBySlug($pdo, 'brands', $brand_slug);
$partner_id = getIdBySlug($pdo, 'partners', $partner_slug);
$category_id = getIdBySlug($pdo, 'categories', $category_slug);
$subcategory_id = getIdBySlug($pdo, 'subcategories', $subcategory_slug);

/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/
$perPage = 9;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

/*
|--------------------------------------------------------------------------
| BASE QUERY
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT
        p.id,
        p.name,
        p.slug,
        p.tagline,
        p.model,
        b.name AS brand_name,
        c.name AS category_name,
        s.name AS subcategory_name,
        (
            SELECT pi.image
            FROM product_images pi
            WHERE pi.product_id = p.id
            ORDER BY pi.is_main DESC, pi.sort_order ASC
            LIMIT 1
        ) AS image
    FROM products p
    JOIN brands b ON b.id = p.brand_id
    JOIN categories c ON c.id = p.category_id
    JOIN subcategories s ON s.id = p.subcategory_id
    WHERE p.is_active = 1
";

$countSql = "
    SELECT COUNT(*)
    FROM products p
    WHERE p.is_active = 1
";

$params = [];
$countParams = [];

/*
|--------------------------------------------------------------------------
| APPLY FILTER
|--------------------------------------------------------------------------
*/
if ($search !== '') {
    $sql .= " AND p.name LIKE ?";
    $countSql .= " AND p.name LIKE ?";
    $params[] = "%{$search}%";
    $countParams[] = "%{$search}%";
}

if ($brand_id > 0) {
    $sql .= " AND p.brand_id = ?";
    $countSql .= " AND p.brand_id = ?";
    $params[] = $brand_id;
    $countParams[] = $brand_id;
}

if ($partner_id > 0) {
    $sql .= " AND p.partner_id = ?";
    $countSql .= " AND p.partner_id = ?";
    $params[] = $partner_id;
    $countParams[] = $partner_id;
}

if ($category_id > 0) {
    $sql .= " AND p.category_id = ?";
    $countSql .= " AND p.category_id = ?";
    $params[] = $category_id;
    $countParams[] = $category_id;
}

if ($subcategory_id > 0) {
    $sql .= " AND p.subcategory_id = ?";
    $countSql .= " AND p.subcategory_id = ?";
    $params[] = $subcategory_id;
    $countParams[] = $subcategory_id;
}

/*
|--------------------------------------------------------------------------
| EXECUTE COUNT
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare($countSql);
$stmt->execute($countParams);
$totalData = (int) $stmt->fetchColumn();
$totalPages = max(1, ceil($totalData / $perPage));

/* 
| Fix jika page melebihi total halaman
*/
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $perPage;
}

/*
|--------------------------------------------------------------------------
| ADD ORDER + LIMIT
|--------------------------------------------------------------------------
*/
$sql .= " ORDER BY p.sort_order ASC, p.id DESC LIMIT ? OFFSET ?";
$params[] = $perPage;
$params[] = $offset;

/*
|--------------------------------------------------------------------------
| EXECUTE MAIN QUERY
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| SEO: canonical, judul, robots
|--------------------------------------------------------------------------
*/
$site = 'https://www.kusumatrisnabali.com';
$nameBySlug = fn(array $rows, string $slug) => array_column($rows, 'name', 'slug')[$slug] ?? '';

$canonParams = [];
if ($brand_id > 0) $canonParams['brand'] = $brand_slug;
if ($partner_id > 0) $canonParams['partner'] = $partner_slug;
if ($category_id > 0) $canonParams['category'] = $category_slug;
if ($subcategory_id > 0) $canonParams['subcategory'] = $subcategory_slug;
if ($page > 1) $canonParams['page'] = $page;
$canonical = $site . '/products.php' . ($canonParams ? '?' . http_build_query($canonParams) : '');

$filterLabel = trim(implode(' ', array_filter([
    $subcategory_id > 0 ? $nameBySlug($subcategories, $subcategory_slug) : ($category_id > 0 ? $nameBySlug($categories, $category_slug) : ''),
    $brand_id > 0 ? nice_brand($nameBySlug($brands, $brand_slug)) : '',
])));

$seoTitle = $filterLabel !== ''
    ? "Jual {$filterLabel} Resmi di Tabanan Bali | Kusuma Trisna Bali"
    : 'Produk Elektronik Resmi di Tabanan Bali | Kusuma Trisna Bali';
if ($page > 1) {
    $seoTitle = "Halaman {$page} - " . $seoTitle;
}

// Jenis produk yang punya produk aktif (tombol pilihan). Yang sedang dipilih tetap tampil.
$filledSubs = array_flip($pdo->query("SELECT DISTINCT subcategory_id FROM products WHERE is_active = 1")->fetchAll(PDO::FETCH_COLUMN));
$subChips = array_values(array_filter($subcategories, fn($sc) => isset($filledSubs[$sc['id']]) || $sc['slug'] === $subcategory_slug));

// Hasil pencarian, filter tidak dikenal, dan hasil kosong: jangan diindeks
$noindex = $search !== ''
    || $totalData === 0
    || ($brand_slug !== '' && $brand_id === 0)
    || ($partner_slug !== '' && $partner_id === 0)
    || ($category_slug !== '' && $category_id === 0)
    || ($subcategory_slug !== '' && $subcategory_id === 0);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <?php include 'tag-google.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($seoTitle); ?></title>

    <meta name="description" content="Katalog produk elektronik resmi Kusuma Trisna Bali di Tabanan: TV, kulkas, mesin cuci, showcase, audio, dan sparepart dari brand ternama.">


    <?php if ($noindex): ?>
        <meta name="robots" content="noindex, follow">
    <?php else: ?>
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <?php endif; ?>

    <link rel="canonical" href="<?= htmlspecialchars($canonical); ?>">

    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16.png">
    <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png">

    <meta name="theme-color" content="#c1121f">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle); ?>">
    <meta property="og:description" content="Berbagai produk elektronik resmi dari brand ternama dengan harga terbaik dan garansi resmi di Bali.">
    <meta property="og:url" content="<?= htmlspecialchars($canonical); ?>">
    <meta property="og:site_name" content="Kusuma Trisna Bali">
    <meta property="og:image" content="https://www.kusumatrisnabali.com/assets/products-og.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="674">
    <meta property="og:image:alt" content="Produk Elektronik Kusuma Trisna Bali">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle); ?>">
    <meta name="twitter:description" content="Distributor berbagai produk elektronik resmi dengan harga terbaik di Bali.">
    <meta name="twitter:image" content="https://www.kusumatrisnabali.com/assets/products-og.jpg">

    <!-- Schema.org -->
    <?php
    include 'schema-store.php';
    $itemList = [];
    foreach (array_values($products) as $n => $p) {
        $itemList[] = [
            '@type' => 'ListItem',
            'position' => $offset + $n + 1,
            'url' => $site . '/detail-product.php?slug=' . rawurlencode($p['slug']),
            'name' => $p['name'],
        ];
    }
    jsonld([
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $seoTitle,
        'url' => $canonical,
        'isPartOf' => ['@id' => $site . '/#website'],
        'provider' => ['@id' => $site . '/#store'],
        'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => $totalData, 'itemListElement' => $itemList],
    ]);
    jsonld(breadcrumb_ld([['Beranda', $site . '/'], ['Produk', $site . '/products.php']]));
    ?>

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
$h1 = $filterLabel !== "" ? $filterLabel . " resmi di Tabanan" : "Katalog produk elektronik resmi";
$pageUrl = function (array $set) {
    $q = array_merge($_GET, $set);
    $q = array_filter($q, fn($v) => $v !== '' && $v !== null);
    return 'products.php' . ($q ? '?' . http_build_query($q) : '');
};
$hasFilter = $search !== '' || $brand_id > 0 || $category_id > 0 || $subcategory_id > 0 || $partner_id > 0;
$field = 'w-full h-[52px] rounded-[var(--r)] bg-[var(--tile)] px-4 text-[var(--ink)] placeholder:text-[var(--soft)] focus:bg-[var(--tile-2)] focus:outline-none';
?>

<body id="top" class="home font-['IBM_Plex_Sans'] antialiased">
    <?php $hbCurrent = 'produk'; include 'header-board.php'; ?>

    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6">

        <!-- Judul -->
        <section class="pt-6 lg:pt-10 grid lg:grid-cols-12 gap-[var(--gap)] items-end">
            <div class="lg:col-span-8">
                <nav aria-label="Breadcrumb" class="t-s text-[var(--soft)] mb-4">
                    <a href="/" class="hover:text-[var(--ink)]">Beranda</a> / <span class="text-[var(--ink)]">Produk</span>
                </nav>
                <h1 class="t-h"><?= $e($h1) ?></h1>
            </div>
            <p class="lg:col-span-4 t-s mt-4 lg:mt-0">
                <?= $totalData ?> produk resmi<?= $hasFilter ? ' sesuai pilihan Anda' : ' dari ' . count($brands) . ' merek' ?>. Tanya stok atau harga lewat WhatsApp.
            </p>
        </section>

        <!-- Jenis produk -->
        <nav aria-label="Jenis produk" class="mt-8 -mx-4 sm:mx-0 px-4 sm:px-0 flex gap-[var(--gap)] overflow-x-auto lg:overflow-visible lg:flex-wrap pb-1">
            <a href="<?= $e($pageUrl(['subcategory' => '', 'category' => '', 'page' => ''])) ?>"
                class="shrink-0 px-4 py-2.5 rounded-[var(--r)] font-semibold transition-colors <?= $subcategory_id === 0 && $category_id === 0 ? 'bg-[var(--ink)] text-white' : 'bg-[var(--tile)] hover:bg-[var(--tile-2)]' ?>">Semua</a>
            <?php foreach ($subChips as $sc): $on = $subcategory_slug === $sc['slug']; ?>
                <a href="<?= $e($pageUrl(['subcategory' => $sc['slug'], 'category' => '', 'page' => ''])) ?>" <?= $on ? 'aria-current="true"' : '' ?>
                    class="shrink-0 px-4 py-2.5 rounded-[var(--r)] font-semibold transition-colors <?= $on ? 'bg-[var(--ink)] text-white' : 'bg-[var(--tile)] hover:bg-[var(--tile-2)]' ?>"><?= $e($sc['name']) ?></a>
            <?php endforeach; ?>
        </nav>

        <!-- Cari & filter -->
        <form method="GET" class="mt-[var(--gap)] grid grid-cols-2 lg:grid-cols-12 gap-[var(--gap)]">
            <?php if ($subcategory_id > 0): ?><input type="hidden" name="subcategory" value="<?= $e($subcategory_slug) ?>"><?php endif; ?>
            <div class="col-span-2 lg:col-span-5">
                <label for="cari" class="sr-only">Cari nama produk</label>
                <input id="cari" type="search" name="search" value="<?= $e($search) ?>" placeholder="Cari nama atau model produk" class="<?= $field ?>">
            </div>
            <div class="lg:col-span-3">
                <label for="brandFilter" class="sr-only">Pilih merek</label>
                <select name="brand" id="brandFilter" class="<?= $field ?>">
                    <option value="">Semua merek</option>
                    <?php foreach ($brands as $b): ?>
                        <option value="<?= $e($b['slug']) ?>" <?= $brand_slug === $b['slug'] ? 'selected' : '' ?>><?= $e($niceName($b['name'])) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="lg:col-span-2">
                <label for="categoryFilter" class="sr-only">Pilih kategori</label>
                <select name="category" id="categoryFilter" class="<?= $field ?>">
                    <option value="">Semua kategori</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $e($c['slug']) ?>" <?= $category_slug === $c['slug'] ? 'selected' : '' ?>><?= $e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn col-span-2 lg:col-span-2 h-[52px]">Cari</button>
        </form>

        <?php if ($hasFilter): ?>
            <p class="mt-4 t-s"><a href="products.php" class="link-arrow text-[var(--accent)]">Hapus semua filter <?= $arrow ?></a></p>
        <?php endif; ?>

        <!-- Daftar produk -->
        <section aria-label="Daftar produk" class="mt-10 lg:mt-12">
            <?php if (empty($products)): ?>
                <div class="tile py-16 text-center">
                    <p class="t-m">Produk tidak ditemukan</p>
                    <p class="t-s mt-2">Coba kata lain, atau tanya langsung stoknya lewat WhatsApp.</p>
                    <a href="https://wa.me/6287779928897" target="_blank" rel="noopener" class="btn mt-6">Chat WhatsApp</a>
                </div>
            <?php else: ?>
                <ul class="board !grid-cols-2 lg:!grid-cols-3" data-reveal>
                    <?php foreach ($products as $p):
                        $imgPath = !empty($p['image']) ? 'admin/uploads/products/' . $p['image'] : 'assets/img/product-placeholder.webp'; ?>
                        <li>
                            <a href="detail-product.php?slug=<?= urlencode($p['slug']) ?>" class="tile group flex flex-col h-full !p-4 lg:!p-6">
                                <div class="aspect-square flex items-center justify-center p-1 lg:p-3">
                                    <img src="<?= $e(thumb_src($imgPath, 480)) ?>" alt="<?= $e($p['name'] . ' - ' . $niceName($p['brand_name'])) ?>"
                                        loading="lazy" decoding="async"
                                        class="blend max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                                </div>
                                <div class="mt-3 flex-1">
                                    <h2 class="t-m group-hover:text-[var(--accent)] transition-colors"><?= $e($p['name']) ?></h2>
                                    <p class="t-s text-[var(--soft)] mt-1"><?= $e($niceName($p['brand_name'])) ?> · <?= $e($p['subcategory_name']) ?></p>
                                </div>
                                <span class="link-arrow mt-4 t-s">Lihat detail <?= $arrow ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($totalPages > 1): ?>
                <nav aria-label="Halaman" class="mt-10 flex flex-wrap items-center gap-[var(--gap)]">
                    <?php if ($page > 1): ?>
                        <a href="<?= $e($pageUrl(['page' => $page - 1])) ?>" class="px-4 py-2.5 rounded-[var(--r)] bg-[var(--tile)] font-semibold hover:bg-[var(--tile-2)]" aria-label="Halaman sebelumnya">Sebelumnya</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?= $e($pageUrl(['page' => $i])) ?>" aria-label="Halaman <?= $i ?>" <?= $i == $page ? 'aria-current="page"' : '' ?>
                            class="min-w-[44px] text-center px-3 py-2.5 rounded-[var(--r)] font-semibold <?= $i == $page ? 'bg-[var(--ink)] text-white' : 'bg-[var(--tile)] hover:bg-[var(--tile-2)]' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="<?= $e($pageUrl(['page' => $page + 1])) ?>" class="px-4 py-2.5 rounded-[var(--r)] bg-[var(--tile)] font-semibold hover:bg-[var(--tile-2)]" aria-label="Halaman berikutnya">Berikutnya</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        </section>

        <!-- Ajakan -->
        <section class="mt-24 lg:mt-32 mb-24 lg:mb-32 grid lg:grid-cols-12 gap-[var(--gap)]">
            <div class="tile lg:col-span-8 bg-[var(--deep)] text-white flex flex-col justify-between gap-8 lg:min-h-[260px]">
                <h2 class="t-h">Tidak menemukan yang dicari?</h2>
                <p class="t-s max-w-lg">Sebutkan merek atau model yang Anda perlukan, kami bantu cek ketersediaannya.</p>
            </div>
            <a href="https://wa.me/6287779928897?text=<?= rawurlencode('Halo Kusuma Trisna Bali, saya mencari produk: ') ?>" target="_blank" rel="noopener"
                class="tile lg:col-span-4 bg-[var(--accent)] text-white flex flex-col justify-between gap-6 transition-colors hover:bg-[var(--deep)]">
                <span class="t-m">Tanya stok lewat WhatsApp</span>
                <span class="link-arrow">0877-7992-8897 <?= $arrow ?></span>
            </a>
            <p class="lg:col-span-12 t-s mt-4">Lebih suka belanja online? Kunjungi <a href="https://shopee.co.id/trisnaelectronics" target="_blank" rel="noopener" class="underline underline-offset-4 hover:text-[var(--accent)]">toko Shopee kami, Trisna Electronics</a>.</p>
        </section>
    </main>

    <?php include 'footer-board.php'; ?>

    <script src="assets/main.js?v=<?= filemtime(__DIR__ . '/assets/main.js'); ?>"></script>
</body>

</html>
