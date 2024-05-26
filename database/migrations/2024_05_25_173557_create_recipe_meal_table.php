<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_meal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_meal_type');
            $table->unsignedBigInteger('id_recipe');

            $table->foreign('id_meal_type')
                ->references('id')->on('meal_types')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('id_recipe')
                ->references('id')->on('recipes')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_meal');
    }
};
