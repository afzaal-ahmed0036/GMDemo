<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('dish_id');
            $table->unsignedInteger('dish_type_id')->nullable();
            $table->unsignedInteger('item_id')->nullable();
            $table->string('base_unit_amount_cooked')->nullable();
            $table->string('child_unit_amount_cooked')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dish_recipes');
    }
};
