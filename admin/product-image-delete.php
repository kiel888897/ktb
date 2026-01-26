<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

$id = (int)($_GET['id'] ?? 0);
$product_id = (int)($_GET['product_id'] ?? 0);

if (!$id || !$product_id) {
    header('Location: product.php');
    exit;
}

// Ambil data image
$stmt = $pdo->prepare("SELECT image, is_main FROM product_images WHERE id = ?");
$stmt->execute([$id]);
$image = $stmt->fetch();

if (!$image) {
    header("Location: product-edit.php?id=$product_id");
    exit;
}

// Hapus file fisik
$filePath = 'uploads/products/' . $image['image'];
if (is_file($filePath)) {
    unlink($filePath);
}

// Hapus dari database
$stmt = $pdo->prepare("DELETE FROM product_images WHERE id = ?");
$stmt->execute([$id]);

// Jika yang dihapus adalah main image,
// set image lain sebagai main (jika ada)
if ($image['is_main']) {
    $stmt = $pdo->prepare("
        SELECT id FROM product_images
        WHERE product_id = ?
        ORDER BY sort_order ASC
        LIMIT 1
    ");
    $stmt->execute([$product_id]);
    $newMain = $stmt->fetch();

    if ($newMain) {
        $pdo->prepare("
            UPDATE product_images
            SET is_main = 1
            WHERE id = ?
        ")->execute([$newMain['id']]);
    }
}

// Redirect kembali ke edit product
header("Location: product-edit.php?id=$product_id");
exit;
