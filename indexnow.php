<?php
// IndexNow: beri tahu Bing, Yandex, dll. bahwa URL berubah. File kunci: /cdad1faf70f716223eceece5958a7a3c.txt (harus ada di root situs).
// Dipanggil dari admin setelah produk/merek disimpan; gagal diam-diam agar tidak mengganggu admin.
if (!function_exists('indexnow_ping')) {
    function indexnow_ping(array $paths): void
    {
        $host = 'www.kusumatrisnabali.com';
        $key = 'cdad1faf70f716223eceece5958a7a3c';
        $urls = array_values(array_unique(array_map(fn($p) => 'https://' . $host . '/' . ltrim($p, '/'), $paths)));
        if (!$urls || !function_exists('curl_init')) {
            return;
        }
        $ch = curl_init('https://api.indexnow.org/indexnow');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf-8'],
            CURLOPT_POSTFIELDS => json_encode([
                'host' => $host,
                'key' => $key,
                'keyLocation' => 'https://' . $host . '/' . $key . '.txt',
                'urlList' => $urls,
            ], JSON_UNESCAPED_SLASHES),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => 5,
        ]);
        @curl_exec($ch);
        curl_close($ch);
    }
}
