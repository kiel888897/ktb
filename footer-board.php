<?php
// Footer gaya "papan" (dipakai beranda; halaman lain menyusul)
$fArrow = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M6 11l6-6 6 6"/></svg>';
$fCatalog = isset($catalog) && is_array($catalog) ? array_slice($catalog, 0, 5, true) : [];
if (!$fCatalog && isset($pdo)) {
    // Halaman lain: 5 jenis produk dengan produk terbanyak
    try {
        foreach ($pdo->query("
            SELECT s.slug, s.name, COUNT(p.id) AS n
            FROM subcategories s
            JOIN products p ON p.subcategory_id = s.id AND p.is_active = 1
            GROUP BY s.id, s.slug, s.name
            ORDER BY n DESC, s.name ASC
            LIMIT 5
        ") as $row) {
            $fCatalog[$row['slug']] = ['name' => $row['name']];
        }
    } catch (Throwable $t) {
        $fCatalog = [];
    }
}
?>
<footer class="bg-[#111827] text-white pt-16 lg:pt-24 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        <!-- Tanda KTB dibangun dari balok -->
        <a href="/" class="block" aria-label="Kusuma Trisna Bali, ke beranda">
            <svg viewBox="0 0 1200 300" class="w-full h-auto" aria-hidden="true">
                <rect x="0" y="0" width="396" height="300" rx="6" fill="#c1121f" />
                <rect x="402" y="66" width="396" height="234" rx="6" fill="#780000" />
                <rect x="804" y="30" width="396" height="270" rx="6" fill="#f3f4f6" />
                <g font-family="IBM Plex Sans, sans-serif" font-weight="700" font-size="250" fill="#111827" text-anchor="middle">
                    <text x="198" y="262">K</text>
                    <text x="600" y="262">T</text>
                    <text x="1002" y="262">B</text>
                </g>
            </svg>
        </a>

        <div class="mt-14 grid grid-cols-2 lg:grid-cols-12 gap-x-6 gap-y-10 text-base leading-relaxed">
            <nav aria-label="Menu footer" class="lg:col-span-2">
                <h2 class="font-semibold mb-3">Menu</h2>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="/" class="hover:text-white">Beranda</a></li>
                    <li><a href="products.php" class="hover:text-white">Produk</a></li>
                    <li><a href="services.php" class="hover:text-white">Service</a></li>
                    <li><a href="about.php" class="hover:text-white">Tentang kami</a></li>
                    <li><a href="contact.php" class="hover:text-white">Kontak</a></li>
                </ul>
            </nav>

            <div class="lg:col-span-2">
                <h2 class="font-semibold mb-3">Kategori</h2>
                <ul class="space-y-2 text-gray-300">
                    <?php if ($fCatalog): ?>
                        <?php foreach ($fCatalog as $slug => $g): ?>
                            <li><a href="products.php?subcategory=<?= htmlspecialchars($slug) ?>" class="hover:text-white"><?= htmlspecialchars($g['name']) ?></a></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><a href="products.php" class="hover:text-white">Semua produk</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h2 class="font-semibold mb-3">Service</h2>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="services.php#track-service" class="hover:text-white">Lacak service</a></li>
                    <li><a href="services.php" class="hover:text-white">Service center resmi</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h2 class="font-semibold mb-3">Ikuti</h2>
                <ul class="space-y-2 text-gray-300">
                    <li><a href="https://www.facebook.com/kusumatrisnabali.ktb/" target="_blank" rel="noopener noreferrer" class="hover:text-white">Facebook</a></li>
                    <li><a href="https://shopee.co.id/trisnaelectronics" target="_blank" rel="noopener noreferrer" class="hover:text-white">Shopee</a></li>
                </ul>
            </div>

            <div class="col-span-2 lg:col-span-4 grid sm:grid-cols-2 gap-6 text-gray-300">
                <address class="not-italic">
                    <span class="block font-semibold text-white mb-3">Alamat</span>
                    Jl. By Pass Dr. Ir. Soekarno, Banjar Tegal Belodan, Dauh Peken, Tabanan, Bali 82113<br>
                    <a href="https://share.google/LNnFVBGg7wU9klqp3" target="_blank" rel="noopener noreferrer" class="underline underline-offset-4 hover:text-white">Lihat di Google Maps</a>
                </address>
                <div>
                    <span class="block font-semibold text-white mb-3">Hubungi</span>
                    <a href="tel:+6287779928897" class="hover:text-white">0877-7992-8897</a><br>
                    <a href="https://wa.me/6287779928897" target="_blank" rel="noopener noreferrer" class="hover:text-white">WhatsApp</a><br>
                    Senin–Sabtu, 08.00–17.00
                </div>
            </div>
        </div>

        <div class="mt-14 flex items-center justify-between gap-4 text-base text-gray-300">
            <p>© <?= date('Y'); ?> Kusuma Trisna Bali</p>
            <a href="#top" class="inline-flex items-center gap-2 rounded-[6px] bg-white/10 px-4 py-2 text-white hover:bg-white/20 transition-colors">Ke atas <?= $fArrow ?></a>
        </div>
    </div>
</footer>

<!-- Tombol WhatsApp melayang -->
<a href="https://wa.me/6287779928897" target="_blank" rel="noopener noreferrer"
    aria-label="Hubungi kami melalui WhatsApp"
    class="fixed bottom-4 right-4 lg:bottom-5 lg:right-5 z-50 w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-[#1f9d55] hover:bg-[#188046] text-white shadow-lg flex items-center justify-center transition-colors">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.21 3.07.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35zM12.05 21.5h-.01a9.4 9.4 0 0 1-4.8-1.32l-.34-.2-3.57.94.95-3.48-.22-.36a9.4 9.4 0 0 1-1.44-5.02c0-5.2 4.23-9.43 9.44-9.43 2.52 0 4.89.98 6.67 2.77a9.37 9.37 0 0 1 2.76 6.67c0 5.2-4.24 9.43-9.44 9.43zm8.03-17.46A11.27 11.27 0 0 0 12.05.72C5.79.72.7 5.8.7 12.06c0 2 .52 3.95 1.52 5.67L.6 23.6l6.01-1.58a11.3 11.3 0 0 0 5.43 1.38h.01c6.25 0 11.34-5.09 11.34-11.34 0-3.03-1.18-5.88-3.32-8.02z" />
    </svg>
</a>
