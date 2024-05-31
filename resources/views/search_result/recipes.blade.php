@include('partials.header')
<div class="container">

    <div class="row">
        @foreach ($recipes as $recipe)
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>{{$recipe->name_recipe}}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{$recipe->description}}</p>
                        This meal suits bests for:
                        @if ($recipe->is_breakfast)
                            breakfast
                        @endif
                        @if ($recipe->is_lunch)
                            lunch
                        @endif
                        @if ($recipe->is_dinner)
                            dinner
                        @endif
                        @if ($recipe->is_snack)
                            snack
                        @endif
                        <hr>
                        <h5 class="mt-3">Ingredients</h5>
                        <table class="table">
                            <thead>
                                <td>ingredient</td>
                                <td>Quantity</td>
                                <td>Unit</td>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($recipe->ingredients); $i++)
                                    <tr>
                                        <td>{{$recipe->ingredients[$i]}}</td>
                                        <td>{{$recipe->quantities[$i]}}</td>
                                        <td>{{$recipe->units[$i]}}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        Nutrions info:
                        <div class="bg-success text-white">
                            Calories: {{ $recipe->calories }}
                            Carbs: {{ $recipe->carbs }}
                            Fat: {{ $recipe->fat }}
                            Protein: {{ $recipe->protein }}
                        </div>
                        Category: {{$recipe->name_category}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>