<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'auth.php';
require_role(['admin', 'staff', 'superadmin']);
require 'config/database.php';
$sql = "SELECT * FROM services ORDER BY created_at DESC";

$stmt = $pdo->query($sql);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
</head>

<body
    x-data="{ page: 'service', loaded: true, darkMode: false, sidebarToggle: false }"
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
                            Services
                        </h2>

                        <a href="service-create.php"
                            class="inline-flex items-center gap-2 rounded-lg
                            border border-gray-300 px-4 py-2
                            text-sm font-medium text-gray-700
                            hover:bg-gray-100
                            dark:border-gray-700 dark:text-gray-300
                            dark:hover:bg-white/[0.05] transition">
                            <i class="fa-solid fa-plus"></i>
                            Add Service
                        </a>
                    </div>

                    <!-- Table -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                        bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6">

                        <div class="max-w-full overflow-x-auto">
                            <table id="serviceTable" class="min-w-full">

                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800 text-left">
                                        <th class="px-5 py-3">Tanggal</th>
                                        <th class="px-5 py-3">Service Code</th>
                                        <th class="px-5 py-3">Customer</th>
                                        <th class="px-5 py-3">Product</th>
                                        <th class="px-5 py-3">Status</th>
                                        <th class="px-5 py-3">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <?php foreach ($services as $s): ?>
                                        <tr>

                                            <!-- Date -->
                                            <td class="px-5 py-4">
                                                <?= date('d M Y', strtotime($s['created_at'])); ?>
                                            </td>
                                            <!-- Service Code -->
                                            <td class="px-5 py-4">
                                                <p class="font-medium text-gray-800 dark:text-white/90">
                                                    <?= htmlspecialchars($s['service_code']); ?>
                                                </p>
                                            </td>

                                            <!-- Customer -->
                                            <td class="px-5 py-4">
                                                <p class="font-medium text-gray-800 dark:text-white/90">
                                                    <?= htmlspecialchars($s['customer_name']); ?>
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    <?= htmlspecialchars($s['whatsapp']); ?>
                                                </p>
                                            </td>

                                            <!-- Product -->
                                            <td class="px-5 py-4">
                                                <?= htmlspecialchars($s['product_db_name'] ?? $s['product_name']); ?>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-5 py-4">

                                                <select
                                                    onchange="updateStatus(<?= $s['id']; ?>, this)"
                                                    class="px-3 py-1 rounded-full text-xs font-medium border-none outline-none
        <?=
                                        match ($s['status']) {
                                            'done' => 'bg-green-100 text-green-700',
                                            'cancel' => 'bg-red-100 text-red-700',
                                            'on progress' => 'bg-yellow-100 text-yellow-700',
                                            'pending part' => 'bg-orange-100 text-orange-700',
                                            'pending customer' => 'bg-purple-100 text-purple-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
        ?>">

                                                    <?php
                                                    $statuses = [
                                                        'barang diterima',
                                                        'checking/diagnose',
                                                        'on progress',
                                                        'pending part',
                                                        'pending customer',
                                                        'done',
                                                        'cancel'
                                                    ];

                                                    foreach ($statuses as $status):
                                                    ?>
                                                        <option value="<?= $status ?>"
                                                            <?= $s['status'] === $status ? 'selected' : '' ?>>
                                                            <?= ucfirst($status) ?>
                                                        </option>
                                                    <?php endforeach; ?>

                                                </select>

                                            </td>


                                            <!-- Action -->
                                            <td class="px-5 py-4">
                                                <div class="flex gap-2">

                                                    <?php
                                                    $phone = preg_replace('/[^0-9]/', '', $s['whatsapp']);

                                                    // Jika nomor diawali 0 → ubah ke 62
                                                    if (substr($phone, 0, 1) == '0') {
                                                        $phone = '62' . substr($phone, 1);
                                                    }

                                                    $message = "Halo Bapak/Ibu {$s['customer_name']},\n\n"
                                                        . "Untuk produk {$s['product_name']}, saat ini status service: *{$s['status']}*.\n\n"
                                                        . "Terima kasih sudah mempercayakan service di Kusuma Trisna Bali 🙏";

                                                    $waLink = "https://wa.me/{$phone}?text=" . urlencode($message);
                                                    ?>

                                                    <!-- Info Customer (WA) -->
                                                    <a href="<?= $waLink; ?>" target="_blank"
                                                        class="inline-flex items-center gap-1 rounded-lg
            border border-green-500/20
            bg-green-500/10 px-3 py-1.5
            text-xs font-medium text-green-600
            hover:bg-green-500/20">
                                                        <i class="fa-brands fa-whatsapp"></i> Info
                                                    </a>

                                                    <!-- Delete -->
                                                    <a href="service-delete.php?id=<?= $s['id']; ?>"
                                                        onclick="return confirm('Yakin mau menghapus service ini?')"
                                                        class="inline-flex items-center gap-1 rounded-lg
            border border-red-500/20
            bg-red-500/10 px-3 py-1.5
            text-xs font-medium text-red-600
            hover:bg-red-500/20">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </a>

                                                </div>
                                            </td>

                                            <!-- Action -->
                                            <!-- <td class="px-5 py-4">
                                                <div class="flex gap-2">
                                                    <a href="service-edit.php?id=<?= $s['id']; ?>"
                                                        class="inline-flex items-center gap-1 rounded-lg
                                                        border border-yellow-500/20
                                                        bg-yellow-500/10 px-3 py-1.5
                                                        text-xs font-medium text-yellow-600
                                                        hover:bg-yellow-500/20">
                                                        <i class="fa-solid fa-pen"></i> Edit
                                                    </a>

                                                    <a href="service-delete.php?id=<?= $s['id']; ?>"
                                                        onclick="return confirm('Yakin mau menghapus service ini?')"
                                                        class="inline-flex items-center gap-1 rounded-lg
                                                        border border-red-500/20
                                                        bg-red-500/10 px-3 py-1.5
                                                        text-xs font-medium text-red-600
                                                        hover:bg-red-500/20">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </a>
                                                </div> -->
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
            $('#serviceTable').DataTable({
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
    <script>
        function updateStatus(id, element) {

            let status = element.value;

            fetch('service-update-status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + id + '&status=' + encodeURIComponent(status)
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        location.reload(); // refresh supaya warna update
                    } else {
                        alert('Gagal update status');
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan');
                });
        }
    </script>

</body>

</html>