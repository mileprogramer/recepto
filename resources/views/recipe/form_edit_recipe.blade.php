<form action="/admin/edit-recipe" method="POST">
    @csrf
    <h1 class="mt-3">Edit the recipe</h1>
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
        <input type="hidden" name="id_recipe" value="{{$recipe->id_recipe}}">
        <div class="form-group col-6">
            <p>Type name of recipe</p>
            <input type="text" name="name_recipe" class="form-control" value="{{$recipe->name_recipe}}">
        </div>
        
        <div class="form-group col-12">
            <p>Type description for recipe</p>
            <textarea name="description" class="form-control" cols="30" rows="10">{{ $recipe->description }}</textarea>
        </div>

        <div class="row py-3 align-center">
            <h4 class="col-2">Recipe for :</h4>
            <div class="form-group col-2">
                <p class="d-inline">Breakfast</p>
                <input name="meal_type[]" type="checkbox" value="breakfast"
                {{ $recipe->is_breakfast ? "checked": "" }}
                >
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Dinner</p>
                <input name="meal_type[]" type="checkbox" value="dinner" 
                {{ $recipe->is_dinner ? "checked": "" }}
                >
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Lunch</p>
                <input name="meal_type[]" type="checkbox" value="lunch" 
                {{ $recipe->is_lunch ? "checked": "" }}
                >
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Snack</p>
                <input name="meal_type[]" type="checkbox" value="snack" 
                {{ $recipe->is_snack ? "checked": "" }}
                >
            </div>
        </div>

    <div class="ingredients p-3">
        <h4>Ingredients</h4>
        <div id="ingredients-container">
            @for ($i = 0; $i < count($recipe->ingredients); $i++)
                <div class="row pt-3">
                    <div class="col-4">
                        <p class="d-inline">Name of ingredient</p>
                        <input class="form-control" type="text" name="ingredients[]" value="{{$recipe->ingredients[$i]}}">
                    </div>
                    <div class="col-2">
                        <p class="d-inline">Quantity for ingredient</p>
                        <input class="form-control w-10 col-4" name="quantity[]" type="number" value="{{$recipe->quantities[$i]}}"/>
                    </div>
                    <div class="col-2">
                        <p class="d-inline">Choose unit for recipe</p>
                        <select class="form-select w-10 col-4" name="units[]" id="ingredientUnit">
                            <option value="">Choose unit</option>
                            @foreach ($units as $unit)
                                <option {{ $unit->name_unit === $recipe->units[$i]? "selected": "" }} value="{{$unit->id }}">{{ $unit->name_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <p></p>
                        <input class="w-100 btn btn-danger w-10 col-4" type='button' value='Delete ingredient'/>
                    </div>
                </div>
            @endfor
        </div>
        <button id="add-ingredient" type="button" class="btn btn-primary my-3">Add ingredient</button>
    </div>

    <div class="row p-3">
        <h4 class="col-2 my-auto">Calories info :</h4>
        <div class="form-group col-2">
            <p class="d-inline">Calories</p>
            <input  class="form-control" type="text" name="calories" value="{{$recipe->calories}}">
        </div>
        <div class="form-group col-2">
            <p class="d-inline">Fat</p>
            <input  class="form-control" type="text" name="fat" value="{{$recipe->fat}}">
        </div>
        <div class="form-group col-2">
            <p class="d-inline">Protein</p>
            <input  class="form-control" type="text" name="protein" value="{{$recipe->protein}}">
        </div>
        <div class="form-group col-2">
            <p class="d-inline">Carbs</p>
            <input class="form-control"  type="text" name="carbs" value="{{$recipe->carbs}}">
        </div>
    </div>

    <div class="row p-3">
        <h3>Choose category for meal</h3>
        <select name="category" class="form-select">
            <option value="-">Choose category</option>
            @foreach ($categories as $category)
                <option {{ $category->name_category === $recipe->name_category? "selected": "" }} value="{{ $category->id }}">{{ $category->name_category }}</option>
            @endforeach
        </select>
    </div>

    <div class="row p-3">
        <h3>Time to make meal</h3>
        <div class="row">
            <div class="col-6 row">
                <div class="col-8">
                    <p>Time to prepare meal</p>
                    <input class="form-control" type="number" name="time_to_prepare" value="{{$recipe->prep_time}}">
                </div>
                <div class="col-4">
                    <p>Unit</p>
                    <select name="time_to_prepare_unit" class="form-select">
                        <option value="">Choose unit</option>
                        @foreach ($units as $unit)
                            @if ($unit->name_unit === "hour" || $unit->name_unit === "minutes")
                            <option {{ $recipe->id_prep_time_unit === $unit->id? "selected": "" }} value="{{$unit->id }}">{{ $unit->name_unit }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6 row">
                <div class="col-8">
                    <p>Time to cook meal</p>
                    <input class="form-control" type="number" name="time_cook_meal" value="{{$recipe->cook_time}}">
                </div>
                <div class="col-4">
                    <p>Unit</p>
                    <select name="time_cook_meal_unit" class="form-select">
                        <option value="">Choose unit</option>
                        @foreach ($units as $unit)                            
                            @if ($unit->name_unit === "hour" || $unit->name_unit === "minutes")
                                <option {{ $recipe->id_cook_time_unit === $unit->id? "selected": "" }} value="{{$unit->id }}">{{ $unit->name_unit }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-info w-100">Add</button>
</form>