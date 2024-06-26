<?php

use App\Models\LocationCity;
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
        Schema::create('location_cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->tinyInteger('tier_type');
            $table->mediumInteger('state_id');
            $table->integer('district_id')->nullable();
            $table->tinyInteger('region_status')->default(0);
            $table->integer('pin_code');
            $table->string('icon');
            $table->timestamps();
            $table->tinyInteger('status')->default(LocationCity::STATUS_ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_cities');
    }
};
