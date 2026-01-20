<?php
require 'config/database.php';

// ===== VALIDASI ID =====
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: subcategory.php');
    exit;
}

// ===== CEK SUBCATEGORY ADA =====
$stmt = $pdo->prepare("SELECT id FROM subcategories WHERE id = ?");
$stmt->execute([$id]);
$subcategory = $stmt->fetch();

if (!$subcategory) {
    header('Location: subcategory.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| OPSIONAL (SANGAT DISARANKAN)
| Cek relasi ke produk
|--------------------------------------------------------------------------
| Jika sudah ada tabel products dengan kolom subcategory_id
|
| $check = $pdo->prepare(
|   "SELECT COUNT(*) FROM products WHERE subcategory_id = ?"
| );
| $check->execute([$id]);
| if ($check->fetchColumn() > 0) {
|     die('Subcategory tidak bisa dihapus karena masih digunakan produk.');
| }
|
*/

try {
    // ===== TRANSAKSI =====
    $pdo->beginTransaction();

    // ===== HAPUS RELASI CATEGORY =====
    $stmt = $pdo->prepare("
        DELETE FROM category_subcategory
        WHERE subcategory_id = ?
    ");
    $stmt->execute([$id]);

    // ===== HAPUS SUBCATEGORY =====
    $stmt = $pdo->prepare("
        DELETE FROM subcategories
        WHERE id = ?
    ");
    $stmt->execute([$id]);

    // ===== COMMIT =====
    $pdo->commit();

    // ===== REDIRECT =====
    header('Location: subcategory.php?deleted=1');
    exit;
} catch (Exception $e) {
    // ===== ROLLBACK =====
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die('Terjadi kesalahan saat menghapus subcategory.');
}
