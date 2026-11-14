/* ---------- Beranda dan halaman lain ---------- */

// Waktu Bali (WITA, UTC+8)
function witaNow() {
  return new Date(Date.now() + 8 * 3600 * 1000);
}

// Status buka: Senin–Sabtu 09.00–17.00
document.querySelectorAll("[data-open-status]").forEach((el) => {
  const t = witaNow();
  const day = t.getUTCDay(); // 0 = Minggu
  const min = t.getUTCHours() * 60 + t.getUTCMinutes();
  const workday = day >= 1 && day <= 6;
  let text;
  if (workday && min >= 540 && min < 1020) {
    text = "Buka sekarang, tutup 17.00";
  } else if (workday && min < 540) {
    text = "Tutup, buka hari ini 09.00";
  } else if (day === 6 || day === 0) {
    text = "Tutup, buka Senin 09.00";
  } else {
    text = "Tutup, buka besok 09.00";
  }
  el.textContent = text;
});

// Jam setempat
const clocks = document.querySelectorAll("[data-clock]");
function tick() {
  const t = witaNow();
  const hh = String(t.getUTCHours()).padStart(2, "0");
  const mm = String(t.getUTCMinutes()).padStart(2, "0");
  clocks.forEach((el) => (el.textContent = hh + "." + mm + " WITA"));
}
if (clocks.length) {
  tick();
  setInterval(tick, 30000);
}

// Form WhatsApp: gabungkan nama + keperluan jadi satu pesan
document.querySelectorAll("[data-wa-form]").forEach((form) => {
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const nama = (form.elements.nama.value || "").trim();
    const perlu = (form.elements.text.value || "").trim();
    let msg = "Halo Kusuma Trisna Bali";
    if (nama) msg += ", saya " + nama;
    msg += ".";
    if (perlu) msg += " " + perlu;
    const url = form.action + "?text=" + encodeURIComponent(msg);
    window.open(url, "_blank", "noopener");
  });
});

// Muncul bertahap saat masuk layar
const reveals = document.querySelectorAll("[data-reveal]");
if (reveals.length) {
  const show = (el) => {
    Array.from(el.children).forEach((c, i) => {
      c.style.transitionDelay = Math.min(i, 6) * 75 + "ms";
    });
    el.classList.add("is-in");
  };
  if ("IntersectionObserver" in window) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((en) => {
          if (en.isIntersecting) {
            show(en.target);
            io.unobserve(en.target);
          }
        });
      },
      { rootMargin: "0px 0px -10% 0px" }
    );
    reveals.forEach((el) => io.observe(el));
  } else {
    reveals.forEach(show);
  }
}

// Galeri detail produk
document.querySelectorAll("[data-thumb]").forEach((btn) => {
  btn.addEventListener("click", () => {
    const main = document.getElementById("mainImg");
    if (!main) return;
    main.src = btn.dataset.thumb;
    document.querySelectorAll("[data-thumb]").forEach((b) => b.removeAttribute("aria-current"));
    btn.setAttribute("aria-current", "true");
  });
});

/* ---------- Pelacakan GA4: hanya jenis aksi dan letaknya, tanpa isi form ---------- */
function track(name, el) {
  if (typeof window.gtag !== "function") return;
  const area = el.closest("header, footer, section[id], section[aria-label], nav");
  const lokasi = area
    ? area.id || area.getAttribute("aria-label") || area.tagName.toLowerCase()
    : "lainnya";
  window.gtag("event", name, { lokasi: lokasi, transport_type: "beacon" });
}

document.addEventListener("click", (e) => {
  const a = e.target.closest ? e.target.closest("a[href]") : null;
  if (!a) return;
  const href = a.getAttribute("href");
  if (href.indexOf("wa.me/") !== -1) track("whatsapp_click", a);
  else if (href.indexOf("tel:") === 0) track("phone_click", a);
  else if (href.indexOf("shopee.co.id") !== -1) track("shopee_click", a);
});

document.addEventListener("submit", (e) => {
  const f = e.target;
  if (f.hasAttribute("data-wa-form")) track("whatsapp_click", f);
  else if (f.querySelector('[name="service_code"]')) track("service_track", f);
  else if ((f.getAttribute("action") || "") === "send-mail.php") track("contact_form", f);
});
