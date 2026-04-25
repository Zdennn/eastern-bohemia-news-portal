
const hesloInput = document.querySelector("input[name='heslo']");
const noveHesloInput = document.querySelector("input[name='noveHeslo']");
const noveHesloZnovuInput = document.querySelector("input[name='noveHesloZnovu']");
const noveJmenoInput = document.querySelector("input[name='noveJmeno']");
const novyEmailInput = document.querySelector("input[name='novyEmail']");
const novyPopisInput = document.querySelector("textarea[name='novyPopis']");

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const specialCharsRegex = /[<>{}()"';`]/;

const validateHeslo = (value) => {
    const errors = [];
    if (value.length < 8) {
        errors.push("Heslo musí mít alespoň 8 znaků.");
    }
    if (!/[a-z]/.test(value)) {
        errors.push("Heslo musí obsahovat alespoň jedno malé písmeno.");
    }
    if (!/[A-Z]/.test(value)) {
        errors.push("Heslo musí obsahovat alespoň jedno velké písmeno.");
    }
    if (!/\d/.test(value)) {
        errors.push("Heslo musí obsahovat alespoň jednu číslici.");
    }
    return errors;
};

const validateEmail = (email) => {
    const errors = [];
    if (!emailRegex.test(email)) {
        errors.push("Neplatný formát e-mailu.");
    }
    if (specialCharsRegex.test(email)) {
        errors.push("E-mail obsahuje nepovolené speciální znaky.");
    }
    if (email.length > 255) {
        errors.push("E-mail nesmí přesáhnout 255 znaků.");
    }
    return errors;
};

const validateJmeno = (jmeno) => {
    const errors = [];
    if (jmeno.trim() === "") {
        errors.push("Jméno nesmí být prázdné.");
    }
    if (specialCharsRegex.test(jmeno)) {
        errors.push("Jméno obsahuje nepovolené speciální znaky.");
    }
    if (jmeno.length > 255) {
        errors.push("Jméno nesmí přesáhnout 255 znaků.");
    }
    return errors;
};

const validatePopis = (popis) => {
    const errors = [];
    if (popis.trim() === "") {
        errors.push("Popis nesmí být prázdný.");
    }
    if (specialCharsRegex.test(popis)) {
        errors.push("Popis obsahuje nepovolené speciální znaky.");
    }
    if (popis.length > 600) {
        errors.push("Popis nesmí přesáhnout 600 znaků.");
    }
    return errors;
};

hesloInput.addEventListener("input", () => {
    const errorZprava = hesloInput.nextElementSibling;
    errorZprava.innerHTML = "";
    const errors = validateHeslo(hesloInput.value);

    if (errors.length) {
        errors.forEach(error => {
            const errorDiv = document.createElement("div");
            errorDiv.textContent = error;
            errorZprava.appendChild(errorDiv);
        });
        hesloInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        hesloInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});

noveHesloInput.addEventListener("input", () => {
    const errorZprava = noveHesloInput.nextElementSibling;
    errorZprava.innerHTML = "";
    const errors = validateHeslo(noveHesloInput.value);

    if (errors.length) {
        errors.forEach(error => {
            const errorDiv = document.createElement("div");
            errorDiv.textContent = error;
            errorZprava.appendChild(errorDiv);
        });
        noveHesloInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        noveHesloInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});

noveHesloZnovuInput.addEventListener("input", () => {
    const errorZprava = noveHesloZnovuInput.nextElementSibling;
    errorZprava.innerHTML = "";
    if (noveHesloInput.value !== noveHesloZnovuInput.value) {
        const errorDiv = document.createElement("div");
        errorDiv.textContent = "Nové heslo se neshoduje s opakováním hesla.";
        errorZprava.appendChild(errorDiv);
        noveHesloZnovuInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        noveHesloZnovuInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});

noveJmenoInput.addEventListener("input", () => {
    const errorZprava = noveJmenoInput.nextElementSibling;
    errorZprava.innerHTML = "";
    const errors = validateJmeno(noveJmenoInput.value);

    if (errors.length) {
        errors.forEach(error => {
            const errorDiv = document.createElement("div");
            errorDiv.textContent = error;
            errorZprava.appendChild(errorDiv);
        });
        noveJmenoInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        noveJmenoInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});

novyEmailInput.addEventListener("input", () => {
    const errorZprava = novyEmailInput.nextElementSibling;
    errorZprava.innerHTML = "";
    const errors = validateEmail(novyEmailInput.value);

    if (errors.length) {
        errors.forEach(error => {
            const errorDiv = document.createElement("div");
            errorDiv.textContent = error;
            errorZprava.appendChild(errorDiv);
        });
        novyEmailInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        novyEmailInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});

novyPopisInput.addEventListener("input", () => {
    const errorZprava = novyPopisInput.nextElementSibling;
    errorZprava.innerHTML = "";
    const errors = validatePopis(novyPopisInput.value);

    if (errors.length) {
        errors.forEach(error => {
            const errorDiv = document.createElement("div");
            errorDiv.textContent = error;
            errorZprava.appendChild(errorDiv);
        });
        novyPopisInput.classList.add("error");
        errorZprava.style.display = "block";
    } else {
        novyPopisInput.classList.remove("error");
        errorZprava.style.display = "none";
    }
});
