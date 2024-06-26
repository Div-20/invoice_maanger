<?php

use Carbon\Carbon;
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
        Schema::create('auto_increments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('auto_user')->default(10000);
            $table->bigInteger('auto_cart')->default(10000);
            $table->bigInteger('auto_product')->default(10000);
            $table->bigInteger('auto_order')->default(10000);
            $table->bigInteger('auto_sub_admin')->default(10000);
            $table->bigInteger('auto_category')->default(10000);
            $table->bigInteger('auto_brand')->default(10000);
            $table->bigInteger('auto_transaction')->default(10000);
            $table->bigInteger('auto_leads')->default(10000);
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_increments');
    }
};
