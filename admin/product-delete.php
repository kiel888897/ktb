<?php
require 'config/database.php';

// ===== VALIDASI ID =====
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: product.php');
    exit;
}

// ===== AMBIL DATA PRODUK =====
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: product.php');
    exit;
}

// ===== AMBIL & HAPUS GAMBAR PRODUK =====
$stmt = $pdo->prepare("SELECT image FROM product_images WHERE product_id = ?");
$stmt->execute([$id]);
$images = $stmt->fetchAll();

foreach ($images as $img) {
    if (!empty($img['image']) && $img['image'] !== 'default.png') {
        $imagePath = 'uploads/products/' . $img['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}

// ===== HAPUS DATA GAMBAR =====
$stmt = $pdo->prepare("DELETE FROM product_images WHERE product_id = ?");
$stmt->execute([$id]);

// ===== HAPUS DATA PRODUK =====
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

// ===== REDIRECT =====
header('Location: product.php?deleted=1');
exit;
