<?php
require 'config/database.php';

// ===== VALIDASI METHOD =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: subcategory.php');
    exit;
}

// ===== AMBIL & VALIDASI INPUT =====
$name = trim($_POST['name'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$categories = $_POST['categories'] ?? [];

if ($name === '' || $slug === '') {
    die('Nama subkategori dan slug wajib diisi.');
}

if (!is_array($categories) || count($categories) === 0) {
    die('Pilih minimal satu kategori.');
}

// ===== CEK SLUG UNIK =====
$stmt = $pdo->prepare("SELECT COUNT(*) FROM subcategories WHERE slug = ?");
$stmt->execute([$slug]);

if ($stmt->fetchColumn() > 0) {
    die('Slug sudah digunakan. Silakan gunakan slug lain.');
}

try {
    // ===== MULAI TRANSAKSI =====
    $pdo->beginTransaction();

    // ===== INSERT SUBCATEGORY =====
    $stmt = $pdo->prepare("
        INSERT INTO subcategories (name, slug)
        VALUES (:name, :slug)
    ");
    $stmt->execute([
        ':name' => $name,
        ':slug' => $slug
    ]);

    $subcategoryId = $pdo->lastInsertId();

    // ===== INSERT RELASI CATEGORY_SUBCATEGORY =====
    $stmtRel = $pdo->prepare("
        INSERT INTO category_subcategory (category_id, subcategory_id)
        VALUES (:category_id, :subcategory_id)
    ");

    foreach ($categories as $categoryId) {
        $stmtRel->execute([
            ':category_id' => (int)$categoryId,
            ':subcategory_id' => $subcategoryId
        ]);
    }

    // ===== COMMIT =====
    $pdo->commit();

    // ===== REDIRECT =====
    header('Location: subcategory.php?success=1');
    exit;
} catch (Exception $e) {
    // ===== ROLLBACK JIKA ERROR =====
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die('Terjadi kesalahan saat menyimpan subkategori.');
}
