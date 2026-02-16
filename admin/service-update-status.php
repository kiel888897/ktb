<?php
require 'auth.php';
require_role(['admin', 'staff', 'superadmin']);
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;

    $allowed = [
        'barang diterima',
        'checking/diagnose',
        'on progress',
        'pending part',
        'pending customer',
        'done',
        'cancel'
    ];

    if (!$id || !in_array($status, $allowed)) {
        http_response_code(400);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE services SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    echo "success";
}
