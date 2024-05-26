<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRecipesIngredientsForeignKey extends Migration
{
    public function up()
    {
        Schema::table('recipes_ingredients', function (Blueprint $table) {

            // Add the correct foreign key constraint
            $table->foreign('id_ingredient')
                ->references('id')->on('ingredients')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        // Since this is a correction, the down method can remain empty
    }
}
