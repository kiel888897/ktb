<?php
require 'auth.php';
require_role(['superadmin']);
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->query("SELECT id FROM company LIMIT 1");
    $company = $stmt->fetch();

    if (!$company) {
        echo json_encode(['success' => false]);
        exit;
    }

    // kalau kirim langsung set
    if (isset($_POST['set'])) {
        $newProfit = (float)$_POST['set'];
    } else {
        $change = (float)$_POST['change'];

        $stmt = $pdo->query("SELECT profit FROM company LIMIT 1");
        $current = $stmt->fetch()['profit'];

        $newProfit = $current + $change;
    }

    if ($newProfit < 0) $newProfit = 0;
    if ($newProfit > 100) $newProfit = 100;

    $update = $pdo->prepare("UPDATE company SET profit = ? WHERE id = ?");
    $update->execute([$newProfit, $company['id']]);

    echo json_encode([
        'success' => true
    ]);
}
