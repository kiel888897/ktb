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

if (!function_exists('thumb_src')) {
    function thumb_src(string $path, int $w): string
    {
        if (preg_match('#^admin/uploads/((?:products|brands|partners)/[A-Za-z0-9._-]+\.(?:jpe?g|png|webp))$#i', $path, $m)) {
            return 'thumb.php?src=' . rawurlencode($m[1]) . '&w=' . $w;
        }
        return $path;
    }
}
