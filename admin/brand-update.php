<?php
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: brand.php');
    exit;
}

// ===== AMBIL & VALIDASI INPUT =====
$id   = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');

if ($id <= 0 || $name === '' || $slug === '') {
    die('Data tidak valid.');
}

// ===== AMBIL DATA BRAND LAMA =====
$stmt = $pdo->prepare("SELECT * FROM brands WHERE id = ?");
$stmt->execute([$id]);
$brand = $stmt->fetch();

if (!$brand) {
    die('Brand tidak ditemukan.');
}

// ===== CEK SLUG UNIK (KECUALI DIRI SENDIRI) =====
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM brands WHERE slug = ? AND id != ?"
);
$stmt->execute([$slug, $id]);

if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan oleh brand lain.');
}

// ===== HANDLE UPLOAD LOGO BARU =====
$logoName = $brand['logo'] ?: 'default.png';

if (!empty($_FILES['logo']['name'])) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $tmpPath = $_FILES['logo']['tmp_name'];

    if (!is_uploaded_file($tmpPath)) {
        die('Upload file tidak valid.');
    }

    $fileType = mime_content_type($tmpPath);
    if (!in_array($fileType, $allowedTypes)) {
        die('Format logo harus JPG, PNG, atau WebP.');
    }

    if ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
        die('Ukuran logo maksimal 2MB.');
    }

    // Buat nama file baru
    $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $newLogoName = $slug . '-' . time() . '.' . $extension;

    $uploadDir = 'uploads/brands/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadPath = $uploadDir . $newLogoName;

    if (!move_uploaded_file($tmpPath, $uploadPath)) {
        die('Gagal mengupload logo.');
    }

    // Hapus logo lama (jika bukan default)
    if (!empty($brand['logo']) && $brand['logo'] !== 'default.png') {
        $oldPath = $uploadDir . $brand['logo'];
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    $logoName = $newLogoName;
}

// ===== UPDATE DATABASE =====
$stmt = $pdo->prepare("
    UPDATE brands
    SET name = :name,
        slug = :slug,
        logo = :logo
    WHERE id = :id
");

$stmt->execute([
    ':name' => $name,
    ':slug' => $slug,
    ':logo' => $logoName,
    ':id'   => $id
]);

// ===== REDIRECT =====
header('Location: brand.php?updated=1');
exit;
