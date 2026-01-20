<?php
require 'config/database.php';

$stmt = $pdo->query("SELECT * FROM brands");
$data = $stmt->fetchAll();

echo '<pre>';
print_r($data);
