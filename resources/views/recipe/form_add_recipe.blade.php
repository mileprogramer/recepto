<form action="/add-recipe" method="POST">
    @csrf
    <h1 class="mt-3">Fill the form to add the recipe</h1>
    @if ($errors->any())

        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
        
    @endif
    @if (session("success"))

    <div class="alert alert-success">
            <li>{{ session("success") }}</li>
    </div>
    
    @endif
    <div class="row p-3">
        
        <div class="form-group col-6">
            <p>Type name of recipe</p>
            <input type="text" name="name_recipe" class="form-control">
        </div>
        
        <div class="form-group col-12">
            <p>Type description for recipe</p>
            <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
        </div>

        <div class="row py-3 align-center">
            <h4 class="col-2">Recipe for :</h4>
            <div class="form-group col-2">
                <p class="d-inline">Breakfast</p>
                <input name="meal_type[]" type="checkbox" value="breakfast">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Dinner</p>
                <input name="meal_type[]" type="checkbox" value="dinner" >
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Lunch</p>
                <input name="meal_type[]" type="checkbox" value="lunch" >
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Snack</p>
                <input name="meal_type[]" type="checkbox" value="snack" >
            </div>
        </div>

    <div class="ingredients p-3">
        <h4>Ingredients</h4>
        <div id="ingredients-container">
            <div class="row">
                <div class="col-4">
                    <p class="d-inline">Name of ingredient</p>
                    <input class="form-control" type="text" name="ingredients[]">
                </div>
                <div class="col-2">
                    <p class="d-inline">Quantity for ingredient</p>
                    <input class="form-control w-10 col-4" name="quantity[]" type="number"/>
                </div>
                <div class="col-2">
                    <p class="d-inline">Choose unit for recipe</p>
                    <select class="form-select w-10 col-4" name="units[]" id="ingredientUnit">
                        <option value="">Choose unit</option>
                        @foreach ($units as $unit)
                            <option value="{{$unit->id }}">{{ $unit->name_unit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <p></p>
                    <input class="w-100 btn btn-danger w-10 col-4" type='button' value='Delete ingredient'/>
                </div>
            </div>
        </div>
        <button id="add-ingredient" type="button" class="btn btn-primary my-3">Add ingredient</button>
    </div>

    <div class="row p-3">
        <h4 class="col-2 my-auto">Calories info :</h4>
        <div class="form-group col-2">
            <p class="d-inline">Calories</p>
            <input  class="form-control" type="text" name="calories">
        </div>
        <div class="form-group col-2">
            <p class="d-inline">Fat</p>
            <input  class="form-control" type="text" name="fat">
        </div>
        <div class="form-group col-2">
            <p class="d-inline">Protein</p>
            <input  class="form-control" type="text" name="protein">
        </div>
        <div class="form-group col-2">
            <p class="d-inline">Carbs</p>
            <input class="form-control"  type="text" name="carbs">
        </div>
    </div>

    <div class="row p-3">
        <h3>Choose category for meal</h3>
        <select name="category" class="form-select">
            <option value="-">Choose category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name_category }}</option>
            @endforeach
        </select>
    </div>

    <div class="row p-3">
        <h3>Time to make meal</h3>
        <div class="row">
            <div class="col-6 row">
                <div class="col-8">
                    <p>Time to prepare meal</p>
                    <input class="form-control" type="number" name="time_to_prepare">
                </div>
                <div class="col-4">
                    <p>Unit</p>
                    <select name="time_to_prepare_unit" class="form-select">
                        <option value="">Choose unit</option>
                        @foreach ($units as $unit)
                            @if ($unit->name_unit === "hour" || $unit->name_unit === "minutes")
                                <option value="{{$unit->id }}">{{ $unit->name_unit }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6 row">
                <div class="col-8">
                    <p>Time to cook meal</p>
                    <input class="form-control" type="number" name="time_cook_meal">
                </div>
                <div class="col-4">
                    <p>Unit</p>
                    <select name="time_cook_meal_unit" class="form-select">
                        <option value="">Choose unit</option>
                        @foreach ($units as $unit)                            
                            @if ($unit->name_unit === "hour" || $unit->name_unit === "minutes")
                                <option value="{{$unit->id }}">{{ $unit->name_unit }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-info w-100">Add</button>
</form>