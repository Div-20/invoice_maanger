<?php

use App\Models\LocationCountry;
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
        Schema::create('location_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('code', 200);
            $table->string('capital', 100)->nullable();
            $table->string('currency', 200)->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(LocationCountry::STATUS_ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_countries');
    }
};
