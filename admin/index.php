<?php
require 'auth.php';
require 'config/database.php';

// Hitung total users
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$totalUsers = $stmt->fetchColumn();

// Hitung total products
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$totalProducts = $stmt->fetchColumn();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Admin Dashboard | Kusuma Trisna Bali</title>
  <link rel="icon" href="favicon.ico">
  <link href="style.css" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body
  x-data="{ page: 'ecommerce', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
  x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'dark bg-gray-900': darkMode === true}">

  <!-- Preloader -->
  <div
    x-show="loaded"
    x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
    class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
    <div
      class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
  </div>

  <div class="flex h-screen overflow-hidden">

    <?php include 'sidebar.php'; ?>

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

      <div
        @click="sidebarToggle = false"
        :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
        class="fixed w-full h-screen z-9 bg-gray-900/50"></div>

      <?php include 'header.php'; ?>

      <main>
        <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
          <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12 space-y-6 xl:col-span-7">

              <!-- Metric Group -->
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">

                <!-- USERS -->
                <div
                  class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                  <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                    <i class="fa-solid fa-users text-xl text-gray-800 dark:text-white/90"></i>
                  </div>


                  <div class="mt-5 flex items-end justify-between">
                    <div>
                      <span class="text-sm text-gray-500 dark:text-gray-400">Users</span>
                      <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                        <?= number_format($totalUsers); ?>
                      </h4>
                    </div>
                  </div>
                </div>

                <!-- PRODUCTS -->
                <div
                  class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                  <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                    <i class="fa-solid fa-box text-xl text-gray-800 dark:text-white/90"></i>
                  </div>


                  <div class="mt-5 flex items-end justify-between">
                    <div>
                      <span class="text-sm text-gray-500 dark:text-gray-400">Product</span>
                      <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                        <?= number_format($totalProducts); ?>
                      </h4>
                    </div>
                  </div>
                </div>

              </div>
              <!-- Metric Group End -->

            </div>
          </div>
        </div>
      </main>

    </div>
  </div>

  <script defer src="bundle.js"></script>
</body>

</html>