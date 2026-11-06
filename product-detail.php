<?php
/*
| Template lama. Diarahkan permanen ke detail-product.php
| agar tidak ada dua URL untuk produk yang sama.
*/
$slug = trim($_GET['slug'] ?? '');
$target = $slug !== ''
    ? '/detail-product.php?slug=' . rawurlencode($slug)
    : '/products.php';

header('Location: https://www.kusumatrisnabali.com' . $target, true, 301);
exit;
