<section id="search" class="container py-5">

    <h2 class="disaply-4">Search for recipes</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
    @endif
    <form action="/search" method="GET">
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
            <select name="id_category" class="form-select">
                <option value="">Choose category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-info w-100">Search</button>
    </form>

</section>