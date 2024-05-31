<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = DB::select("CALL GET_UNITS()");
        $categories = DB::select("CALL GET_CATEGORIES()");
        return view('home.home_page', ["units" => $units, "categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = DB::select("CALL GET_UNITS()");
        $categories = DB::select("CALL GET_CATEGORIES()");
        return  view("recipe.add_recipe", ["units" => $units, "categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name_recipe" => "required|string|min:3",
            "description" => "required|string|min:3|max:255",
            "meal_type" => "required|array|min:1",
            "ingredients" => "required|array|min:1",
            "units" => "required|array|min:1",
            "quantity" => "required|array|min:1",
            "calories" => "numeric",
            "fat" => "numeric",
            "carbs" => "numeric",
            "category" => "required|numeric", // i am taking category id
            "time_to_prepare" => "required|numeric",
            "time_to_prepare_unit" => "required|numeric",
            "time_cook_meal" => "required|numeric",
            "time_cook_meal_unit" => "required|numeric",
        ]);

        if (count($request->input("ingredients")) !== count($request->input("units")) || count($request->input("ingredients")) !== count($request->input("quantity"))) {
            return redirect()->back()->withErrors(["mistake" => ["Please make sure that every ingredient has quantity and unit"]]);
        }

        try {
            DB::statement(
                "CALL ADD_RECIPE_INFO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    Auth::id(),
                    $request->input("name_recipe"),
                    $request->input("description"),
                    $request->input("calories"),
                    $request->input("protein"),
                    $request->input("fat"),
                    $request->input("carbs"),
                    $request->input("category"),
                    $request->input("time_to_prepare"),
                    $request->input("time_to_prepare_unit"),
                    $request->input("time_cook_meal"),
                    $request->input("time_cook_meal_unit")
                ]
            );

            $id_recipe = DB::select("SELECT LAST_INSERT_ID();");
            $id_recipe = $id_recipe[0]->{'LAST_INSERT_ID()'};

            // insert ingredients if there is not in the db
            foreach ($request->input("ingredients") as $ingredient) {
                DB::statement("CALL INSERT_INGREDIENT(?)", [strtolower($ingredient)]);
            }

            // insert is lunch, dinner, snack, breakfast
            foreach ($request->input("meal_type") as $meal_type) {
                DB::statement("CALL INSERT_MEAL_TYPE(?, ?)", [$id_recipe, $meal_type]);
            }

            // insert ingredients for recipe
            $number_of_qunatity_unit = 0;
            foreach ($request->input("ingredients") as $ingredient) {
                DB::statement("CALL INSERT_RECIPE_INGREDIENT(?, ?, ?, ?)", [
                    $ingredient,
                    $id_recipe,
                    $request->input("quantity")[$number_of_qunatity_unit],
                    $request->input("units")[$number_of_qunatity_unit],
                ]);
                $number_of_qunatity_unit++;
            }
            return redirect()->back()->with("success", "Successfully added new recipe");
        } catch (\Exception $e) {
            // Handle the error
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function search(Request $request)
    {
        $range = 0.1; // for calories, carbs, fat, protein
        $search_params = [
            "name_recipe",
            "calories",
            "fat",
            "carbs",
            "protein",
            "id_category"
        ];

        $bindings = [];
        $where = ["WHERE r.approved = 1"]; // Initial dummy condition for easier concatenation

        foreach ($search_params as $key) {
            if ($request->filled($key)) {
                if ($key === "calories" || $key === "fat" || $key === "carbs" || $key === "protein") {
                    $bindings[] = $request->input($key) - ($request->input($key) * $range); // min
                    $bindings[] = $request->input($key) + ($request->input($key) * $range); // max
                    $where[] = "$key BETWEEN ? AND ?";
                } else {
                    $where[] = "$key = ?";
                    $bindings[] = $request->input($key);
                }
            }
        }

        if ($request->filled("ingredients")) {
            $ingredients = $request->input("ingredients");
            $number_of_ingredients = count($ingredients);
            $placeholders = implode(', ', array_fill(0, $number_of_ingredients, '?'));

            $where[] = "r.id IN (
                SELECT ri.id_recipe
                FROM recipes_ingredients ri
                INNER JOIN ingredients i ON ri.id_ingredient = i.id
                WHERE i.name_ingredient IN ($placeholders)
                GROUP BY ri.id_recipe
                HAVING COUNT(DISTINCT i.id) = ?
            )";

            $bindings = array_merge($bindings, $ingredients);
            $bindings[] = $number_of_ingredients;
        }

        $whereText = implode(' AND ', $where);

        $query = "
        SELECT 
            r.id AS id_recipe,
            r.name_recipe AS name_recipe,
            cat.name_category AS name_category,
            r.description AS description,
            r.carbs AS carbs,
            r.fat AS fat,
            r.calories AS calories,
            r.protein AS protein,
            MAX(CASE WHEN mt.meal_type = 'breakfast' THEN 1 ELSE 0 END) AS is_breakfast,
            MAX(CASE WHEN mt.meal_type = 'snack' THEN 1 ELSE 0 END) AS is_snack,
            MAX(CASE WHEN mt.meal_type = 'lunch' THEN 1 ELSE 0 END) AS is_lunch,
            MAX(CASE WHEN mt.meal_type = 'dinner' THEN 1 ELSE 0 END) AS is_dinner,
            ri.quantity AS quantity,
            i.name_ingredient AS name_ingredient,
            uni.name_unit,
            r.prep_time AS prep_time,
            r.cook_time AS cook_time,
            r.id_prep_time_unit AS id_prep_time_unit,
            r.id_cook_time_unit AS id_cook_time_unit
        FROM 
            RECIPES r
        INNER JOIN
            categories cat ON r.id_category = cat.id
        INNER JOIN
            RECIPE_MEAL rmt ON r.id = rmt.id_recipe
        INNER JOIN 
            MEAL_TYPES mt ON rmt.id_meal_type = mt.id
        LEFT JOIN 
            RECIPES_INGREDIENTS ri ON r.id = ri.id_recipe
        INNER JOIN 
            UNITS uni ON ri.id_unit_quantity = uni.id
        LEFT JOIN 
            INGREDIENTS i ON ri.id_ingredient = i.id
        $whereText
        GROUP BY
            r.id,
            r.name_recipe,
            r.description,
            cat.name_category,
            r.carbs,
            r.fat,
            r.calories,
            r.protein,
            ri.quantity,
            i.name_ingredient,
            uni.name_unit,
            r.prep_time,
            r.cook_time,
            r.id_prep_time_unit,
            r.id_cook_time_unit;
        ";

        $result = DB::select($query, $bindings);
        $recipes = $this->groupByRecipe($result);
        if (empty($result)) {
            return redirect("/#search-message")->with(
                ["no-recipe"=>"There is not recipe with these requirements. Do you want to add recipe"]);
        }
        return view("search_result.page_content", compact("recipes"));
    }



    public function approvedRecipes()
    {
        $recipes_data = DB::select("CALL APPROVED_RECIPES()");
        $recipes = $this->groupByRecipe($recipes_data);
        return view('admin.approved_recipes', compact("recipes"));
    }

    public function notApprovedRecipes()
    {
        $recipes_data = DB::select("CALL NOT_APPROVED_RECIPES()");
        $recipes = $this->groupByRecipe($recipes_data);
        $units = DB::select("CALL GET_UNITS()");
        $categories = DB::select("CALL GET_CATEGORIES()");
        return view('admin.not_approved_recipes', compact("recipes"));
    }

    public function approve(string $id)
    {

        DB::statement("CALL APPROVE_RECIPE(?)", [$id]);
        return redirect()->back()->with(["success"=>"Successfully approved recipe"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $recipe = DB::select("CALL GET_RECIPE(?)", [$id]);
        $recipe = $this->groupByRecipe($recipe)[$id];
        $units = DB::select("CALL GET_UNITS()");
        $categories = DB::select("CALL GET_CATEGORIES()");
        return view("recipe.edit_recipe", compact("recipe", "units", "categories"));     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            "id_recipe" => "required|numeric",
            "name_recipe" => "string|min:3",
            "description" => "string|min:3|max:255",
            "meal_type" => "array|min:1",
            "ingredients" => "array|min:1",
            "units" => "array|min:1",
            "quantity" => "array|min:1",
            "calories" => "numeric",
            "fat" => "numeric",
            "carbs" => "numeric",
            "category" => "numeric", // i am taking category id
            "time_to_prepare" => "numeric",
            "time_to_prepare_unit" => "numeric",
            "time_cook_meal" => "numeric",
            "time_cook_meal_unit" => "numeric",
        ]);

        if (count($request->input("ingredients")) !== count($request->input("units")) || count($request->input("ingredients")) !== count($request->input("quantity"))) {
            return redirect()->back()->withErrors(["mistake" => ["Please make sure that every ingredient has quantity and unit"]]);
        }

        try {

            DB::statement(
                "CALL EDIT_RECIPE_INFO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $request->input("id_recipe"),
                    $request->input("name_recipe"),
                    $request->input("description"),
                    $request->input("calories"),
                    $request->input("protein"),
                    $request->input("fat"),
                    $request->input("carbs"),
                    $request->input("category"),
                    $request->input("time_to_prepare"),
                    $request->input("time_to_prepare_unit"),
                    $request->input("time_cook_meal"),
                    $request->input("time_cook_meal_unit")
                ]
            );

            $id_recipe = $request->input("id_recipe");
            $is_success = 0;
            // call procedure delete everything from recipes_ingredients
            $result = DB::select("CALL DELETE_INGREDIENTS_IN_RECIPE(?, ?)", [$id_recipe, $is_success]);
            if(!isset($result))
            {
                throw new Exception("Error happend during deleting ingredients $result");
            }
            // call procedure delete everything from recies_meal_types
            $result = DB::select("CALL DELETE_MEALS_FOR_RECIPE(?, ?)", [$id_recipe, $is_success]);
            if(!isset($result))
            {
                throw new Exception("Error happend deleting meals $result");
            }
            // insert ingredients if there is not in the db
            foreach ($request->input("ingredients") as $ingredient) {
                DB::statement("CALL INSERT_INGREDIENT(?)", [strtolower($ingredient)]);
            }
            // insert is lunch, dinner, snack, breakfast
            foreach ($request->input("meal_type") as $meal_type) {
                DB::statement("CALL INSERT_MEAL_TYPE(?, ?)", [$id_recipe, $meal_type]);
            }

            // insert ingredients for recipe
            $number_of_qunatity_unit = 0;
            foreach ($request->input("ingredients") as $ingredient) {
                DB::statement("CALL INSERT_RECIPE_INGREDIENT(?, ?, ?, ?)", [
                    $ingredient,
                    $id_recipe,
                    $request->input("quantity")[$number_of_qunatity_unit],
                    $request->input("units")[$number_of_qunatity_unit],
                ]);
                $number_of_qunatity_unit++;
            }
            return redirect()->back()->with("success", "Successfully edited new recipe");
        } catch (\Exception $e) {
            // Handle the error
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::statement("CALL DELITE_RECIPE(?)", [$id]);
        return redirect()->back()->with(["success"=>"Succesfully deleted recipe"]);
    }

    private function groupByRecipe(array $recipes_data)
    {
        $recipes = [];
        for($i = 0; $i<count($recipes_data); $i++)
        {
            $recipes[$recipes_data[$i]->id_recipe] = 
            $recipes[$recipes_data[$i]->id_recipe] ?? $recipes_data[$i]; 

            $recipes[$recipes_data[$i]->id_recipe]->ingredients[] = $recipes_data[$i]->name_ingredient;
            $recipes[$recipes_data[$i]->id_recipe]->quantities[] = $recipes_data[$i]->quantity;
            $recipes[$recipes_data[$i]->id_recipe]->units[] = $recipes_data[$i]->name_unit;
        }
        return $recipes;
    }
}
