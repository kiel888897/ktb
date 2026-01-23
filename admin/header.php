<?php
require_once 'auth.php';

// ambil dari kontrak session yang BENAR
$userName = $_SESSION['user']['name'] ?? 'User';
$userRole = $_SESSION['user']['role'] ?? '-';
$userInitial = strtoupper(substr($userName, 0, 1));
?>
<!-- ===== Header Start ===== -->
<header
    x-data="{menuToggle: false}"
    class="sticky top-0 z-99999 flex w-full border-gray-200 bg-white lg:border-b dark:border-gray-800 dark:bg-gray-900">

    <div class="flex grow flex-col items-center justify-between lg:flex-row lg:px-6">

        <!-- LEFT -->
        <div class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 lg:border-b-0 dark:border-gray-800">

            <!-- Sidebar Toggle -->
            <button
                class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                @click.stop="sidebarToggle = !sidebarToggle">
                <i class="fa-solid fa-bars"></i>
            </button>

            <a href="index.php" class="lg:hidden font-semibold text-gray-800 dark:text-white">
                Admin Panel
            </a>

            <!-- Mobile Menu -->
            <button
                class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 lg:hidden dark:text-gray-400 dark:hover:bg-gray-800"
                @click.stop="menuToggle = !menuToggle">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
        </div>

        <!-- RIGHT -->
        <div
            :class="menuToggle ? 'flex' : 'hidden'"
            class="w-full items-center justify-end gap-4 px-5 py-4 lg:flex lg:px-0">

            <!-- Dark Mode -->
            <button
                class="flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 dark:border-gray-800"
                @click.prevent="darkMode = !darkMode">
                <i class="fa-solid fa-moon dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:block"></i>
            </button>

            <!-- User -->
            <div
                class="relative"
                x-data="{open:false}"
                @click.outside="open=false">

                <a href="#"
                    class="flex items-center gap-2"
                    @click.prevent="open=!open">

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-500 text-white font-semibold">
                        <?= $userInitial ?>
                    </div>

                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        <?= htmlspecialchars($userName) ?>
                    </span>

                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </a>

                <!-- Dropdown -->
                <div
                    x-show="open"
                    class="absolute right-0 mt-3 w-56 rounded-xl border border-gray-200 bg-white p-3 shadow-lg dark:border-gray-800 dark:bg-gray-900">

                    <div class="mb-3">
                        <div class="font-medium text-gray-800 dark:text-white">
                            <?= htmlspecialchars($userName) ?>
                        </div>
                        <div class="text-xs text-gray-500">
                            <?= htmlspecialchars($userRole) ?>
                        </div>
                    </div>

                    <a href="profile.php"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/5">
                        <i class="fa-solid fa-user"></i> Profile
                    </a>

                    <a href="logout.php"
                        class="mt-2 flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ===== Header End ===== -->