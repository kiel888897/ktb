<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

// ===== VALIDASI REQUEST =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: product.php');
    exit;
}

// ===== AMBIL & SANITASI INPUT =====
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$tagline = trim($_POST['tagline'] ?? '');
$model = trim($_POST['model'] ?? '');
$brand_id = (int)($_POST['brand_id'] ?? 0);
$category_id = (int)($_POST['category_id'] ?? 0);
$subcategory_id = (int)($_POST['subcategory_id'] ?? 0);
$partner_id = !empty($_POST['partner_id']) ? (int)$_POST['partner_id'] : null;
$price = ($_POST['price'] !== '' && isset($_POST['price'])) ? (float)$_POST['price'] : null;
$stock = ($_POST['stock'] !== '' && isset($_POST['stock'])) ? (int)$_POST['stock'] : null;
$short_description = trim($_POST['short_description'] ?? '');
$description = trim($_POST['description'] ?? '');
$specifications = trim($_POST['specifications'] ?? '');
$is_featured = isset($_POST['is_featured']) ? (int)$_POST['is_featured'] : 0;
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

// ===== VALIDASI WAJIB =====
if ($name === '' || $slug === '' || !$brand_id || !$category_id || !$subcategory_id) {
    header('Location: product-create.php');
    exit;
}

// ===== CEK SLUG UNIK =====
$stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE slug = ?");
$stmt->execute([$slug]);
if ($stmt->fetchColumn() > 0) {
    // slug bentrok
    header('Location: product-create.php?error=slug');
    exit;
}

// ===== INSERT PRODUCT =====
$stmt = $pdo->prepare("
    INSERT INTO products
    (name, slug, tagline, model, brand_id, category_id, subcategory_id, partner_id, price, stock,
     short_description, description, specifications, is_featured, is_active)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $name,
    $slug,
    $tagline,
    $model,
    $brand_id,
    $category_id,
    $subcategory_id,
    $partner_id,
    $price,
    $stock,
    $short_description ?: null,
    $description ?: null,
    $specifications ?: null,
    $is_featured,
    $is_active
]);

$product_id = $pdo->lastInsertId();

// ===== HANDLE IMAGE UPLOAD =====
$uploadDir = 'uploads/products/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!empty($_FILES['images']['name'][0])) {

    $isFirstImage = true;
    $sortOrder = 0;

    foreach ($_FILES['images']['tmp_name'] as $i => $tmpName) {

        if (!is_uploaded_file($tmpName)) continue;

        $originalName = $_FILES['images']['name'][$i];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) continue;

        $fileName = uniqid('prod_') . '.' . $ext;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {

            $stmtImg = $pdo->prepare("
                INSERT INTO product_images
                (product_id, image, sort_order, is_main)
                VALUES (?, ?, ?, ?)
            ");

            $stmtImg->execute([
                $product_id,
                $fileName,
                $sortOrder,
                $isFirstImage ? 1 : 0
            ]);

            $isFirstImage = false;
            $sortOrder++;
        }
    }
}

// ===== SELESAI =====
header('Location: product.php?created=1');
exit;
