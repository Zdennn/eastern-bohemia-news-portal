const ul = document.querySelector("#tagList"),
input = ul.querySelector("input");

let tags = JSON.parse(input.getAttribute("data-tags") || "[]");

console.log(tags);

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
    hiddenInput.value = JSON.stringify(tags);
    document.querySelector("form").appendChild(hiddenInput);
});