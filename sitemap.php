<?php
require 'admin/config/database.php';

header('Content-Type: application/xml; charset=UTF-8');

$base = 'https://www.kusumatrisnabali.com';

$static = [
    ['/', 'weekly', '1.0'],
    ['/products.php', 'weekly', '0.9'],
    ['/services.php', 'monthly', '0.9'],
    ['/about.php', 'monthly', '0.7'],
    ['/contact.php', 'monthly', '0.7'],
];

// Hanya merek yang punya produk aktif; merek kosong diberi noindex
$brands = $pdo->query("
    SELECT b.slug
    FROM brands b
    WHERE b.slug <> ''
      AND EXISTS (SELECT 1 FROM products p WHERE p.brand_id = b.id AND p.is_active = 1)
    ORDER BY b.name
")->fetchAll(PDO::FETCH_COLUMN);

$products = $pdo->query("
    SELECT slug
    FROM products
    WHERE is_active = 1 AND slug <> ''
    ORDER BY sort_order ASC, id DESC
")->fetchAll(PDO::FETCH_COLUMN);

$e = fn(string $s): string => htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($static as [$path, $freq, $prio]) {
    echo "  <url><loc>{$e($base . $path)}</loc><changefreq>$freq</changefreq><priority>$prio</priority></url>\n";
}

foreach ($brands as $slug) {
    $loc = $base . '/brand-product.php?brand=' . rawurlencode($slug);
    echo "  <url><loc>{$e($loc)}</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>\n";
}

foreach ($products as $slug) {
    $loc = $base . '/detail-product.php?slug=' . rawurlencode($slug);
    echo "  <url><loc>{$e($loc)}</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>\n";
}

echo "</urlset>\n";
