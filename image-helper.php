<?php
// URL gambar upload versi kecil (lihat thumb.php). Bentuk nama yang tidak dikenal memakai file asli.
// Nama merek di database huruf kapital semua; rapikan untuk judul dan schema.
if (!function_exists('nice_brand')) {
    function nice_brand($name): string
    {
        $name = trim((string) $name);
        return strlen($name) <= 3 ? strtoupper($name) : preg_replace('/\bTv\b/', 'TV', ucwords(strtolower($name), " -"));
    }
}

// Harga jual = harga modal (products.price) + profit % dari tabel company, sama dengan admin/seller.php.
// Null bila harga modal kosong, sehingga halaman tetap meminta pengunjung tanya lewat WhatsApp.
if (!function_exists('sell_price')) {
    function sell_price(PDO $pdo, $cost): ?float
    {
        static $profit = null;
        if ($cost === null || (float) $cost <= 0) {
            return null;
        }
        if ($profit === null) {
            $profit = (float) ($pdo->query('SELECT profit FROM company LIMIT 1')->fetchColumn() ?: 0);
        }
        return round((float) $cost * (1 + $profit / 100));
    }

    function rupiah(float $n): string
    {
        return 'Rp ' . number_format($n, 0, ',', '.');
    }
}

if (!function_exists('thumb_src')) {
    function thumb_src(string $path, int $w): string
    {
        if (preg_match('#^admin/uploads/((?:products|brands|partners)/[A-Za-z0-9._-]+\.(?:jpe?g|png|webp))$#i', $path, $m)) {
            return 'thumb.php?src=' . rawurlencode($m[1]) . '&w=' . $w;
        }
        return $path;
    }
}
