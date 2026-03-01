<?php
require 'admin/config/database.php';

/*
|--------------------------------------------------------------------------
| FILTER INPUT
|--------------------------------------------------------------------------
*/
$search = trim($_GET['search'] ?? '');
$brand_slug = $_GET['brand'] ?? '';
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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Produk | Kusuma Trisna Bali</title>
    <link rel="icon" href="admin/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#c1121f'
                    }
                }
            }
        }
    </script>
</head>

<body class="text-gray-800 bg-gray-50">

    <?php include 'header.php'; ?>

    <!-- HERO -->
    <section class="relative py-28">
        <div class="absolute inset-0">
            <img src="assets/img/slider5.jpg" class="w-full h-full object-cover" alt="Produk">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h1 class="text-4xl font-semibold text-primary mb-4">Produk Kami</h1>
            <p class="text-white max-w-xl mx-auto">
                Berbagai pilihan produk elektronik untuk kebutuhan bisnis dan pelanggan Anda.
            </p>

            </p>
        </div>
    </section>

    <!-- PRODUCTS -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">

            <!-- FILTER -->
            <form method="GET"
                class="bg-white border rounded-2xl p-5 mb-10 shadow-md
           transition-all duration-300 hover:shadow-lg">

                <div
                    class="grid grid-cols-1 lg:grid-cols-[2fr_1.2fr_1.2fr_1fr_auto] 
               gap-4 items-center">

                    <!-- SEARCH -->
                    <div>
                        <div class="relative">
                            <input type="text"
                                name="search"
                                value="<?= htmlspecialchars($search); ?>"
                                placeholder="Nama produk..."
                                class="w-full border border-gray-300 rounded-xl
                           px-4 py-3 pl-11
                           focus:ring-2 focus:ring-primary/30
                           focus:border-primary transition">

                            <i
                                class="fa-solid fa-magnifying-glass
                           absolute left-4 top-1/2 -translate-y-1/2
                           text-gray-400">
                            </i>
                        </div>
                    </div>

                    <!-- BRAND -->
                    <div>
                        <select name="brand"
                            class="w-full border border-gray-300 rounded-xl
                       px-4 py-3
                       focus:ring-2 focus:ring-primary/30
                       focus:border-primary transition">
                            <option value="">Semua Brand</option>
                            <?php foreach ($brands as $b): ?>
                                <option value="<?= htmlspecialchars($b['slug']); ?>"
                                    <?= $brand_slug === $b['slug'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($b['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- CATEGORY -->
                    <div>
                        <select name="category"
                            class="w-full border border-gray-300 rounded-xl
                       px-4 py-3
                       focus:ring-2 focus:ring-primary/30
                       focus:border-primary transition">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= htmlspecialchars($c['slug']); ?>"
                                    <?= $category_slug === $c['slug'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($c['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- SUBCATEGORY -->
                    <div>
                        <select name="subcategory"
                            class="w-full border border-gray-300 rounded-xl
                       px-4 py-3
                       focus:ring-2 focus:ring-primary/30
                       focus:border-primary transition">
                            <option value="">Semua</option>
                            <?php foreach ($subcategories as $s): ?>
                                <option value="<?= htmlspecialchars($s['slug']); ?>"
                                    <?= $subcategory_slug === $s['slug'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($s['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- ACTION -->

                    <!-- FILTER -->
                    <button type="submit"
                        class="w-auto h-11 flex items-center justify-center
                       rounded-xl bg-primary text-white
                       hover:bg-darkred hover:scale-105
                       transition-all duration-300 shadow px-2">
                        <i class="fa-solid fa-search p-2"></i> Search
                    </button>
                </div>
            </form>



            <!-- GRID -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php if (empty($products)): ?>
                    <div class="col-span-full text-center text-gray-500">
                        Tidak ada produk.
                    </div>
                <?php endif; ?>

                <?php foreach ($products as $p): ?>
                    <?php
                    $img = $p['image'] ?? '';
                    $imgPath = $img ? "admin/uploads/products/" . $img : "admin/assets/img/product-placeholder.png";
                    ?>
                    <!-- <div class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition"> -->
                    <div class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition">

                        <!-- IMAGE WRAPPER -->
                        <div class="relative h-56 flex items-center justify-center bg-gray-50">

                            <!-- Floating Model Badge -->
                            <?php if (!empty($p['model'])): ?>
                                <div class="absolute top-3 right-3">
                                    <span class="bg-white/90 backdrop-blur-sm text-primary text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                        <?= htmlspecialchars($p['model']); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Product Image -->
                            <img
                                src="<?= htmlspecialchars($imgPath); ?>"
                                alt="<?= htmlspecialchars($p['name']); ?>"
                                class="max-h-44 object-contain">
                        </div>

                        <!-- IMAGE (FIX: jangan dobel) -->
                        <!-- <div class="h-56 flex items-center justify-center bg-gray-50">
                            <img
                                src="<?= htmlspecialchars($imgPath); ?>"
                                alt="<?= htmlspecialchars($p['name']); ?>"
                                class="max-h-44 object-contain">
                        </div> -->

                        <div class="p-6">
                            <!-- Brand & Subcategory -->
                            <div class="text-sm text-primary font-medium mb-1">
                                <?= htmlspecialchars($p['brand_name']); ?> • <?= htmlspecialchars($p['subcategory_name']); ?>
                            </div>

                            <!-- Product Name -->
                            <h3 class="text-lg font-semibold mb-1">
                                <?= htmlspecialchars($p['name']); ?>
                            </h3>

                            <!-- Model (jadi badge) -->
                            <!-- <?php if (!empty($p['model'])): ?>
                                <div class="mb-2">
                                    <span class="inline-block bg-primary/10 text-primary text-xs font-semibold px-3 py-1 rounded-full">
                                        Model: <?= htmlspecialchars($p['model']); ?>
                                    </span>
                                </div>
                            <?php endif; ?> -->

                            <!-- Tagline -->
                            <?php if (!empty($p['tagline'])): ?>
                                <p class="text-sm text-gray-600 italic line-clamp-2 mb-2">
                                    <?= htmlspecialchars($p['tagline']); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Bottom Section -->
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-xs text-gray-500 uppercase tracking-wide">
                                    <?= htmlspecialchars($p['category_name']); ?>
                                </span>

                                <a href="detail-product.php?slug=<?= urlencode($p['slug']); ?>"
                                    class="text-primary text-sm font-medium hover:underline">
                                    Detail <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>


                    </div>
                <?php endforeach; ?>

            </div>
            <!-- PAGINATION -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center mt-12">
                    <nav class="flex items-center gap-2">

                        <?php
                        $queryString = $_GET;
                        ?>

                        <!-- Previous -->
                        <?php if ($page > 1): ?>
                            <?php
                            $queryString['page'] = $page - 1;
                            ?>
                            <a href="?<?= http_build_query($queryString); ?>"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php
                            $queryString['page'] = $i;
                            ?>
                            <a href="?<?= http_build_query($queryString); ?>"
                                class="px-4 py-2 border rounded-lg 
                        <?= $i == $page ? 'bg-primary text-white border-primary' : 'hover:bg-gray-100'; ?>">
                                <?= $i; ?>
                            </a>
                        <?php endfor; ?>

                        <!-- Next -->
                        <?php if ($page < $totalPages): ?>
                            <?php
                            $queryString['page'] = $page + 1;
                            ?>
                            <a href="?<?= http_build_query($queryString); ?>"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                                <i class="fa-solid fa-angles-right"></i>
                            </a>
                        <?php endif; ?>

                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="assets/main.js"></script>
</body>

</html>