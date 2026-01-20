<?php
require 'config/database.php';

// ===== VALIDASI ID =====
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: category.php');
    exit;
}

// ===== AMBIL DATA CATEGORY =====
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    header('Location: category.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| OPSIONAL (SANGAT DISARANKAN)
| Cek relasi sebelum hapus
|--------------------------------------------------------------------------
| Aktifkan jika tabel berikut sudah digunakan:
|
| 1. category_subcategory
| 2. product_category (jika ada)
|
| --- Contoh ---
|
| $check = $pdo->prepare(
|   "SELECT COUNT(*) FROM category_subcategory WHERE category_id = ?"
| );
| $check->execute([$id]);
| if ($check->fetchColumn() > 0) {
|     die('Kategori tidak bisa dihapus karena masih memiliki subkategori.');
| }
|
*/

// ===== HAPUS DATA CATEGORY =====
$stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
$stmt->execute([$id]);

// ===== REDIRECT =====
header('Location: category.php?deleted=1');
exit;
