<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

/* ===============================
   VALIDASI ID
=================================*/
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: service.php");
    exit;
}

$id = (int) $_GET['id'];

/* ===============================
   AMBIL DATA SERVICE
=================================*/
$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    header("Location: service.php");
    exit;
}

/* ===============================
   PROSES UPDATE
=================================*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customer_name = $_POST['customer_name'];
    $whatsapp = $_POST['whatsapp'];
    $product_name = $_POST['product_name'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("
        UPDATE services SET
            customer_name = ?,
            whatsapp = ?,
            product_name = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $customer_name,
        $whatsapp,
        $product_name,
        $status,
        $id
    ]);

    header("Location: service.php");
    exit;
}

/* ===============================
   AMBIL DATA PRODUK UNTUK SUGEST
=================================*/
$stmt = $pdo->query("SELECT name FROM products ORDER BY name ASC");
$products = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body
    x-data="{ page: 'service', loaded: true, darkMode: false, sidebarToggle: false }"
    x-init="
        darkMode = JSON.parse(localStorage.getItem('darkMode'));
        $watch('darkMode', v => localStorage.setItem('darkMode', JSON.stringify(v)))
    "
    :class="{'dark bg-gray-900': darkMode}">

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
                                Edit Service
                            </h2>
                            <p class="mt-1 text-gray-500 text-sm dark:text-gray-400">
                                Update data service.
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

                    <!-- Form Card -->
                    <div class="overflow-hidden rounded-xl border border-gray-200
                                bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="p-5 sm:p-6">

                            <form method="POST" class="grid grid-cols-1 gap-6 max-w-3xl">

                                <!-- Service Code (Readonly) -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Service Code
                                    </label>
                                    <input type="text"
                                        value="<?= htmlspecialchars($service['service_code']); ?>"
                                        readonly
                                        class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5
                                               text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90" />
                                </div>

                                <!-- Customer Name -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Nama Customer
                                    </label>
                                    <input name="customer_name" type="text" required
                                        value="<?= htmlspecialchars($service['customer_name']); ?>"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Whatsapp -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Whatsapp
                                    </label>
                                    <input name="whatsapp" type="text" required
                                        value="<?= htmlspecialchars($service['whatsapp']); ?>"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Product -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Produk
                                    </label>

                                    <input list="productList" name="product_name" required
                                        value="<?= htmlspecialchars($service['product_name']); ?>"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />

                                    <datalist id="productList">
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= htmlspecialchars($product); ?>">
                                            <?php endforeach; ?>
                                    </datalist>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Status
                                    </label>

                                    <select name="status"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">

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

                                        foreach ($statuses as $status) :
                                        ?>
                                            <option value="<?= $status ?>"
                                                <?= $service['status'] === $status ? 'selected' : '' ?>>
                                                <?= ucfirst($status) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <a href="service.php"
                                        class="inline-flex items-center gap-2 rounded-lg
                                               border border-gray-300 px-4 py-2
                                               text-sm font-medium text-gray-700
                                               hover:bg-gray-100
                                               dark:border-gray-700 dark:text-gray-300">
                                        Cancel
                                    </a>

                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg
                                               bg-brand-500 px-4 py-2
                                               text-sm font-medium text-white
                                               hover:bg-brand-600 transition">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Update Service
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