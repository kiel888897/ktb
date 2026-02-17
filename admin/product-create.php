<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

$brands = $pdo->query("SELECT id, name FROM brands ORDER BY name")->fetchAll();
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
$subcategories = $pdo->query("SELECT id, name FROM subcategories ORDER BY name")->fetchAll();
$partners = $pdo->query("SELECT id, name FROM partners WHERE is_active = 1 ORDER BY sort_order, name")->fetchAll();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

</head>

<body
    x-data="{ page: 'product', loaded: true, darkMode: false, sidebarToggle: false }"
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
                                Add Product
                            </h2>
                            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                                Tambahkan produk baru beserta detailnya.
                            </p>
                        </div>

                        <a href="product.php"
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

                            <form action="product-store.php" method="POST" enctype="multipart/form-data"
                                class="grid grid-cols-1 gap-6 max-w-3xl">

                                <!-- Product Name -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Product Name <span class="text-red-500">*</span>
                                    </label>
                                    <input id="productName" name="name" type="text" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Slug -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Slug <span class="text-red-500">*</span>
                                    </label>
                                    <input id="productSlug" name="slug" type="text" required
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Tagline -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Tagline
                                    </label>
                                    <input name="tagline" type="text"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Brand / Category / Subcategory -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                    <div>
                                        <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                            Brand <span class="text-red-500">*</span>
                                        </label>
                                        <select name="brand_id" required
                                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                                   text-gray-800 outline-none focus:border-brand-500
                                                   dark:border-gray-700 dark:text-white/90">
                                            <option value="">-- Select Brand --</option>
                                            <?php foreach ($brands as $b): ?>
                                                <option value="<?= $b['id']; ?>"><?= htmlspecialchars($b['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category_id" required
                                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                                   text-gray-800 outline-none focus:border-brand-500
                                                   dark:border-gray-700 dark:text-white/90">
                                            <option value="">-- Select Category --</option>
                                            <?php foreach ($categories as $c): ?>
                                                <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                            Subcategory <span class="text-red-500">*</span>
                                        </label>
                                        <select name="subcategory_id" required
                                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                                   text-gray-800 outline-none focus:border-brand-500
                                                   dark:border-gray-700 dark:text-white/90">
                                            <option value="">-- Select Subcategory --</option>
                                            <?php foreach ($subcategories as $s): ?>
                                                <option value="<?= $s['id']; ?>"><?= htmlspecialchars($s['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>

                                <!-- Partner -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Partner
                                    </label>
                                    <select name="partner_id"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">
                                        <option value="">-- Optional --</option>
                                        <?php foreach ($partners as $p): ?>
                                            <option value="<?= $p['id']; ?>"><?= htmlspecialchars($p['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Price -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Price
                                    </label>
                                    <input name="price" type="number" step="0.01"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Stock
                                    </label>
                                    <input name="stock" type="number" min="0"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>

                                <!-- Model -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Model
                                    </label>
                                    <input name="model" type="text"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90" />
                                </div>
                                <!-- Short Description -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Short Description
                                    </label>

                                    <div class="quill-wrapper">
                                        <div id="shortEditor"></div>
                                    </div>

                                    <input type="hidden" name="short_description" id="shortInput">
                                </div>


                                <!-- Full Description -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Full Description
                                    </label>

                                    <div class="quill-wrapper">
                                        <div id="fullEditor"></div>
                                    </div>

                                    <input type="hidden" name="description" id="fullInput">
                                </div>

                                <!-- specifications -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Spesifikasi Produk
                                    </label>

                                    <div class="quill-wrapper">
                                        <div id="specificationsEditor"></div>
                                    </div>

                                    <input type="hidden" name="specifications" id="specificationsInput">
                                </div>

                                <!-- Images -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Product Images
                                    </label>

                                    <input id="productImages" name="images[]" type="file" multiple accept="image/*" class="hidden">

                                    <label for="productImages"
                                        class="inline-flex items-center gap-2 rounded-lg
                                               border border-gray-300 bg-white px-4 py-2
                                               text-sm font-medium text-gray-700 cursor-pointer
                                               hover:bg-gray-100
                                               dark:border-gray-700 dark:bg-white/[0.03]
                                               dark:text-gray-300 dark:hover:bg-white/[0.06] transition">
                                        <i class="fa-solid fa-upload"></i>
                                        Choose files
                                    </label>

                                    <span id="fileName"
                                        class="ml-3 text-theme-xs text-gray-500 dark:text-gray-400">
                                        No file chosen
                                    </span>
                                </div>
                                <!-- Unggulan -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Unggulan
                                    </label>
                                    <select name="is_featured"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 text-theme-sm dark:text-gray-300">
                                        Status
                                    </label>
                                    <select name="is_active"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-end gap-3 pt-2">
                                    <a href="product.php"
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
                                        Save Product
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
        function slugify(text) {
            return text.toString().trim().toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        const nameEl = document.getElementById('productName');
        const slugEl = document.getElementById('productSlug');
        const imgInput = document.getElementById('productImages');
        const fileName = document.getElementById('fileName');

        let slugTouched = false;

        slugEl.addEventListener('input', () => slugTouched = true);
        nameEl.addEventListener('input', () => {
            if (!slugTouched) slugEl.value = slugify(nameEl.value);
        });

        imgInput.addEventListener('change', () => {
            fileName.textContent = imgInput.files.length ?
                `${imgInput.files.length} file(s) selected` :
                'No file chosen';
        });
    </script>
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <script>
        const specificationQuill = new Quill('#specificationsEditor', {
            theme: 'snow',
            placeholder: 'Product specifications...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{
                        list: 'bullet'
                    }],
                    ['link']
                ]
            }
        });

        const shortQuill = new Quill('#shortEditor', {
            theme: 'snow',
            placeholder: 'Short product description...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{
                        list: 'bullet'
                    }],
                    ['link']
                ]
            }
        });

        const fullQuill = new Quill('#fullEditor', {
            theme: 'snow',
            placeholder: 'Full product description...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        header: [1, 2, false]
                    }],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        const specificationInput = document.getElementById('specificationsInput');
        const shortInput = document.getElementById('shortInput');
        const fullInput = document.getElementById('fullInput');

        document.querySelector('form').addEventListener('submit', function() {
            specificationInput.value = specificationQuill.root.innerHTML;
            shortInput.value = shortQuill.root.innerHTML;
            fullInput.value = fullQuill.root.innerHTML;
        });
    </script>


</body>

</html>