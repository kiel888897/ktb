<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

// ===== VALIDASI ID =====
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: user.php');
    exit;
}

// ===== PROTEKSI: TIDAK BOLEH HAPUS DIRI SENDIRI =====
if ($_SESSION['user']['id'] === $id) {
    header('Location: user.php?error=self_delete');
    exit;
}

// ===== CEK USER ADA =====
$stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
$stmt->execute([$id]);

if (!$stmt->fetch()) {
    header('Location: user.php');
    exit;
}

// ===== HAPUS USER =====
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

// ===== REDIRECT =====
header('Location: user.php?deleted=1');
exit;
