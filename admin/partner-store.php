<?php
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: partner.php');
    exit;
}

// ===== AMBIL & VALIDASI INPUT =====
$name       = trim($_POST['name'] ?? '');
$slug       = trim($_POST['slug'] ?? '');
$isActive   = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
$sortOrder  = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;

if ($name === '' || $slug === '') {
    die('Nama partner dan slug wajib diisi.');
}

// ===== CEK SLUG UNIK =====
$stmt = $pdo->prepare("SELECT COUNT(*) FROM partners WHERE slug = ?");
$stmt->execute([$slug]);

if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan. Silakan gunakan slug lain.');
}

// ===== HANDLE UPLOAD LOGO =====
$logoName = 'default.png';

if (!empty($_FILES['logo']['name'])) {

    $tmpPath = $_FILES['logo']['tmp_name'];

    if (!is_uploaded_file($tmpPath)) {
        die('Upload file tidak valid.');
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($tmpPath);

    if (!in_array($fileType, $allowedTypes)) {
        die('Format logo harus JPG, PNG, atau WebP.');
    }

    if ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
        die('Ukuran logo maksimal 2MB.');
    }

    $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $logoName = $slug . '-' . time() . '.' . $extension;

    $uploadDir = 'uploads/partners/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadPath = $uploadDir . $logoName;

    if (!move_uploaded_file($tmpPath, $uploadPath)) {
        die('Gagal mengupload logo.');
    }
}

// ===== INSERT DATABASE =====
$stmt = $pdo->prepare("
    INSERT INTO partners (name, slug, logo, is_active, sort_order)
    VALUES (:name, :slug, :logo, :is_active, :sort_order)
");

$stmt->execute([
    ':name'       => $name,
    ':slug'       => $slug,
    ':logo'       => $logoName,
    ':is_active'  => $isActive,
    ':sort_order' => $sortOrder
]);

// ===== REDIRECT =====
header('Location: partner.php?success=1');
exit;
