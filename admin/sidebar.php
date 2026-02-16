<?php
$userRole = $_SESSION['user']['role'] ?? 'guest';
?>

<aside
    :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden
         border-r border-gray-200 bg-white px-5
         dark:border-gray-800 dark:bg-black
         lg:static lg:translate-x-0">

    <!-- HEADER -->
    <div
        :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="flex items-center gap-2 pt-8 pb-7">

        <a href="index.php">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="src/images/logo/logo.svg">
                <img class="hidden dark:block" src="src/images/logo/logo-dark.svg">
            </span>

            <img
                class="logo-icon"
                :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="src/images/logo/logo-icon.svg">
        </a>
    </div>

    <!-- MENU -->
    <div class="flex flex-col overflow-y-auto no-scrollbar">
        <nav x-data="{ selected: $persist('Dashboard') }">

            <!-- ===== MENU ===== -->
            <h3 class="mb-4 text-xs uppercase text-gray-400"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Menu
            </h3>

            <ul class="flex flex-col gap-4 mb-6">
                <?php if ($userRole !== 'seller'): ?>
                    <!-- Dashboard -->
                    <li>
                        <a href="index.php"
                            class="menu-item group"
                            :class="page === 'dashboard'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                            <i
                                :class="page === 'dashboard'
                ? 'fa-solid fa-gauge-high menu-item-icon-active'
                : 'fa-solid fa-gauge-high menu-item-icon-inactive'"
                                class="text-lg"></i>

                            <span class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''">
                                Dashboard
                            </span>
                        </a>
                    </li>

                    <!-- Products -->
                    <li>
                        <a href="product.php"
                            class="menu-item group"
                            :class="page === 'product'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                            <i
                                :class="page === 'product'
                ? 'fa-solid fa-boxes-stacked menu-item-icon-active'
                : 'fa-solid fa-boxes-stacked menu-item-icon-inactive'"
                                class="text-lg"></i>

                            <span class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''">
                                Products
                            </span>
                        </a>
                    </li>
                    <!-- service -->
                    <li>
                        <a href="service.php"
                            class="menu-item group"
                            :class="page === 'service'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                            <i
                                :class="page === 'service'
                ? 'fa-solid fa-tools menu-item-icon-active'
                : 'fa-solid fa-tools menu-item-icon-inactive'"
                                class="text-lg"></i>

                            <span class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''">
                                Services
                            </span>
                        </a>
                    </li>
                    <!-- Master Data -->
                    <li>
                        <a href="#"
                            @click.prevent="selected = (selected === 'master' ? '' : 'master')"
                            class="menu-item group"
                            :class="selected === 'master'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                            <i class="fa-solid fa-database text-lg"></i>

                            <span class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''">
                                Data Master
                            </span>
                        </a>

                        <div x-show="selected === 'master'" class="pl-9 mt-2 space-y-1">
                            <a href="brand.php"
                                class="menu-dropdown-item"
                                :class="page === 'brand' ? 'menu-dropdown-item-active' : ''">
                                Brand
                            </a>
                            <a href="category.php"
                                class="menu-dropdown-item"
                                :class="page === 'category' ? 'menu-dropdown-item-active' : ''">
                                Category
                            </a>
                            <a href="subcategory.php"
                                class="menu-dropdown-item"
                                :class="page === 'subcategory' ? 'menu-dropdown-item-active' : ''">
                                Subcategory
                            </a>
                        </div>
                    </li>

                    <!-- Partner -->
                    <li>
                        <a href="partner.php"
                            class="menu-item group"
                            :class="page === 'partner'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                            <i
                                :class="page === 'partner'
                ? 'fa-solid fa-handshake menu-item-icon-active'
                : 'fa-solid fa-handshake menu-item-icon-inactive'"
                                class="text-lg"></i>

                            <span class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''">
                                Partner
                            </span>
                        </a>
                    </li>

                    <!-- USERS (ADMIN ONLY) -->
                    <?php if ($userRole === 'superadmin'): ?>
                        <li>
                            <a href="profit.php"
                                class="menu-item group"
                                :class="page === 'profit'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                                <i
                                    :class="page === 'profit'
                ? 'fa-solid fa-money-bill-wave menu-item-icon-active'
                : 'fa-solid fa-money-bill-wave menu-item-icon-inactive'"
                                    class="text-lg"></i>

                                <span class="menu-item-text"
                                    :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Profit
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="user.php"
                                class="menu-item group"
                                :class="page === 'user'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                                <i
                                    :class="page === 'user'
                ? 'fa-solid fa-users-gear menu-item-icon-active'
                : 'fa-solid fa-users-gear menu-item-icon-inactive'"
                                    class="text-lg"></i>

                                <span class="menu-item-text"
                                    :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Users
                                </span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Seller -->
                <li>
                    <a href="seller.php"
                        class="menu-item group"
                        :class="page === 'seller'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                        <i
                            :class="page === 'seller'
                ? 'fa-solid fa-shop menu-item-icon-active'
                : 'fa-solid fa-shop menu-item-icon-inactive'"
                            class="text-lg"></i>

                        <span class="menu-item-text"
                            :class="sidebarToggle ? 'lg:hidden' : ''">
                            Seller
                        </span>
                    </a>
                </li>
            </ul>
            <!-- ===== OTHERS ===== -->
            <h3 class="mb-4 text-xs uppercase text-gray-400"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Others
            </h3>

            <ul class="flex flex-col gap-4">
                <?php if ($userRole !== 'seller'): ?>
                    <li>
                        <a href="profile.php"
                            class="menu-item group"
                            :class="page === 'profile'
               ? 'menu-item-active'
               : 'menu-item-inactive'">

                            <i class="fa-solid fa-user text-lg"></i>

                            <span class="menu-item-text"
                                :class="sidebarToggle ? 'lg:hidden' : ''">
                                Profile
                            </span>
                        </a>
                    </li>
                <?php endif; ?>

                <li>
                    <a href="logout.php"
                        class="menu-item group text-red-500 hover:bg-red-50">

                        <i class="fa-solid fa-right-from-bracket text-lg"></i>

                        <span class="menu-item-text"
                            :class="sidebarToggle ? 'lg:hidden' : ''">
                            Logout
                        </span>
                    </a>
                </li>
            </ul>

        </nav>
    </div>
</aside>