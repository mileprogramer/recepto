let btn = document.getElementById("add-ingredient");
let ingredients = document.querySelector("#ingredients-container");
(btn !== null)? btn.addEventListener("click", addIngredinet) : null;

function addIngredinet(){
    let input = document.createElement("input");
    input.classList.add("form-control");
    input.name = "ingredients[]";
    input.text = "text";
    ingredients.append(input);
}