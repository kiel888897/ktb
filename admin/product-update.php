<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: product.php');
    exit;
}

// ===== AMBIL DATA =====
$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$brand_id = (int)($_POST['brand_id'] ?? 0);
$category_id = (int)($_POST['category_id'] ?? 0);
$subcategory_id = (int)($_POST['subcategory_id'] ?? 0);
$partner_id = ($_POST['partner_id'] !== '') ? (int)$_POST['partner_id'] : null;
$price = ($_POST['price'] !== '' && isset($_POST['price'])) ? (float)$_POST['price'] : null;
$short_description = trim($_POST['short_description'] ?? '');
$description = trim($_POST['description'] ?? '');
$is_featured = isset($_POST['is_featured']) ? (int)$_POST['is_featured'] : 0;
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

// ===== VALIDASI =====
if (!$id || $name === '' || $slug === '' || !$brand_id || !$category_id || !$subcategory_id) {
    header("Location: product-edit.php?id=$id");
    exit;
}

// ===== CEK PRODUCT =====
$stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
$stmt->execute([$id]);
if (!$stmt->fetch()) {
    header('Location: product.php');
    exit;
}

// ===== CEK SLUG UNIK (KECUALI DIRI SENDIRI) =====
$stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE slug = ? AND id != ?");
$stmt->execute([$slug, $id]);
if ($stmt->fetchColumn() > 0) {
    header("Location: product-edit.php?id=$id&error=slug");
    exit;
}

// ===== UPDATE PRODUCT =====
$stmt = $pdo->prepare("
    UPDATE products SET
        name = ?,
        slug = ?,
        brand_id = ?,
        category_id = ?,
        subcategory_id = ?,
        partner_id = ?,
        price = ?,
        short_description = ?,
        description = ?,
        is_featured = ?,
        is_active = ?
    WHERE id = ?
");

$stmt->execute([
    $name,
    $slug,
    $brand_id,
    $category_id,
    $subcategory_id,
    $partner_id,
    $price,
    $short_description ?: null,
    $description ?: null,
    $is_featured,
    $is_active,
    $id
]);

// ===== HANDLE UPLOAD IMAGE BARU =====
$uploadDir = 'uploads/products/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Cek apakah sudah ada main image
$stmt = $pdo->prepare("SELECT COUNT(*) FROM product_images WHERE product_id = ? AND is_main = 1");
$stmt->execute([$id]);
$hasMainImage = $stmt->fetchColumn() > 0;

if (!empty($_FILES['images']['name'][0])) {

    // Ambil sort_order terakhir
    $stmt = $pdo->prepare("SELECT MAX(sort_order) FROM product_images WHERE product_id = ?");
    $stmt->execute([$id]);
    $sortOrder = (int)$stmt->fetchColumn() + 1;

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
                $id,
                $fileName,
                $sortOrder,
                $hasMainImage ? 0 : 1
            ]);

            $hasMainImage = true;
            $sortOrder++;
        }
    }
}

// ===== SELESAI =====
header("Location: product-edit.php?id=$id&updated=1");
exit;
