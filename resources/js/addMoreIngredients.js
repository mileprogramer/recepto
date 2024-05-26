let btn = document.getElementById("add-ingredient");
let ingredients = document.querySelector("#ingredients-container");
let ingredientsSelect = document.querySelector("#ingredientUnit");

(btn !== null)? btn.addEventListener("click", addIngredinet) : null;

function addIngredinet(){
    let html = `        
        <div class="col-4">
            <input class="form-control" type="text" name="ingredients[]">
        </div>
        <div class="col-2">
            <input class="form-control w-10 col-4" name="quantity[]" type="number"/>
        </div>
        <div class="col-2">
            <select class="form-select w-10 col-4" name="units[]" id="">
                ${ingredientsSelect.innerHTML.trim()}
            </select>
        </div>
    `;
    let div = document.createElement("div");
    div.classList.add("row", "pt-3");
    div.innerHTML = html;
    ingredients.appendChild(div);
}