<?php
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: category.php');
    exit;
}

// ===== AMBIL & VALIDASI INPUT =====
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');

if ($name === '' || $slug === '') {
    die('Nama kategori dan slug wajib diisi.');
}

// ===== CEK SLUG UNIK =====
$stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE slug = ?");
$stmt->execute([$slug]);

if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan. Silakan gunakan slug lain.');
}

// ===== INSERT DATABASE =====
$stmt = $pdo->prepare("
    INSERT INTO categories (name, slug)
    VALUES (:name, :slug)
");

$stmt->execute([
    ':name' => $name,
    ':slug' => $slug
]);

// ===== REDIRECT =====
header('Location: category.php?success=1');
exit;
