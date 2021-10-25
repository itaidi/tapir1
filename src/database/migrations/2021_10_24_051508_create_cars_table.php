<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("brand");
            $table->string("model");
            $table->string("vin");
            $table->string("body_type");
            $table->string("engine_type");
            $table->string("drive_type");
            $table->string("gearbox_type");
            $table->decimal("year");
            $table->decimal("price");
            $table->decimal("mileage"); // для подержаных
            $table->decimal("ownercount");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
