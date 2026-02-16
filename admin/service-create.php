<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

/* ===============================
   GENERATE SERVICE CODE OTOMATIS
=================================*/
function generateServiceCode($pdo)
{
    $date = date('Ymd');
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE DATE(created_at) = CURDATE()");
    $stmt->execute();
    $count = $stmt->fetchColumn() + 1;

    return 'SRV-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
}

/* ===============================
   PROSES SIMPAN
=================================*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $service_code = $_POST['service_code'];
    $customer_name = $_POST['customer_name'];
    $whatsapp = $_POST['whatsapp'];
    $product_name = $_POST['product_name'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("
        INSERT INTO services 
        (service_code, customer_name, whatsapp, product_name, status)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $service_code,
        $customer_name,
        $whatsapp,
        $product_name,
        $status
    ]);

    header("Location: service.php");
    exit;
}

/* ===============================
   AMBIL DATA PRODUK UNTUK SUGEST
=================================*/
$stmt = $pdo->query("SELECT name FROM products ORDER BY name ASC");
$products = $stmt->fetchAll(PDO::FETCH_COLUMN);

$autoCode = generateServiceCode($pdo);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Service | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

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
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                                Add Service
                            </h2>
                            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                                Tambahkan service baru beserta detailnya.
                            </p>
                        </div>

                        <a href="service.php"
                            class="inline-flex items-center gap-2 rounded-lg
                                   border border-gray-300 px-4 py-2
                                   text-sm font-medium text-gray-700
                                   hover:bg-gray-100
                                   dark:border-gray-700 dark:text-gray-300
                                   dark:hover:bg-white/[0.05] transition">
                            <i class="fa-solid fa-arrow-left"></i>
                            Back
                        </a>
                    </div>

                    <!-- Card -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                               bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="p-5 sm:p-6">

                            <form method="POST" class="grid grid-cols-1 gap-6 max-w-3xl">

                                <!-- Service Code -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Service Code *
                                    </label>

                                    <input name="service_code" type="text" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                   text-gray-800 outline-none focus:border-brand-500
                   dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Customer Name -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Nama Customer *
                                    </label>
                                    <input name="customer_name" type="text" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                   text-gray-800 outline-none focus:border-brand-500
                   dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Whatsapp -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Whatsapp
                                    </label>
                                    <input name="whatsapp" type="number"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                   text-gray-800 outline-none focus:border-brand-500
                   dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Product Name (Sugest + Manual) -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Produk *
                                    </label>

                                    <input list="productList" name="product_name" required
                                        placeholder="Ketik atau pilih produk..."
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                   text-gray-800 outline-none focus:border-brand-500
                   dark:border-gray-700 dark:text-white/90" />

                                    <datalist id="productList">
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= htmlspecialchars($product); ?>">
                                            <?php endforeach; ?>
                                    </datalist>

                                    <p class="text-xs text-gray-500 mt-1">
                                        Jika produk tidak ada dalam daftar, silakan ketik manual.
                                    </p>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Status
                                    </label>
                                    <select name="status"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                   text-gray-800 outline-none focus:border-brand-500
                   dark:border-gray-700 dark:text-white/90">

                                        <option value="barang diterima">Barang Diterima</option>
                                        <option value="checking/diagnose">Checking / Diagnose</option>
                                        <option value="on progress">On Progress</option>
                                        <option value="pending part">Pending Part</option>
                                        <option value="pending customer">Pending Customer</option>
                                        <option value="done">Done</option>
                                        <option value="cancel">Cancel</option>
                                    </select>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <a href="service.php"
                                        class="inline-flex items-center gap-2 rounded-lg
                   border border-gray-300 px-4 py-2
                   text-sm font-medium text-gray-700
                   hover:bg-gray-100
                   dark:border-gray-700 dark:text-gray-300
                   dark:hover:bg-white/[0.05] transition">
                                        Cancel
                                    </a>

                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg
                   bg-brand-500 px-4 py-2
                   text-sm font-medium text-white
                   hover:bg-brand-600 transition">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Save Service
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script defer src="bundle.js"></script>


</body>

</html>