let btnDeleteRecipes = document.querySelectorAll(".delete-recipe");

(btnDeleteRecipes !== null)? addClicks(btnDeleteRecipes) : null;

function addClicks(btns){

    for(let i = 0; btns.length; i++){
        btns[i].addEventListener("click", deleteRecipe);
    }
}

function deleteRecipe(e){
    e.preventDefault();
    if(confirm("Do you want to delete a recipe")){
        window.location.href = e.target.href;
    }
}