<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'auth.php';
require_role(['admin', 'staff', 'superadmin']);
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int)$_POST['id'];
    $change = (int)$_POST['change'];

    // Ambil stok sekarang
    $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo json_encode(['success' => false]);
        exit;
    }

    $newStock = $product['stock'] + $change;

    if ($newStock < 0) {
        $newStock = 0; // tidak boleh minus
    }

    $update = $pdo->prepare("UPDATE products SET stock = ? WHERE id = ?");
    $update->execute([$newStock, $id]);

    echo json_encode([
        'success' => true,
        'stock' => $newStock
    ]);
}
