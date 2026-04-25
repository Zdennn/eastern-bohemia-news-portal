const bar = document.querySelector("#bar");
bar.classList.remove("barBila");
bar.classList.add("sticky");
bar.style.position = "sticky";

window.addEventListener("scroll", function () {
    resize();
});
window.addEventListener("resize", function () {
    resize();
});
window.addEventListener("load", function () {
    resize();
});

function resize() {
    const header = document.querySelector("header");
    const navA = document.querySelectorAll("header > div#bar > div.navMenu > nav a");
    const logo = document.querySelector("#logo");
    const main = document.querySelector("main");
    let headerHeight = header.offsetHeight - 145;
    if (window.innerWidth > 900) {
        bar.classList.remove("barBila");
        bar.classList.add("sticky");
        bar.style.position = "sticky";
        if (window.scrollY > headerHeight) {
            bar.classList.add("fixed");
            bar.classList.remove("sticky");
            bar.style.position = "fixed";

            header.classList.remove("scrolled");
            logo.src = "/assets/img/logo_cele.png"

            main.classList.add("nahore");
            main.classList.remove("dole");
        } else {
            bar.classList.add("sticky");
            bar.classList.remove("fixed");
            bar.style.position = "sticky";

            header.classList.add("scrolled");
            logo.src = "/assets/img/logo_cele_bile.png"
            
            main.classList.add("dole");
            main.classList.remove("nahore");
        }
    } else {
        bar.classList.add("barBila");
        bar.classList.remove("sticky");
        bar.style.position = "fixed";
        logo.src = "/assets/img/logo_cele.png"
    }
}

titles = titles.map(title => {
    let slova = title.split(' ');
    if (slova.length > 1) {
      slova[slova.length - 2] += '&nbsp;' + slova.pop();
    }
    return slova.join(' ');
  });
  

const sipkaDoleva = document.querySelector('.sipkaDoleva');
const sipkaDoprava = document.querySelector('.sipkaDoprava')

const slides = document.querySelector('.slides');
const slidesCount = document.querySelectorAll('.slide').length;

const carkyDiv = document.querySelector('#carky');
const carky = document.querySelectorAll('.cara');

const nadpisTxtObr = document.querySelector('#nadpisTxtObr');

let index = 0;
let interval;

window.addEventListener('resize', updateSlide);

window.addEventListener('load', () => {
    Array.from(carky).forEach(carka => carka.classList.add("no-animation"));
});

function updateSlide() {
    const slideWidth = window.innerWidth;
    slides.style.transform = `translateX(${-index * slideWidth}px)`;
    updateCarky();
    updateTitle();
}

function nextSlide() {
    if (index < slidesCount - 1) {
        index++;
    } else {
        Array.from(carky).forEach(carka => carka.classList.add("no-animation"));
        index = 0;
    }
    updateSlide();
    setTimeout(() => {
        Array.from(carky).forEach(carka => carka.classList.remove("no-animation"));
    }, 50);
}

function prevSlide() {
    if (index > 0) {
        index--;
    } else {
        index = slidesCount - 1;
    }
    updateSlide();
}

function updateCarky() {
    Array.from(carky).forEach((carka, i) => {
        carka.classList.remove("active");
        if (i <= index) {
            carka.classList.remove("none");
        } else {
            carka.classList.add("none");
        }
    });
    carky[index].classList.add("active");
}

function updateTitle() {
    const viceTlac = document.querySelector('#viceTlacTxtObr');
    viceTlac.href = cesty[index];
    nadpisTxtObr.innerHTML = titles[index];
    nadpisTxtObr.style.animation = 'none';
    setTimeout(() => {
        nadpisTxtObr.style.animation = '';
    }, 20);

    viceTlac.style.animation = 'none';
    setTimeout(() => {
        viceTlac.style.animation = '';
    }, 20);
}

sipkaDoprava.addEventListener('click', () => {
    clearInterval(interval);
    nextSlide();
    startInterval();
});

sipkaDoleva.addEventListener('click', () => {
    clearInterval(interval);
    prevSlide();
    startInterval();
});

function startInterval() {
    interval = setInterval(nextSlide, 5000);
}

updateSlide();
startInterval();

const kategorieLinks = document.querySelectorAll('.odkaz');
const kategorieSections = document.querySelectorAll('.sKatDatClanky');

kategorieLinks.forEach(link => {
    link.addEventListener("click", event => {
        event.preventDefault();
        kategorieLinks.forEach(l => l.classList.remove("active"));
        link.classList.add("active");

        kategorieSections.forEach(section => {
            section.classList.remove("visible");
            section.classList.add("hidden");
        });

        const categoryId = link.id;
        kategorieSections.forEach(section => {
            if (categoryId == section.id) {
                section.classList.remove("hidden");
                section.classList.add("visible");
            }
        });
    });
});
