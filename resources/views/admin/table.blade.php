
<div class="container">
    @if ($approved_view)
        <h1>Approved recipes</h1>
    @else
        <h1>Not approved recipes</h1>
    @endif
    @if (session("success"))
        <div class="alert alert-success">
            <li>{{session("success")}}</li>
        </div>
    @endif
    <table class="table">
        <thead>
            <td>Name recipe</td>
            <td>Is for breakfast</td>
            <td>Is for dinner</td>
            <td>Is for lunch</td>
            <td>Is for snack</td>
            <td>Category</td>
            <td>Calories</td>
            <td>Protein</td>
            <td>Fat</td>
            <td>Carbs</td>
            <td>Description</td>
            <td>Ingredients</td>
            <td>Actions</td>
        </thead>
        <tbody>
            @foreach ($recipes as $recipe)
                <tr>
                    <td>{{$recipe->name_recipe}}</td>
                    @php
                        $meal_type = [
                            $recipe->is_breakfast,
                            $recipe->is_dinner,
                            $recipe->is_lunch,
                            $recipe->is_snack,
                        ];
                    @endphp
                    @foreach ($meal_type as $single_meal)
                        @if ($single_meal)
                            <td><button class="btn btn-success">Yes</button></td>
                        @else
                            <td><button class="btn btn-danger">No</button></td>
                        @endif
                    @endforeach
                    <td>{{ $recipe->name_category }}</td>
                    <td>{{ $recipe->calories ?? null }}</td>
                    <td>{{ $recipe->protein }}</td>
                    <td>{{ $recipe->fat }}</td>
                    <td>{{ $recipe->carbs }}</td>
                    <td>{{ $recipe->description }}</td>
                    <td>
                        @for ($i = 0; $i < count($recipe->ingredients); $i++)
                            {{ $recipe->ingredients[$i] }}: {{ $recipe->quantities[$i] }}{{ $recipe->units[$i] }}<hr>
                        @endfor
                    </td>
                    <td>
                        @if (!$approved_view)
                            <a href="/admin/not-approved-recipes/approve/{{$recipe->id_recipe}}" class="btn btn-success">Approved</a>
                        @endif
                        <a href="/admin/recipe/delete/{{$recipe->id_recipe}}" class="btn btn-danger delete-recipe">Delete</a>
                        <a href="/admin/recipe/edit/{{$recipe->id_recipe}}" class="btn btn-warning my-3">Edit</a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>