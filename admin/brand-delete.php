<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

// ===== VALIDASI ID =====
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: brand.php');
    exit;
}

// ===== AMBIL DATA BRAND =====
$stmt = $pdo->prepare("SELECT * FROM brands WHERE id = ?");
$stmt->execute([$id]);
$brand = $stmt->fetch();

if (!$brand) {
    header('Location: brand.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| OPTIONAL (DISARANKAN)
| Cek apakah brand masih dipakai oleh produk
|--------------------------------------------------------------------------
| Jika tabel products sudah ada dan punya kolom brand_id,
| aktifkan kode di bawah ini.
|
| $check = $pdo->prepare("SELECT COUNT(*) FROM products WHERE brand_id = ?");
| $check->execute([$id]);
| if ($check->fetchColumn() > 0) {
|     die('Brand tidak bisa dihapus karena masih digunakan produk.');
| }
|
*/

// ===== HAPUS LOGO FILE (KECUALI DEFAULT) =====
$uploadDir = 'uploads/brands/';

if (!empty($brand['logo']) && $brand['logo'] !== 'default.png') {
    $logoPath = $uploadDir . $brand['logo'];
    if (file_exists($logoPath)) {
        unlink($logoPath);
    }
}

// ===== HAPUS DATA BRAND =====
$stmt = $pdo->prepare("DELETE FROM brands WHERE id = ?");
$stmt->execute([$id]);

// ===== REDIRECT =====
header('Location: brand.php?deleted=1');
exit;
