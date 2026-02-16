<?php
require 'auth.php';
require_role(['superadmin']); // ⬅️ WAJIB
require 'config/database.php';

$stmt = $pdo->query("SELECT profit FROM company LIMIT 1");
$company = $stmt->fetch();
$profit = $company ? $company['profit'] : 0;

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit | Kusuma Trisna Bali</title>

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
    x-data="{ page: 'profit', loaded: true, darkMode: false, sidebarToggle: false }"
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
                            Profit
                        </h2>

                    </div>

                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                   bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4 sm:p-6">

                        <div class="max-w-full overflow-x-auto">
                            <!-- kontent profit  -->

                            <div class="flex items-center justify-center gap-4 py-10">

                                <button onclick="updateProfit(-1)"
                                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-lg">
                                    <i class="fa fa-minus"></i>
                                </button>

                                <div class="text-4xl font-bold flex items-center gap-2">

                                    <input type="number"
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        id="profitInput"
                                        value="<?= number_format($profit, 2, '.', ''); ?>"
                                        class="w-28 text-center bg-transparent border-b border-gray-400 focus:outline-none">

                                    <span>%</span>

                                </div>


                                <button onclick="updateProfit(1)"
                                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-lg">
                                    <i class="fa fa-plus"></i>
                                </button>

                            </div>

                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script defer src="bundle.js"></script>
    <script>
        const profitInput = document.getElementById('profitInput');

        profitInput.addEventListener('change', function() {
            saveProfit(this.value);
        });

        function updateProfit(change) {
            let current = parseFloat(profitInput.value);
            let newValue = current + change;

            if (newValue < 0) newValue = 0;
            if (newValue > 100) newValue = 100;

            profitInput.value = newValue.toFixed(2);
            saveProfit(newValue);
        }

        function saveProfit(value) {

            fetch('update-profit.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'set=' + value
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert('Gagal update profit');
                    }
                });
        }
    </script>


</body>

</html>