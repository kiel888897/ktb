const header = document.getElementById("mainHeader");
const desktopNav = document.getElementById("desktopNav");
const logoNav = document.getElementById("logoNav");
const desktopCTA = document.getElementById("desktopCTA");
const openBtn = document.getElementById("openMenu");
const closeBtn = document.getElementById("closeMenu");
const mobileMenu = document.getElementById("mobileMenu");
const mobilePanel = mobileMenu ? mobileMenu.querySelector("div") : null;

function setScrolled(state) {
  if (!header) return;
  if (state) {
    header.classList.remove("bg-transparent");
    header.classList.add("bg-white", "shadow");
    desktopNav.classList.remove("text-white");
    desktopNav.classList.add("text-gray-900");
    logoNav.classList.remove("text-white");
    logoNav.classList.add("text-gray-900");
    desktopCTA.classList.remove("border-white", "text-white");
    desktopCTA.classList.add("bg-primary", "text-white");
    openBtn.classList.remove("text-white");
    openBtn.classList.add("text-gray-900");
  } else {
    header.classList.add("bg-transparent");
    header.classList.remove("bg-white", "shadow");
    desktopNav.classList.add("text-white");
    desktopNav.classList.remove("text-gray-900");

    logoNav.classList.add("text-white");
    logoNav.classList.remove("text-gray-900");
    desktopCTA.classList.add("border-white", "text-white");
    desktopCTA.classList.remove("bg-primary");
    openBtn.classList.add("text-white");
    openBtn.classList.remove("text-gray-900");
  }
}

if (header) {
  window.addEventListener("scroll", () => {
    setScrolled(window.scrollY > 60);
  });
}

if (openBtn && closeBtn && mobileMenu) {
  openBtn.onclick = () => {
    mobileMenu.classList.remove("hidden");
    setTimeout(() => mobilePanel.classList.remove("translate-x-full"), 10);
    document.body.classList.add("overflow-hidden");
    setScrolled(true);
  };

  closeBtn.onclick = () => {
    mobilePanel.classList.add("translate-x-full");
    setTimeout(() => mobileMenu.classList.add("hidden"), 300);
    document.body.classList.remove("overflow-hidden");
  };
}

if (typeof Swiper !== "undefined") {
  const heroElement = document.querySelector(".heroSwiper");
  const brandElement = document.querySelector(".brandSwiper");

  if (heroElement) {
    new Swiper(heroElement, {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".heroSwiper .swiper-pagination",
        clickable: true,
      },
    });
  }

  if (brandElement) {
    new Swiper(brandElement, {
      loop: true,
      speed: 3000,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
      },
      slidesPerView: 2,
      spaceBetween: 30,
      breakpoints: {
        640: {
          slidesPerView: 3,
        },
        768: {
          slidesPerView: 4,
        },
        1024: {
          slidesPerView: 6,
        },
      },
    });
  }
}

/* ---------- Beranda ---------- */

// Waktu Bali (WITA, UTC+8)
function witaNow() {
  return new Date(Date.now() + 8 * 3600 * 1000);
}

// Status buka: Senin–Sabtu 08.00–17.00
document.querySelectorAll("[data-open-status]").forEach((el) => {
  const t = witaNow();
  const day = t.getUTCDay(); // 0 = Minggu
  const min = t.getUTCHours() * 60 + t.getUTCMinutes();
  const workday = day >= 1 && day <= 6;
  let text;
  if (workday && min >= 480 && min < 1020) {
    text = "Buka sekarang, tutup 17.00";
  } else if (workday && min < 480) {
    text = "Tutup, buka hari ini 08.00";
  } else if (day === 6 || day === 0) {
    text = "Tutup, buka Senin 08.00";
  } else {
    text = "Tutup, buka besok 08.00";
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
