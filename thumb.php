<?php
/*
| Menyajikan gambar upload dalam ukuran kecil (WebP) dan menyimpannya di admin/uploads/.cache.
| Bila server tidak mendukung atau proses gagal, file asli yang dikirim.
*/
$sizes = [240, 480, 900];
$src = (string) ($_GET['src'] ?? '');
$w = (int) ($_GET['w'] ?? 0);

if (!in_array($w, $sizes, true) || !preg_match('#^(products|brands|partners)/[A-Za-z0-9._-]+\.(jpe?g|png|webp)$#i', $src)) {
    http_response_code(404);
    exit;
}
$orig = __DIR__ . '/admin/uploads/' . $src;
if (!is_file($orig)) {
    http_response_code(404);
    exit;
}

$send = function (string $file, string $type) {
    header('Content-Type: ' . $type);
    header('Content-Length: ' . filesize($file));
    header('Cache-Control: public, max-age=2592000');
    header('X-Content-Type-Options: nosniff');
    readfile($file);
    exit;
};
$sendOriginal = function () use ($orig, $send) {
    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
    $send($orig, ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'][$ext]);
};

$dir = __DIR__ . '/admin/uploads/.cache';
$cache = $dir . '/v2-' . $w . '-' . md5($src . '|' . filemtime($orig)) . '.webp';
if (is_file($cache)) {
    $send($cache, 'image/webp');
}
if (!function_exists('imagewebp') || !function_exists('imagecreatefromstring')) {
    $sendOriginal();
}

try {
    @ini_set('memory_limit', '256M');
    $im = @imagecreatefromstring((string) file_get_contents($orig));
    if (!$im) {
        $sendOriginal();
    }
    imagepalettetotruecolor($im);
    $ow = imagesx($im);
    $oh = imagesy($im);
    if ($ow > $w) {
        // imagescale() dengan IMG_BICUBIC mengembalikan false di GD bawaan PHP, jadi skala manual.
        $h = max(1, (int) round($oh * $w / $ow));
        $scaled = imagecreatetruecolor($w, $h);
        imagealphablending($scaled, false);
        imagesavealpha($scaled, true);
        imagefill($scaled, 0, 0, imagecolorallocatealpha($scaled, 0, 0, 0, 127));
        if (!imagecopyresampled($scaled, $im, 0, 0, 0, 0, $w, $h, $ow, $oh)) {
            $sendOriginal();
        }
        $im = $scaled;
    }
    imagealphablending($im, false);
    imagesavealpha($im, true);

    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    $tmp = (is_dir($dir) && is_writable($dir)) ? tempnam($dir, 'tmp') : tempnam(sys_get_temp_dir(), 'ktb');
    if (!$tmp || !imagewebp($im, $tmp, 78) || filesize($tmp) === 0 || filesize($tmp) >= filesize($orig)) {
        if ($tmp) {
            @unlink($tmp);
        }
        $sendOriginal();
    }
    if (is_dir($dir) && is_writable($dir) && @rename($tmp, $cache)) {
        @chmod($cache, 0644);
        $send($cache, 'image/webp');
    }
    header('Content-Type: image/webp');
    header('Cache-Control: public, max-age=2592000');
    readfile($tmp);
    @unlink($tmp);
} catch (Throwable $t) {
    $sendOriginal();
}
