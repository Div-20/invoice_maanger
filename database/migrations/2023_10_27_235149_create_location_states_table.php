<?php

use App\Models\LocationStates;
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
        Schema::create('location_states', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 50);
            $table->integer('country_id');
            $table->timestamps();
            $table->tinyInteger('status')->default(LocationStates::STATUS_ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_states');
    }
};
