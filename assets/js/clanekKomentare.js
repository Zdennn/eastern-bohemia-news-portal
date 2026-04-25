const odpovedetTlac = document.querySelectorAll(".odpovedetTlac");

odpovedetTlac.forEach(button => {
    button.addEventListener("click", (e) => {
        e.preventDefault();

        const reakceForm = button.closest(".reakce").querySelector(".reakceForm");

        if (reakceForm.style.display === "flex") {
            reakceForm.style.display = "none";
        } else {
            const allReakceForms = document.querySelectorAll(".reakceForm");
            allReakceForms.forEach(form => {
                form.style.display = "none";
            });

            reakceForm.style.display = "flex";
        }
    });
});
