<?php
require 'config/database.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Category | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body
    x-data="{ page: 'categories', loaded: true, darkMode: false, sidebarToggle: false }"
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
                                Add Category
                            </h2>
                            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                                Tambahkan kategori baru.
                            </p>
                        </div>

                        <a href="category.php"
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

                    <!-- Card Form -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                   bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="p-5 sm:p-6">

                            <form action="category-store.php" method="POST"
                                class="grid grid-cols-1 gap-6 max-w-xl">

                                <!-- Name -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Nama Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <input id="categoryName" name="name" type="text" required
                                        placeholder="Contoh: Audio Visual"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                           text-gray-800 outline-none focus:border-brand-500
                           dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Slug -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Slug <span class="text-red-500">*</span>
                                    </label>
                                    <input id="categorySlug" name="slug" type="text" required
                                        placeholder="audio-visual"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                           text-gray-800 outline-none focus:border-brand-500
                           dark:border-gray-700 dark:text-white/90" />
                                    <p class="mt-2 text-theme-xs text-gray-500 dark:text-gray-400">
                                        Otomatis dari nama, bisa diedit manual.
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <a href="category.php"
                                        class="inline-flex items-center gap-2 rounded-lg
                           border border-gray-300 px-4 py-2
                           text-sm font-medium text-gray-700
                           hover:bg-gray-100
                           dark:border-gray-700 dark:text-gray-300
                           dark:hover:bg-white/[0.05] transition">
                                        <i class="fa-solid fa-xmark"></i>
                                        Cancel
                                    </a>

                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg
                           bg-brand-500 px-4 py-2
                           text-sm font-medium text-white
                           hover:bg-brand-600 transition">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Save Category
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

    <!-- Slug Script -->
    <script>
        function slugify(text) {
            return text
                .toString()
                .trim()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        const nameEl = document.getElementById('categoryName');
        const slugEl = document.getElementById('categorySlug');

        let slugTouched = false;

        slugEl.addEventListener('input', () => {
            slugTouched = true;
        });

        nameEl.addEventListener('input', () => {
            if (!slugTouched) {
                slugEl.value = slugify(nameEl.value);
            }
        });
    </script>
</body>

</html>