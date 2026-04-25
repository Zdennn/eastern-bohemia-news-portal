const ul = document.querySelector("#tagList"),
input = ul.querySelector("input");

let tags = JSON.parse(input.getAttribute("data-tags") || "[]");

function createTag(){
    ul.querySelectorAll("li").forEach(li => li.remove());
    tags.forEach(tag => {
        let liTag = `<li>${tag} <i onclick="removeTag('${tag}')">✖</i></li>`;
        ul.insertAdjacentHTML("afterbegin", liTag);
    });
}

function removeTag(tag){
    tags = tags.filter(t => t !== tag);
    createTag();
}

function addTag(e){
    if (e.key === "Enter" || e.key === ",") {
        e.preventDefault();
        let tag = e.target.value.trim().replace(/,/g, "");
        if (tag && !tags.includes(tag)) {
            tags.push(tag);
            createTag();
        }
        e.target.value = "";
    }
}
createTag();
input.addEventListener("keydown", addTag);
document.querySelector("form").addEventListener("submit", () => {
    let hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "tagy";
    hiddenInput.value = tags.join(","); 
    document.querySelector("form").appendChild(hiddenInput);
    console.log(hiddenInput);
});


tinymce.init({
    selector: '#obsah',
    height: 500,
    plugins: 'autolink autoresize autosave help link lists nonbreaking preview searchreplace visualchars wordcount', 
    toolbar: [
      { name: 'history', items: [ 'undo', 'redo' ] },
      { name: 'styles', items: [ 'blocks'] },
      { name: 'formatting', items: [ 'bold', 'italic' ] },
      { name: 'insert', items: [ 'link' ] },
      { name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ] },
      { name: 'indentation', items: [ 'outdent', 'indent', 'numlist', 'bullist'] },
      { name: 'yey', items: [ 'visualchars'] }
    ],
    menubar: 'file edit insert help',
    removed_menuitems: 'hr',
    min_height: 500,
    branding: false,
    language: 'cs',
    nonbreaking_force_tab: true,
    content_css: '/assets/styly/tinymceCustom.css',
    automatic_uploads: true, 
    license_key: 'gpl',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});

















const modal = document.getElementById("modalObrazky");
const btnSpravovat = document.getElementById("spravovatObrazky");
const btnPridat = document.getElementById("pridatObrazek");
const fileInput = document.getElementById("fileInput");
const previewContainer = document.getElementById("previewContainer");
const closeModal = document.getElementById("ulozit");
const obrazekDbBtn = document.querySelectorAll(".obrazekDbBtn");
const obrazkyDb = document.querySelectorAll(".obrazkyDb");
let obrazky = [];
let smazatObrazkyDb = [];

function renderObrazky() {
    console.log(obrazky);
    
    previewContainer.innerHTML = "";

    if (obrazkyDb.length != 0) {
        obrazkyDb.forEach(obrazekDiv => {

            if (!smazatObrazkyDb.includes(obrazekDiv.lastElementChild.id)) {
                previewContainer.appendChild(obrazekDiv);
            }
        });
    }
    
if (obrazky.length != 0) {

    obrazky.forEach((obrazek, index) => {
        let div = document.createElement("div");
        div.classList.add("obrazek-item");

        let img = document.createElement("img");
        img.src = URL.createObjectURL(obrazek);
        img.alt = "Nahraný obrázek";

        let btnRemove = document.createElement("button");
        btnRemove.innerHTML = "✖";
        btnRemove.onclick = () => removeObrazek(index);

        div.appendChild(img);
        div.appendChild(btnRemove);
        previewContainer.appendChild(div);
    });
}
}

function removeObrazek(index) {
    obrazky.splice(index, 1);   
    renderObrazky();
}

obrazekDbBtn.forEach(btn => {
    btn.addEventListener("click", (e) => {
        e.preventDefault();
        odstranitObrazek(btn.id);
        renderObrazky();
    });
});

fileInput.addEventListener("change", (e) => {
    e.preventDefault();
    Array.from(e.target.files).forEach(file => obrazky.push(file));
    renderObrazky();
});

btnPridat.addEventListener("click", (e) => {
    e.preventDefault();
    fileInput.value = null;
    fileInput.click();
});

btnSpravovat.addEventListener("click", (e) => {
    e.preventDefault();
    modal.style.display = "block";
});

closeModal.addEventListener("click", (e) => {
    e.preventDefault();
    modal.style.display = "none";
});

document.querySelector("form").addEventListener("submit", (e) => {
    let fileInputElement = document.createElement("input");
    fileInputElement.type = "file";
    fileInputElement.name = "obrazky[]";
    fileInputElement.multiple = true;
    fileInputElement.required = true;

    let dataTransfer = new DataTransfer();
    obrazky.forEach(file => dataTransfer.items.add(file));
    fileInputElement.files = dataTransfer.files;

    document.querySelector("form").appendChild(fileInputElement);

    let hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "odstranitObrazky";
    hiddenInput.value = JSON.stringify(smazatObrazkyDb);
    document.querySelector("form").appendChild(hiddenInput);
});

function odstranitObrazek(obrazekId) {
    smazatObrazkyDb.push(obrazekId);
    console.log(smazatObrazkyDb);
}