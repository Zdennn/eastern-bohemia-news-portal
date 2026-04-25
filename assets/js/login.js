    const emailInput = document.querySelector("input[name='email']");
    const passwordInput = document.querySelector("input[name='heslo']");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const specialCharsRegex = /[<>{}()"';`]/;

    emailInput.addEventListener("input", () => {
        const errorZprava = emailInput.nextElementSibling;
        errorZprava.innerHTML = "";
    
        let isValid = true;
    
        if (!emailRegex.test(emailInput.value)) {
            const error = document.createElement("div");
            error.textContent = "Neplatný formát e-mailu.";
            errorZprava.appendChild(error);
            isValid = false;
        }
    
        if (specialCharsRegex.test(emailInput.value)) {
            const error = document.createElement("div");
            error.textContent = "E-mail obsahuje nepovolené speciální znaky.";
            errorZprava.appendChild(error);
            isValid = false;
        }
    
        if (!isValid) {
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