<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = DB::select("CALL GET_UNITS()");
        $categories = DB::select("CALL GET_CATEGORIES()");
        return  view("recipe.add_recipe", ["units"=> $units, "categories"=>$categories]);
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

        if(count($request->input("ingredients")) !== count($request->input("units")) || count($request->input("ingredients")) !== count($request->input("quantity")) )
        {
            return redirect()->back()->withErrors(["mistake"=>["Please make sure that every ingredient has quantity and unit"]]);
        }

        try {
            DB::statement("CALL ADD_RECIPE_INFO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
                [
                1,
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
            ]);

            $id_recipe = DB::select("SELECT LAST_INSERT_ID();");
            $id_recipe = $id_recipe[0]->{'LAST_INSERT_ID()'};

            // insert ingredients if there is not in the db
            foreach($request->input("ingredients") as $ingredient)
            {
                DB::statement("CALL INSERT_INGREDIENT(?)", [$ingredient]);
            }

            // insert is lunch, dinner, snack, breakfast
            foreach($request->input("meal_type") as $meal_type)
            {
                DB::statement("CALL INSERT_MEAL_TYPE(?, ?)", [$id_recipe, $meal_type]);
            }

            // insert ingredients for recipe
            $number_of_qunatity_unit = 0;
            foreach($request->input("ingredients") as $ingredient)
            {
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
