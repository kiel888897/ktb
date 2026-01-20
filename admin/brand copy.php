<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>
    Admin Dashboard | Kusuma Trisna Bali
  </title>
  <link rel="icon" href="favicon.ico">
  <link href="style.css" rel="stylesheet">
</head>

<body
  x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
  x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'dark bg-gray-900': darkMode === true}">
  <!-- ===== Preloader Start ===== -->
  <div
    x-show="loaded"
    x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
    class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
    <div
      class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
  </div>

  <!-- ===== Preloader End ===== -->

  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <!-- ===== Sidebar Start ===== -->
    <?php include 'sidebar.php'; ?>

    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div
      class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
      <!-- Small Device Overlay Start -->
      <div
        @click="sidebarToggle = false"
        :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
        class="fixed w-full h-screen z-9 bg-gray-900/50"></div>
      <!-- Small Device Overlay End -->

      <!-- header here  -->
      <?php include 'header.php'; ?>

      <!-- ===== Main Content Start ===== -->
      <main>
        <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
          <!-- Breadcrumb Start -->
          <div x-data="{ pageName: `Brands`}">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
              <h2
                class="text-xl font-semibold text-gray-800 dark:text-white/90"
                x-text="pageName"></h2>

              <nav>
                <ol class="flex items-center gap-1.5">
                  <li>
                    <a
                      class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                      href="index.html">
                      Home
                      <svg
                        class="stroke-current"
                        width="17"
                        height="16"
                        viewBox="0 0 17 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                          stroke=""
                          stroke-width="1.2"
                          stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </a>
                  </li>
                  <li
                    class="text-sm text-gray-800 dark:text-white/90"
                    x-text="pageName"></li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- Breadcrumb End -->

          <div class="space-y-5 sm:space-y-6">
            <div
              class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
              <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3
                  class="text-base font-medium text-gray-800 dark:text-white/90">
                  Brands
                </h3>
              </div>
              <div
                class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <!-- ====== Table Six Start -->
                <div
                  class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                  <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                      <!-- table header start -->
                      <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                          <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Name
                              </p>
                            </div>
                          </th>
                          <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Logo
                              </p>
                            </div>
                          </th>
                          <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Team
                              </p>
                            </div>
                          </th>
                          <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Status
                              </p>
                            </div>
                          </th>
                          <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Budget
                              </p>
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <!-- table header end -->
                      <!-- table body start -->
                      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                  <img src="src/images/user/user-17.jpg" alt="brand" />
                                </div>

                                <div>
                                  <span
                                    class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    Lindsey Curtis
                                  </span>
                                  <span
                                    class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                    Web Designer
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                Agency Website
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex -space-x-2">
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-22.jpg" alt="user" />
                                </div>
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-23.jpg" alt="user" />
                                </div>
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-24.jpg" alt="user" />
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                Active
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">3.9K</p>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                  <img src="src/images/user/user-18.jpg" alt="brand" />
                                </div>

                                <div>
                                  <span
                                    class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    Kaiya George
                                  </span>
                                  <span
                                    class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                    Project Manager
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                Technology
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex -space-x-2">
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-25.jpg" alt="user" />
                                </div>
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-26.jpg" alt="user" />
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-400">
                                Pending
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                24.9K
                              </p>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                  <img src="src/images/user/user-19.jpg" alt="brand" />
                                </div>

                                <div>
                                  <span
                                    class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    Zain Geidt
                                  </span>
                                  <span
                                    class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                    Content Writer
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                Blog Writing
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex -space-x-2">
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-27.jpg" alt="user" />
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                Active
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                12.7K
                              </p>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                  <img src="src/images/user/user-20.jpg" alt="brand" />
                                </div>

                                <div>
                                  <span
                                    class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    Abram Schleifer
                                  </span>
                                  <span
                                    class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                    Digital Marketer
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                Social Media
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex -space-x-2">
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-28.jpg" alt="user" />
                                </div>
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-29.jpg" alt="user" />
                                </div>
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-30.jpg" alt="user" />
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-700 dark:bg-error-500/15 dark:text-error-500">
                                Cancel
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">2.8K</p>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div class="w-10 h-10 overflow-hidden rounded-full">
                                  <img src="src/images/user/user-21.jpg" alt="brand" />
                                </div>

                                <div>
                                  <span
                                    class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    Carla George
                                  </span>
                                  <span
                                    class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                    Front-end Developer
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                Website
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <div class="flex -space-x-2">
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-31.jpg" alt="user" />
                                </div>
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-32.jpg" alt="user" />
                                </div>
                                <div
                                  class="w-6 h-6 overflow-hidden border-2 border-white rounded-full dark:border-gray-900">
                                  <img src="src/images/user/user-33.jpg" alt="user" />
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p
                                class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                Active
                              </p>
                            </div>
                          </td>
                          <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center">
                              <p class="text-gray-500 text-theme-sm dark:text-gray-400">4,5K</p>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- ====== Table Six End -->
              </div>
            </div>
          </div>
        </div>
      </main>
      <!-- ===== Main Content End ===== -->
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  <!-- ===== Page Wrapper End ===== -->
  <script defer src="bundle.js"></script>
</body>

</html>