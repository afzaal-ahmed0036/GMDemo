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
        Schema::table('pos_setting', function (Blueprint $table) {
            $table->string('is_dish_enabled')->default(1)->after('stripe_secret_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_setting', function (Blueprint $table) {
            $table->dropColumn('is_dish_enabled');
        });
    }
};
