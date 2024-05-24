<section id="search" class="container py-5">

    <h2 class="disaply-4">Search for recipes</h2>
    
    <form action="/search">
        <div class="row p-3">
            <h4 class="col-2">Recipe for :</h4>
            <div class="form-group col-2">
                <p class="d-inline">Breakfast</p>
                <input type="checkbox" value="breakfast">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Dinner</p>
                <input type="checkbox" value="dinner">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Lunch</p>
                <input type="checkbox" value="lunch">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Snack</p>
                <input type="checkbox" value="snack">
            </div>
        </div>

        <div class="ingredients row p-3">
            <h4 class="col-2">Ingredients</h4>
            <div class="ingredients-input-parent">
                <input class="form-control" type="text" name="ingredients">
            </div>
            <button type="button" class="btn btn-primary my-3">Add more</button>
        </div>

        <div class="row p-3">
            <h4 class="col-2">Recipe calories info :</h4>
            <div class="form-group col-2">
                <p class="d-inline">Calories</p>
                <input  class="form-control" type="text" value="">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Fat</p>
                <input  class="form-control" type="text" value="">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Protein</p>
                <input  class="form-control" type="text" value="">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Carbs</p>
                <input class="form-control"  type="text" value="">
            </div>
        </div>

        <div class="row p-3">
            <h3>Choose category for meal</h3>
            <select name="category" class="form-select">
                <option value="-">Choose category</option>
            </select>
        </div>

        <div class="row p-3">
            <h3>Time to prepare meal</h3>
            <em>Insert values in minutes</em>
            <input class="form-control" type="number">
        </div>
        <button type="submit" class="btn btn-info w-100">Search</button>
    </form>

</section>