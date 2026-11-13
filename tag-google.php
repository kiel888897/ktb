<!-- Google tag (gtag.js), dimuat setelah halaman selesai agar tidak menghambat tampilan pertama -->
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-JE07JEKLGD');

    (function () {
        var loaded = false;
        function loadGtag() {
            if (loaded) return;
            loaded = true;
            var s = document.createElement('script');
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id=G-JE07JEKLGD';
            document.head.appendChild(s);
        }
        window.addEventListener('load', function () {
            if ('requestIdleCallback' in window) {
                requestIdleCallback(loadGtag, { timeout: 3000 });
            } else {
                setTimeout(loadGtag, 1500);
            }
        });
        ['pointerdown', 'keydown', 'scroll', 'touchstart'].forEach(function (e) {
            window.addEventListener(e, loadGtag, { once: true, passive: true });
        });
    })();
</script>
