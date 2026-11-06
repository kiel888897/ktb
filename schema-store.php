<?php
/*
|--------------------------------------------------------------------------
| Entitas toko (JSON-LD) yang dipakai semua halaman.
| Halaman lain cukup merujuk {"@id": SITE_URL . "/#store"}.
|--------------------------------------------------------------------------
*/
if (!defined('SITE_URL')) {
    define('SITE_URL', 'https://www.kusumatrisnabali.com');
}

if (!function_exists('jsonld')) {
    function jsonld(array $data): void
    {
        echo '<script type="application/ld+json">'
            . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG)
            . "</script>\n";
    }
}

if (!function_exists('breadcrumb_ld')) {
    /** @param array<int, array{0:string,1:string}> $items [nama, url] */
    function breadcrumb_ld(array $items): array
    {
        $list = [];
        foreach (array_values($items) as $i => [$name, $url]) {
            $list[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $name,
                'item' => $url,
            ];
        }
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $list,
        ];
    }
}

jsonld([
    '@context' => 'https://schema.org',
    '@type' => 'ElectronicsStore',
    '@id' => SITE_URL . '/#store',
    'name' => 'Kusuma Trisna Bali',
    'legalName' => 'CV. Kusuma Trisna Bali',
    'url' => SITE_URL . '/',
    'logo' => SITE_URL . '/assets/logo.png',
    'image' => SITE_URL . '/assets/og-image.jpg',
    'description' => 'Distributor dan pusat layanan perbaikan elektronik di Tabanan, Bali sejak 2019.',
    'foundingDate' => '2019',
    'telephone' => '+6287779928897',
    'email' => 'info@kusumatrisnabali.com',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Jl. By Pass Dr. Ir. Soekarno, Banjar Tegal Belodan, Dauh Peken',
        'addressLocality' => 'Tabanan',
        'addressRegion' => 'Bali',
        'postalCode' => '82113',
        'addressCountry' => 'ID',
    ],
    'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => -8.548504,
        'longitude' => 115.121177,
    ],
    'hasMap' => 'https://share.google/LNnFVBGg7wU9klqp3',
    'openingHoursSpecification' => [[
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        'opens' => '08:00',
        'closes' => '17:00',
    ]],
    'areaServed' => ['@type' => 'AdministrativeArea', 'name' => 'Bali'],
    'contactPoint' => [
        '@type' => 'ContactPoint',
        'telephone' => '+6287779928897',
        'contactType' => 'customer service',
        'areaServed' => 'ID',
        'availableLanguage' => ['Indonesian', 'English'],
    ],
    'sameAs' => [
        'https://www.facebook.com/kusumatrisnabali.ktb/',
    ],
]);

jsonld([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    '@id' => SITE_URL . '/#website',
    'name' => 'Kusuma Trisna Bali',
    'url' => SITE_URL . '/',
    'inLanguage' => 'id-ID',
    'publisher' => ['@id' => SITE_URL . '/#store'],
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => [
            '@type' => 'EntryPoint',
            'urlTemplate' => SITE_URL . '/products.php?search={search_term_string}',
        ],
        'query-input' => 'required name=search_term_string',
    ],
]);
