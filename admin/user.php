<?php
require 'auth.php';
require_role(['superadmin']);
require 'config/database.php';


// Ambil data users
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users | Kusuma Trisna Bali</title>

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
    x-data="{ page: 'user', loaded: true, darkMode: false, sidebarToggle: false }"
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
                            Users
                        </h2>

                        <a href="user-create.php"
                            class="inline-flex items-center gap-2 rounded-lg
                     border border-gray-300 px-4 py-2
                     text-sm font-medium text-gray-700
                     hover:bg-gray-100
                     dark:border-gray-700 dark:text-gray-300
                     dark:hover:bg-white/[0.05] transition">
                            <i class="fa-solid fa-plus"></i>
                            Add User
                        </a>
                    </div>

                    <!-- Table -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                   bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6">

                        <div class="max-w-full overflow-x-auto">
                            <table id="userTable" class="min-w-full">

                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Name
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Email
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Role
                                            </p>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                Status
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
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="5"
                                                class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">
                                                Belum ada data user
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td class="px-5 py-4 sm:px-6">
                                                    <span
                                                        class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                        <?= htmlspecialchars($user['name']); ?>
                                                    </span>
                                                </td>

                                                <td class="px-5 py-4 sm:px-6">
                                                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                        <?= htmlspecialchars($user['email']); ?>
                                                    </span>
                                                </td>

                                                <td class="px-5 py-4 sm:px-6">
                                                    <span
                                                        class="inline-flex rounded-full
                                       bg-gray-100 px-2 py-0.5
                                       text-theme-xs font-medium text-gray-700
                                       dark:bg-gray-800 dark:text-gray-300">
                                                        <?= htmlspecialchars($user['role']); ?>
                                                    </span>
                                                </td>

                                                <td class="px-5 py-4 sm:px-6">
                                                    <?php if ($user['is_active']): ?>
                                                        <span
                                                            class="inline-flex rounded-full
                                       bg-green-100 px-2 py-0.5
                                       text-theme-xs font-medium text-green-600
                                       dark:bg-green-900/30 dark:text-green-400">
                                                            Active
                                                        </span>
                                                    <?php else: ?>
                                                        <span
                                                            class="inline-flex rounded-full
                                       bg-red-100 px-2 py-0.5
                                       text-theme-xs font-medium text-red-600
                                       dark:bg-red-900/30 dark:text-red-400">
                                                            Inactive
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="px-5 py-4 sm:px-6">
                                                    <div class="flex items-center gap-2">

                                                        <!-- EDIT -->
                                                        <a href="user-edit.php?id=<?= $user['id']; ?>"
                                                            class="inline-flex items-center gap-1 rounded-lg
                                     border border-warning-500/20
                                     bg-warning-500/10 px-3 py-1.5
                                     text-theme-xs font-medium text-warning-600
                                     hover:bg-warning-500/20 transition">
                                                            <i class="fa-solid fa-pen"></i>
                                                            Edit
                                                        </a>

                                                        <!-- DELETE -->
                                                        <a href="user-delete.php?id=<?= $user['id']; ?>"
                                                            onclick="return confirm('Yakin mau menghapus user ini?')"
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
            $('#userTable').DataTable({
                pageLength: 10,
                searching: true,
                ordering: true,
                lengthChange: false,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: [4]
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