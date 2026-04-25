const jmenoInput = document.querySelector("input[name='jmeno']");
const emailInput = document.querySelector("input[name='email']");
const passwordInput = document.querySelector("input[name='heslo']");

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

jmenoInput.addEventListener("input", () => {
    const errorZprava = jmenoInput.nextElementSibling;
    if (jmenoInput.value.trim() === "") {
        jmenoInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        jmenoInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});

emailInput.addEventListener("input", () => {
    const errorZprava = emailInput.nextElementSibling;
    if (!emailRegex.test(emailInput.value)) {
        emailInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        emailInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});

passwordInput.addEventListener("input", () => {
    const errorZprava = passwordInput.nextElementSibling;
    const value = passwordInput.value;

    errorZprava.innerHTML = "";

    let isValid = true;

    if (value.length < 8) {
        const error = document.createElement("div");
        error.textContent = "Heslo musí mít alespoň 8 znaků.";
        errorZprava.appendChild(error);
        isValid = false;
    }

    if (!/[a-z]/.test(value)) {
        const error = document.createElement("div");
        error.textContent = "Heslo musí obsahovat alespoň jedno malé písmeno.";
        errorZprava.appendChild(error);
        isValid = false;
    }

    if (!/[A-Z]/.test(value)) {
        const error = document.createElement("div");
        error.textContent = "Heslo musí obsahovat alespoň jedno velké písmeno.";
        errorZprava.appendChild(error);
        isValid = false;
    }

    if (!/\d/.test(value)) {
        const error = document.createElement("div");
        error.textContent = "Heslo musí obsahovat alespoň jednu číslici.";
        errorZprava.appendChild(error);
        isValid = false;
    }

    if (!isValid) {
        passwordInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        passwordInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});
