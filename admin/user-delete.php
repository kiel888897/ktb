<?php
require 'config/database.php';
session_start();

/**
 * Ambil ID user yang akan dihapus
 */
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: users.php');
    exit;
}

/**
 * Proteksi: tidak boleh hapus diri sendiri
 * Asumsi user login disimpan di $_SESSION['user_id']
 */
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
    header('Location: users.php?error=self_delete');
    exit;
}

/**
 * Cek user ada atau tidak
 */
$stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
$stmt->execute([$id]);

if (!$stmt->fetch()) {
    header('Location: users.php');
    exit;
}

/**
 * Hapus user
 */
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header('Location: user.php?deleted=1');
exit;
