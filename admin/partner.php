<?php
require 'config/database.php';

// Ambil data partner
$stmt = $pdo->query("
    SELECT *
    FROM partners
    ORDER BY sort_order ASC, id DESC
");
$partners = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partners | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
</head>

<body
    x-data="{ page: 'partners', loaded: true, darkMode: false, sidebarToggle: false }"
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
                            Partners
                        </h2>

                        <a href="partner-create.php"
                            class="inline-flex items-center gap-2 rounded-lg
                     border border-gray-300 px-4 py-2
                     text-sm font-medium text-gray-700
                     hover:bg-gray-100
                     dark:border-gray-700 dark:text-gray-300
                     dark:hover:bg-white/[0.05] transition">
                            <i class="fa-solid fa-plus"></i>
                            Add Partner
                        </a>
                    </div>

                    <!-- Table -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                   bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6">

                        <div class="max-w-full overflow-x-auto">
                            <table id="partnerTable" class="min-w-full">

                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Logo
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Partner
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Status
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Order
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Aksi
                                            </p>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                                    <?php if (empty($partners)): ?>
                                        <tr>
                                            <td colspan="5"
                                                class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">
                                                Belum ada data partner
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($partners as $partner): ?>
                                            <tr>

                                                <!-- LOGO -->
                                                <td class="px-5 py-4 sm:px-6">
                                                    <div class="w-10 h-10 overflow-hidden rounded-full
                                      border border-gray-200
                                      dark:border-gray-800">
                                                        <img
                                                            src="uploads/partners/<?= $partner['logo'] ?: 'default.png'; ?>"
                                                            alt="<?= htmlspecialchars($partner['name']); ?>"
                                                            class="h-full w-full object-contain">
                                                    </div>
                                                </td>

                                                <!-- NAME -->
                                                <td class="px-5 py-4 sm:px-6">
                                                    <span
                                                        class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                        <?= htmlspecialchars($partner['name']); ?>
                                                    </span>
                                                </td>

                                                <!-- STATUS -->
                                                <td class="px-5 py-4 sm:px-6">
                                                    <?php if ($partner['is_active']): ?>
                                                        <span
                                                            class="rounded-full bg-success-50 px-2 py-0.5
                                     text-theme-xs font-medium text-success-700
                                     dark:bg-success-500/15 dark:text-success-500">
                                                            Active
                                                        </span>
                                                    <?php else: ?>
                                                        <span
                                                            class="rounded-full bg-error-50 px-2 py-0.5
                                     text-theme-xs font-medium text-error-700
                                     dark:bg-error-500/15 dark:text-error-500">
                                                            Inactive
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <!-- SORT ORDER -->
                                                <td class="px-5 py-4 sm:px-6">
                                                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                        <?= (int)$partner['sort_order']; ?>
                                                    </span>
                                                </td>

                                                <!-- ACTION -->
                                                <td class="px-5 py-4 sm:px-6">
                                                    <div class="flex items-center gap-2">

                                                        <a href="partner-edit.php?id=<?= $partner['id']; ?>"
                                                            class="inline-flex items-center gap-1 rounded-lg
                                     border border-warning-500/20
                                     bg-warning-500/10 px-3 py-1.5
                                     text-theme-xs font-medium text-warning-600
                                     hover:bg-warning-500/20 transition">
                                                            <i class="fa-solid fa-pen"></i>
                                                            Edit
                                                        </a>

                                                        <a href="partner-delete.php?id=<?= $partner['id']; ?>"
                                                            onclick="return confirm('Yakin mau menghapus partner ini?')"
                                                            class="inline-flex items-center gap-1 rounded-lg
                                     border border-error-500/20
                                     bg-error-500/10 px-3 py-1.5
                                     text-theme-xs font-medium text-error-600
                                     hover:bg-error-500/20 transition">
                                                            <i class="fa-solid fa-trash"></i>
                                                            Delete
                                                        </a>

                                                    </div>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#partnerTable').DataTable({
                pageLength: 10,
                searching: true,
                ordering: true,
                lengthChange: false,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: [0, 4]
                }],
                language: {
                    search: "Cari:",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
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