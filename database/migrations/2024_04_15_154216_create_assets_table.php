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
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id');
            $table->longText('asset_json');
            // $table->string('Asset Name');
            // Material
            // Description
            // Brand
            // Model
            // Capacity
            // Year of Mfg
            // Year of purchase
            // Working Condition
            // Remark
            // Ref. No.
            // Allocated to
            // Re located to
            $table->integer('created_by');
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
        Schema::dropIfExists('assets');
    }
};
