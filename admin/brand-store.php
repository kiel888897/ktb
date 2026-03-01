<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

// ===== VALIDASI BASIC =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: brand.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($name === '' || $slug === '') {
    die('Nama dan slug wajib diisi.');
}

// ===== CEK SLUG UNIK =====
$stmt = $pdo->prepare("SELECT COUNT(*) FROM brands WHERE slug = ?");
$stmt->execute([$slug]);
if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan, silakan gunakan slug lain.');
}

// ===== UPLOAD LOGO =====
$logoName = 'default.png';

if (!empty($_FILES['logo']['name'])) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($_FILES['logo']['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        die('Format logo harus JPG, PNG, atau WebP.');
    }

    if ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
        die('Ukuran logo maksimal 2MB.');
    }

    $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $logoName = $slug . '-' . time() . '.' . $extension;

    $uploadDir = 'uploads/brands/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadPath = $uploadDir . $logoName;

    if (!move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
        die('Gagal mengupload logo.');
    }
}

// ===== INSERT DATABASE =====
$stmt = $pdo->prepare("
    INSERT INTO brands (name, slug, description, logo)
    VALUES (:name, :slug, :description, :logo)
");

$stmt->execute([
    ':name' => $name,
    ':slug' => $slug,
    ':description' => $description,
    ':logo' => $logoName
]);

// ===== REDIRECT =====
header('Location: brand.php?success=1');
exit;
