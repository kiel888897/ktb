<?php
require 'admin/config/database.php';

/*
|--------------------------------------------------------------------------
| FILTER INPUT
|--------------------------------------------------------------------------
*/
$search = trim($_GET['search'] ?? '');
$brand_id = (int)($_GET['brand'] ?? 0);
$category_id = (int)($_GET['category'] ?? 0);
$subcategory_id = (int)($_GET['subcategory'] ?? 0);

/*
|--------------------------------------------------------------------------
| DATA FILTER
|--------------------------------------------------------------------------
*/
$brands = $pdo->query("SELECT id, name FROM brands ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$subcategories = $pdo->query("SELECT id, name FROM subcategories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| QUERY PRODUCTS (FIX)
|--------------------------------------------------------------------------
| - BUG kamu: WHERE sudah ditutup lalu kamu tambah AND (jadi salah)
| - BUG kamu: ORDER BY dobel
| - FIX: WHERE 1=1 supaya aman nambah filter
*/
$sql = "
    SELECT
        p.id,
        p.name,
        p.slug,
        p.description,
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
    WHERE 1=1
      AND p.is_active = 1
";

$params = [];

if ($search !== '') {
    $sql .= " AND p.name LIKE ?";
    $params[] = "%{$search}%";
}
if ($brand_id > 0) {
    $sql .= " AND p.brand_id = ?";
    $params[] = $brand_id;
}
if ($category_id > 0) {
    $sql .= " AND p.category_id = ?";
    $params[] = $category_id;
}
if ($subcategory_id > 0) {
    $sql .= " AND p.subcategory_id = ?";
    $params[] = $subcategory_id;
}

$sql .= " ORDER BY p.sort_order ASC, p.id DESC";

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

    <style>
        /* fallback kalau line-clamp belum aktif */
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
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
                            <option value="0">Semua Brand</option>
                            <?php foreach ($brands as $b): ?>
                                <option value="<?= (int)$b['id']; ?>"
                                    <?= $brand_id == (int)$b['id'] ? 'selected' : ''; ?>>
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
                            <option value="0">Semua Kategori</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= (int)$c['id']; ?>"
                                    <?= $category_id == (int)$c['id'] ? 'selected' : ''; ?>>
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
                            <option value="0">Semua</option>
                            <?php foreach ($subcategories as $s): ?>
                                <option value="<?= (int)$s['id']; ?>"
                                    <?= $subcategory_id == (int)$s['id'] ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($s['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- ACTION -->
                    <div class="flex items-center gap-2">

                        <!-- FILTER -->
                        <button type="submit"
                            class="w-11 h-11 flex items-center justify-center
                       rounded-xl bg-primary text-white
                       hover:bg-darkred hover:scale-105
                       transition-all duration-300 shadow">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <!-- RESET -->
                        <a href="products.php"
                            class="w-11 h-11 flex items-center justify-center
                       rounded-xl border border-gray-300
                       text-gray-600
                       hover:bg-gray-100 hover:rotate-180
                       transition-all duration-300">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>


                    </div>

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
                    <div class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition">

                        <!-- IMAGE (FIX: jangan dobel) -->
                        <div class="h-56 flex items-center justify-center bg-gray-50">
                            <img
                                src="<?= htmlspecialchars($imgPath); ?>"
                                alt="<?= htmlspecialchars($p['name']); ?>"
                                class="max-h-44 object-contain">
                        </div>

                        <div class="p-6">
                            <div class="text-sm text-primary font-medium mb-1">
                                <?= htmlspecialchars($p['brand_name']); ?> • <?= htmlspecialchars($p['subcategory_name']); ?>
                            </div>

                            <h3 class="text-lg font-semibold mb-2">
                                <?= htmlspecialchars($p['name']); ?>
                            </h3>

                            <p class="text-sm text-gray-600 line-clamp-3">
                                <?= ($p['description']); ?>
                            </p>

                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm text-gray-500">
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
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="assets/main.js"></script>
</body>

</html>