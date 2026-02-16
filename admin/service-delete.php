<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

/* ===============================
   VALIDASI ID
=================================*/
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: service.php");
    exit;
}

$id = (int) $_GET['id'];

/* ===============================
   CEK DATA ADA ATAU TIDAK
=================================*/
$stmt = $pdo->prepare("SELECT id FROM services WHERE id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    header("Location: service.php");
    exit;
}

/* ===============================
   HAPUS DATA
=================================*/
$stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([$id]);

header("Location: service.php");
exit;
