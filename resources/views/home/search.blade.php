<section id="search" class="container py-5">

    <h2 class="disaply-4">Search for recipes</h2>
    
    <form action="/search" method="POST">
        @csrf
        <div class="row p-3">
            <h4 class="col-2">Recipe for :</h4>
            <div class="form-group col-2">
                <p class="d-inline">Breakfast</p>
                <input type="checkbox" value="breakfast" name="meal_type[]">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Dinner</p>
                <input type="checkbox" value="dinner" name="meal_type[]">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Lunch</p>
                <input type="checkbox" value="lunch" name="meal_type[]">
            </div>
            <div class="form-group col-2">
                <p class="d-inline">Snack</p>
                <input type="checkbox" value="snack" name="meal_type[]">
            </div>
        </div>

        <div class="ingredients row p-3">
            <h4 class="col-2">Ingredients</h4>
            <div class="ingredients-input-parent" id="ingredients-container">
                <input class="form-control" type="text" name="ingredients[]">
            </div>
            <button id="add-ingredient" type="button" class="btn btn-primary my-3">Add more</button>
        </div>

        <div class="row p-3">
            <h4 class="col-2">Recipe calories info :</h4>
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
                <option value="0">Choose category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                @endforeach
            </select>
        </div>

        <div class="row p-3">
            <h3>Time to prepare meal</h3>
            <div class="row">
                <div class="form-group col-8">
                    <input class="form-control" type="number" name="time_to_make">
                </div>
                <div class="form-group col-4">
                    <select name="time_to_make_unit" class="form-select">
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
        <button type="submit" class="btn btn-info w-100">Search</button>
    </form>

</section>