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
        Schema::create('recipes_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_recipe');
            $table->unsignedBigInteger('id_ingredient');
            $table->unsignedBigInteger('id_unit_quantity');
            $table->unsignedBigInteger("quantity");

            $table->foreign('id_recipe')
                ->references('id')->on('recipes')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('id_unit_quantity')
                ->references('id')->on('units')
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
        Schema::dropIfExists('recipes_ingredients');
    }
};
