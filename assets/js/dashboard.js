const menuLinks = document.querySelectorAll(".menu a");
const currentUrl = window.location.pathname;

menuLinks.forEach(link => {
  const href = link.getAttribute("href");

  if (href === "/dashboard" && currentUrl === "/dashboard") {
    link.classList.add("active");
  } else if (currentUrl.includes(href) && href !== "/dashboard") {
    link.classList.add("active");
  } else {
    link.classList.remove("active");
  }
});


const hamburger = document.querySelector(".hamburger");
const mobileMenu = document.querySelector(".mobile-menu");

hamburger.addEventListener("click", () => {
    const isOpen = mobileMenu.style.display === "flex";
    mobileMenu.style.display = isOpen ? "none" : "flex";

    hamburger.classList.toggle("open");
});

document.addEventListener("click", (event) => {
    if (!hamburger.contains(event.target) && !mobileMenu.contains(event.target)) {
        mobileMenu.style.display = "none";
        hamburger.classList.remove("open");
    }
});

window.addEventListener("resize", () => {
    if (window.innerWidth > 768) {
        mobileMenu.style.display = "none";
        hamburger.classList.remove("open");
    }
});





  