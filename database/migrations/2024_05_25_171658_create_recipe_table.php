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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_category');
            $table->string('name_recipe', 50);
            $table->string('description', 255);
            $table->integer('cook_time');
            $table->integer('prep_time');
            $table->integer('fat');
            $table->integer('carbs');
            $table->integer('protein');
            $table->integer('calories');
            $table->integer('id_cook_time_unit');
            $table->integer('id_prep_time_unit');
            $table->timestamps();

            $table->foreign('id_category')
                ->references('id')->on('categories')
                ->onUpdate('restrict')
                ->onDelete('restrict')
                ->name('fk_recipe_category');
    
            $table->foreign('id_user')
                ->references('id')->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict')
                ->name('fk_recipe_user');
    
            $table->foreign('id_cook_time_unit')
                ->references('id')->on('units')
                ->onUpdate('restrict')
                ->onDelete('restrict')
                ->name('fk_recipe_cook_time_unit');
    
            $table->foreign('id_prep_time_unit')
                ->references('id')->on('units')
                ->onUpdate('restrict')
                ->onDelete('restrict')
                ->name('fk_recipe_prep_time_unit');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe');
    }
};
