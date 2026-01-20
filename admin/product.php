<?php
require 'config/database.php';

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
    <title>Products | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
</head>

<body
    x-data="{ page: 'products', loaded: true, darkMode: false, sidebarToggle: false }"
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
                            Products
                        </h2>

                        <a href="product-create.php"
                            class="inline-flex items-center gap-2 rounded-lg
                     border border-gray-300 px-4 py-2
                     text-sm font-medium text-gray-700
                     hover:bg-gray-100
                     dark:border-gray-700 dark:text-gray-300
                     dark:hover:bg-white/[0.05] transition">
                            <i class="fa-solid fa-plus"></i>
                            Add Product
                        </a>
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
                                        <th class="px-5 py-3 sm:px-6">Status</th>
                                        <th class="px-5 py-3 sm:px-6">Aksi</th>
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
                                                <?= $p['price'] !== null ? 'Rp ' . number_format($p['price'], 0, ',', '.') : '-' ?>
                                            </td>

                                            <td class="px-5 py-4 sm:px-6">
                                                <?php if ($p['is_active']): ?>
                                                    <span class="rounded-full bg-success-50 px-2 py-0.5
                                       text-theme-xs font-medium text-success-700
                                       dark:bg-success-500/15 dark:text-success-500">
                                                        Active
                                                    </span>
                                                <?php else: ?>
                                                    <span class="rounded-full bg-error-50 px-2 py-0.5
                                       text-theme-xs font-medium text-error-700
                                       dark:bg-error-500/15 dark:text-error-500">
                                                        Inactive
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex gap-2">
                                                    <a href="product-edit.php?id=<?= $p['id']; ?>"
                                                        class="inline-flex items-center gap-1 rounded-lg
                                   border border-warning-500/20
                                   bg-warning-500/10 px-3 py-1.5
                                   text-theme-xs font-medium text-warning-600
                                   hover:bg-warning-500/20">
                                                        <i class="fa-solid fa-pen"></i> Edit
                                                    </a>

                                                    <a href="product-delete.php?id=<?= $p['id']; ?>"
                                                        onclick="return confirm('Yakin mau menghapus produk ini?')"
                                                        class="inline-flex items-center gap-1 rounded-lg
                                   border border-error-500/20
                                   bg-error-500/10 px-3 py-1.5
                                   text-theme-xs font-medium text-error-600
                                   hover:bg-error-500/20">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </a>
                                                </div>
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