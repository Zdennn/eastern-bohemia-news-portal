    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const lightboxTitle = document.getElementById("lightbox-title");
    const mainImg = document.getElementById("imgContainer");
    const closeBtn = document.querySelector(".close");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");
    const thumbnails = document.querySelectorAll(".thumbnail");

    let images = [];
    let titles = [];
    let currentIndex = 0;

    thumbnails.forEach((img, index) => {
        images.push(img.src);
        titles.push(img.getAttribute("data-title") || "");
        img.addEventListener("click", () => openLightbox(index));
    });

    function openLightbox(index) {
        currentIndex = index;
        lightbox.style.display = "flex";
        updateLightboxImage();
    }

    function closeLightbox() {
        lightbox.style.display = "none";
    }

    function updateLightboxImage() {
        lightboxImg.src = images[currentIndex];
        lightboxTitle.textContent = titles[currentIndex];
        thumbnails.forEach(thumb => thumb.classList.remove("active"));
        thumbnails[currentIndex].classList.add("active");
    }

    function changeImage(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = images.length - 1;
        else if (currentIndex >= images.length) currentIndex = 0;
        updateLightboxImage();
    }

    closeBtn.addEventListener("click", closeLightbox);
    prevBtn.addEventListener("click", () => changeImage(-1));
    nextBtn.addEventListener("click", () => changeImage(1));

    document.addEventListener("keydown", function (event) {
        if (lightbox.style.display === "flex") {
            if (event.key === "ArrowLeft") changeImage(-1);
            if (event.key === "ArrowRight") changeImage(1);
            if (event.key === "Escape") closeLightbox();
        }
    });

    lightbox.addEventListener("click", (event) => {
        if (event.target === lightbox) closeLightbox();
    });