<?php
require 'auth.php';
require_role(['admin', 'staff', 'superadmin']);
require 'config/database.php';
// Ambil profit global
$stmtProfit = $pdo->query("SELECT profit FROM company LIMIT 1");
$dataProfit = $stmtProfit->fetch();
$profitPercent = $dataProfit ? (float)$dataProfit['profit'] : 0;

$sql = "
    SELECT
        p.*,
        b.name AS brand_name,
        c.name AS category_name,
        s.name AS subcategory_name,
        pr.name AS partner_name
    FROM products p
    JOIN brands b ON b.id = p.brand_id
    JOIN categories c ON c.id = p.category_id
    JOIN subcategories s ON s.id = p.subcategory_id
    LEFT JOIN partners pr ON pr.id = p.partner_id
    ORDER BY p.sort_order ASC, p.id DESC
";

$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sellers | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
</head>

<body
    x-data="{ page: 'seller', loaded: true, darkMode: false, sidebarToggle: false }"
    x-init="
    darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', v => localStorage.setItem('darkMode', JSON.stringify(v)))
  "
    :class="{'dark bg-gray-900': darkMode}">

    <!-- Preloader -->
    <div
        x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => setTimeout(() => loaded = false, 500))"
        class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-black">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-brand-500 border-t-transparent"></div>
    </div>

    <div class="flex h-screen overflow-hidden">
        <?php include 'sidebar.php'; ?>

        <div class="relative flex flex-1 flex-col overflow-y-auto">
            <?php include 'header.php'; ?>

            <main>
                <div class="mx-auto max-w-7xl p-4 md:p-6">

                    <!-- Header -->
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                            List Products
                        </h2>

                    </div>

                    <!-- Table -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                   bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6">

                        <div class="max-w-full overflow-x-auto">
                            <table id="productTable" class="min-w-full">

                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-5 py-3 sm:px-6">Product</th>
                                        <th class="px-5 py-3 sm:px-6">Brand</th>
                                        <th class="px-5 py-3 sm:px-6">Category</th>
                                        <th class="px-5 py-3 sm:px-6">Price</th>
                                        <th class="px-5 py-3 sm:px-6">Stock</th>
                                        <th class="px-5 py-3 sm:px-6">Details</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <?php foreach ($products as $p): ?>
                                        <tr>

                                            <td class="px-5 py-4 sm:px-6">
                                                <div>
                                                    <p class="font-medium text-gray-800 dark:text-white/90">
                                                        <?= htmlspecialchars($p['name']); ?>
                                                    </p>
                                                    <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                                                        <?= htmlspecialchars($p['subcategory_name']); ?>
                                                    </p>
                                                </div>
                                            </td>

                                            <td class="px-5 py-4 sm:px-6">
                                                <?= htmlspecialchars($p['brand_name']); ?>
                                            </td>

                                            <td class="px-5 py-4 sm:px-6">
                                                <?= htmlspecialchars($p['category_name']); ?>
                                            </td>

                                            <td class="px-5 py-4 sm:px-6">
                                                <?php
                                                if ($p['price'] !== null) {
                                                    $sellingPrice = $p['price'] + ($p['price'] * $profitPercent / 100);
                                                    echo 'Rp ' . number_format($sellingPrice, 0, ',', '.');
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>


                                            <td class="px-5 py-4 sm:px-6">
                                                <?= htmlspecialchars($p['stock']); ?>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <a href="../detail-product.php?slug=<?= $p['slug']; ?>" target="_blank" class="text-blue-500 hover:text-blue-700">
                                                    <i class="fa fa-eye"></i> Details
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#productTable').DataTable({
                pageLength: 10,
                lengthChange: false,
                columnDefs: [{
                    orderable: false,
                    targets: [5]
                }],
                language: {
                    search: "Cari:",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                }
            });
        });
    </script>

    <script defer src="bundle.js"></script>
</body>

</html>