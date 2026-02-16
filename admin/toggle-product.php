<?php
require 'auth.php';
require_role(['admin', 'staff', 'superadmin']);
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int)$_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'] ? 1 : 0;

    // whitelist supaya aman
    $allowed = ['is_featured', 'is_active'];

    if (!in_array($field, $allowed)) {
        echo json_encode(['success' => false]);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE products SET $field = ? WHERE id = ?");
    $stmt->execute([$value, $id]);

    echo json_encode(['success' => true]);
}
