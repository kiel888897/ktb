<?php
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: subcategory.php');
    exit;
}

// ===== AMBIL & VALIDASI INPUT =====
$id         = (int)($_POST['id'] ?? 0);
$name       = trim($_POST['name'] ?? '');
$slug       = trim($_POST['slug'] ?? '');
$categories = $_POST['categories'] ?? [];

if ($id <= 0 || $name === '' || $slug === '') {
    die('Data tidak valid.');
}

if (!is_array($categories) || count($categories) === 0) {
    die('Pilih minimal satu kategori.');
}

// ===== CEK SUBCATEGORY ADA =====
$stmt = $pdo->prepare("SELECT id FROM subcategories WHERE id = ?");
$stmt->execute([$id]);
if (!$stmt->fetch()) {
    die('Subcategory tidak ditemukan.');
}

// ===== CEK SLUG UNIK (KECUALI DIRI SENDIRI) =====
$stmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM subcategories 
    WHERE slug = ? AND id != ?
");
$stmt->execute([$slug, $id]);

if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan oleh subcategory lain.');
}

try {
    // ===== MULAI TRANSAKSI =====
    $pdo->beginTransaction();

    // ===== UPDATE SUBCATEGORY =====
    $stmt = $pdo->prepare("
        UPDATE subcategories
        SET name = :name,
            slug = :slug
        WHERE id = :id
    ");
    $stmt->execute([
        ':name' => $name,
        ':slug' => $slug,
        ':id'   => $id
    ]);

    // ===== RESET RELASI CATEGORY =====
    $stmt = $pdo->prepare("
        DELETE FROM category_subcategory
        WHERE subcategory_id = ?
    ");
    $stmt->execute([$id]);

    // ===== INSERT RELASI BARU =====
    $stmtRel = $pdo->prepare("
        INSERT INTO category_subcategory (category_id, subcategory_id)
        VALUES (:category_id, :subcategory_id)
    ");

    foreach ($categories as $categoryId) {
        $stmtRel->execute([
            ':category_id' => (int)$categoryId,
            ':subcategory_id' => $id
        ]);
    }

    // ===== COMMIT =====
    $pdo->commit();

    // ===== REDIRECT =====
    header('Location: subcategory.php?updated=1');
    exit;
} catch (Exception $e) {
    // ===== ROLLBACK =====
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die('Terjadi kesalahan saat memperbarui subcategory.');
}
