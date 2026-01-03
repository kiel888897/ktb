const header = document.getElementById("mainHeader");
const desktopNav = document.getElementById("desktopNav");
const logoNav = document.getElementById("logoNav");
const desktopCTA = document.getElementById("desktopCTA");
const openBtn = document.getElementById("openMenu");
const closeBtn = document.getElementById("closeMenu");
const mobileMenu = document.getElementById("mobileMenu");
const mobilePanel = mobileMenu.querySelector("div");

function setScrolled(state) {
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

window.addEventListener("scroll", () => {
  setScrolled(window.scrollY > 60);
});

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
//hero swiper
new Swiper(".heroSwiper", {
  loop: true,
  speed: 800,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});
//brand swiper
const brandSwiper = new Swiper(".brandSwiper", {
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
