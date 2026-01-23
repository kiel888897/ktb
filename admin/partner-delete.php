<?php
require 'auth.php';
require 'config/database.php';

// ===== VALIDASI ID =====
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: partner.php');
    exit;
}

// ===== AMBIL DATA PARTNER =====
$stmt = $pdo->prepare("SELECT * FROM partners WHERE id = ?");
$stmt->execute([$id]);
$partner = $stmt->fetch();

if (!$partner) {
    header('Location: partner.php');
    exit;
}

// ===== HAPUS LOGO (KECUALI DEFAULT) =====
if (!empty($partner['logo']) && $partner['logo'] !== 'default.png') {
    $logoPath = 'uploads/partners/' . $partner['logo'];
    if (file_exists($logoPath)) {
        unlink($logoPath);
    }
}

// ===== HAPUS DATA PARTNER =====
$stmt = $pdo->prepare("DELETE FROM partners WHERE id = ?");
$stmt->execute([$id]);

// ===== REDIRECT =====
header('Location: partner.php?deleted=1');
exit;
