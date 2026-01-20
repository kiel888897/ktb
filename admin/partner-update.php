<?php
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: partner.php');
    exit;
}

// ===== AMBIL & VALIDASI INPUT =====
$id        = (int)($_POST['id'] ?? 0);
$name      = trim($_POST['name'] ?? '');
$slug      = trim($_POST['slug'] ?? '');
$isActive  = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
$sortOrder = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;

if ($id <= 0 || $name === '' || $slug === '') {
    die('Data tidak valid.');
}

// ===== AMBIL DATA PARTNER LAMA =====
$stmt = $pdo->prepare("SELECT * FROM partners WHERE id = ?");
$stmt->execute([$id]);
$partner = $stmt->fetch();

if (!$partner) {
    die('Partner tidak ditemukan.');
}

// ===== CEK SLUG UNIK (KECUALI DIRI SENDIRI) =====
$stmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM partners 
    WHERE slug = ? AND id != ?
");
$stmt->execute([$slug, $id]);

if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan oleh partner lain.');
}

// ===== HANDLE UPLOAD LOGO (OPSIONAL) =====
$logoName = $partner['logo'] ?: 'default.png';

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

    // ===== HAPUS LOGO LAMA (KECUALI DEFAULT) =====
    if (!empty($partner['logo']) && $partner['logo'] !== 'default.png') {
        $oldPath = $uploadDir . $partner['logo'];
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }
}

// ===== UPDATE DATABASE =====
$stmt = $pdo->prepare("
    UPDATE partners
    SET name = :name,
        slug = :slug,
        logo = :logo,
        is_active = :is_active,
        sort_order = :sort_order
    WHERE id = :id
");

$stmt->execute([
    ':name'       => $name,
    ':slug'       => $slug,
    ':logo'       => $logoName,
    ':is_active'  => $isActive,
    ':sort_order' => $sortOrder,
    ':id'         => $id
]);

// ===== REDIRECT =====
header('Location: partner.php?updated=1');
exit;
