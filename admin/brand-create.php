<?php
require 'config/database.php'; // aman walau belum dipakai, untuk konsistensi
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Brand | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body
    x-data="{ page: 'brands', loaded: true, darkMode: false, sidebarToggle: false }"
    x-init="
    darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', val => localStorage.setItem('darkMode', JSON.stringify(val)))
  "
    :class="{'dark bg-gray-900': darkMode}">

    <!-- Preloader -->
    <div
        x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => setTimeout(() => loaded = false, 500))"
        class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-black">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
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
                                Add Brand
                            </h2>
                            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                                Tambahkan brand baru untuk produk.
                            </p>
                        </div>

                        <a href="brand.php"
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
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="p-5 sm:p-6">

                            <form action="brand-store.php" method="POST" enctype="multipart/form-data"
                                class="grid grid-cols-1 gap-6">

                                <!-- Name -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Nama Brand <span class="text-red-500">*</span>
                                    </label>
                                    <input id="brandName" name="name" type="text" required
                                        placeholder="Contoh: Samsung"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                           text-gray-800 outline-none focus:border-brand-500
                           dark:border-gray-700 dark:text-white/90" />
                                    <p class="mt-2 text-gray-500 text-theme-xs dark:text-gray-400">
                                        Nama akan dipakai di listing dan detail produk.
                                    </p>
                                </div>

                                <!-- Slug -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Slug <span class="text-red-500">*</span>
                                    </label>
                                    <input id="brandSlug" name="slug" type="text" required
                                        placeholder="contoh: samsung"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                           text-gray-800 outline-none focus:border-brand-500
                           dark:border-gray-700 dark:text-white/90" />
                                    <p class="mt-2 text-gray-500 text-theme-xs dark:text-gray-400">
                                        Otomatis dari nama, bisa kamu edit manual.
                                    </p>
                                </div>

                                <!-- Logo -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Logo (PNG / JPG / WebP)
                                    </label>

                                    <div class="flex items-center gap-4">

                                        <!-- Preview -->
                                        <div
                                            class="h-14 w-14 overflow-hidden rounded-full
             border border-gray-200 bg-white
             dark:border-gray-800 dark:bg-white/[0.03]">
                                            <img id="logoPreview"
                                                src="uploads/brands/default.png"
                                                alt="Preview"
                                                class="h-full w-full object-contain">
                                        </div>

                                        <!-- Upload Control -->
                                        <div class="flex-1">
                                            <!-- Hidden input -->
                                            <input
                                                id="brandLogo"
                                                name="logo"
                                                type="file"
                                                accept="image/*"
                                                class="hidden">

                                            <!-- Fake input -->
                                            <label
                                                for="brandLogo"
                                                class="inline-flex items-center gap-2
               rounded-lg border border-gray-300
               bg-white px-4 py-2
               text-sm font-medium text-gray-700
               cursor-pointer
               hover:bg-gray-100
               dark:border-gray-700 dark:bg-white/[0.03]
               dark:text-gray-300 dark:hover:bg-white/[0.06]
               transition">
                                                <i class="fa-solid fa-upload"></i>
                                                Choose file
                                            </label>

                                            <span id="fileName"
                                                class="ml-3 text-theme-xs text-gray-500 dark:text-gray-400">
                                                No file chosen
                                            </span>

                                            <p class="mt-2 text-theme-xs text-gray-500 dark:text-gray-400">
                                                Kosongkan jika belum ada logo (akan pakai default).
                                            </p>
                                        </div>

                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <a href="brand.php"
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
                                        Save Brand
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
    <script>
        /* ===============================
         * SLUG GENERATOR
         * =============================== */
        function slugify(text) {
            return text
                .toString()
                .trim()
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // remove non-word
                .replace(/\s+/g, '-') // spaces to -
                .replace(/-+/g, '-') // collapse -
                .replace(/^-+|-+$/g, ''); // trim -
        }

        const nameEl = document.getElementById('brandName');
        const slugEl = document.getElementById('brandSlug');
        const logoEl = document.getElementById('brandLogo');
        const previewEl = document.getElementById('logoPreview');
        const fileNameEl = document.getElementById('fileName');

        let slugTouched = false;
        let previewUrl = null;

        if (slugEl) {
            slugEl.addEventListener('input', () => {
                slugTouched = true;
            });
        }

        if (nameEl && slugEl) {
            nameEl.addEventListener('input', () => {
                if (!slugTouched) {
                    slugEl.value = slugify(nameEl.value);
                }
            });
        }

        /* ===============================
         * LOGO UPLOAD PREVIEW
         * =============================== */
        if (logoEl) {
            logoEl.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];

                // Reset jika batal pilih file
                if (!file) {
                    if (fileNameEl) fileNameEl.textContent = 'No file chosen';
                    return;
                }

                // Tampilkan nama file
                if (fileNameEl) {
                    fileNameEl.textContent = file.name;
                }

                // Cleanup preview lama
                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                }

                // Preview baru
                previewUrl = URL.createObjectURL(file);
                previewEl.src = previewUrl;
            });
        }
    </script>


</body>

</html>