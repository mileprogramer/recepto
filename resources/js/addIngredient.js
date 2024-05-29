let btn = document.getElementById("add-ingredient");
let ingredients = document.querySelector("#ingredients-container");
(btn !== null)? btn.addEventListener("click", addIngredinet) : null;
let btnsDeleteAddedIngredient = null;

let counter = 0;
function addIngredinet(){
    let html = `
            <input type="text" class="form-control my-3" name='ingredients[]'>
            <input type="button" class="btn btn-danger my-3" value='Delete ingredient'>
    `;
    let divParent = document.createElement("div");
    divParent.classList.add("row", "gap-3");
    divParent.innerHTML = html;
    ingredients.append(divParent);
    btnsDeleteAddedIngredient = ingredients.querySelectorAll(".btn-danger");
    addDeleteClicks();
}

function addDeleteClicks(){
    if(!btnsDeleteAddedIngredient.length) return ;
    btnsDeleteAddedIngredient.forEach(btn => {
        btn.onclick = function(){
            let parentElement = this.parentElement;
            ingredients.removeChild(parentElement);
            btnsDeleteAddedIngredient = ingredients.querySelectorAll(".btn-danger");
        }
    });
}