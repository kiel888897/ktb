<?php
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: category.php');
    exit;
}

// ===== AMBIL & VALIDASI INPUT =====
$id   = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');

if ($id <= 0 || $name === '' || $slug === '') {
    die('Data tidak valid.');
}

// ===== CEK DATA CATEGORY =====
$stmt = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
$stmt->execute([$id]);
if (!$stmt->fetch()) {
    die('Kategori tidak ditemukan.');
}

// ===== CEK SLUG UNIK (KECUALI DIRI SENDIRI) =====
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM categories WHERE slug = ? AND id != ?"
);
$stmt->execute([$slug, $id]);

if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan oleh kategori lain.');
}

// ===== UPDATE DATABASE =====
$stmt = $pdo->prepare("
    UPDATE categories
    SET name = :name,
        slug = :slug
    WHERE id = :id
");

$stmt->execute([
    ':name' => $name,
    ':slug' => $slug,
    ':id'   => $id
]);

// ===== REDIRECT =====
header('Location: category.php?updated=1');
exit;
