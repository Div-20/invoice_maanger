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
        Schema::create('dynamic_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('order_by');
            $table->string('label');
            $table->text('note')->nullable();
            $table->integer('input_type');
            $table->boolean('required');
            $table->boolean('disabled');
            $table->string('placeholder')->nullable();
            $table->string('default')->nullable();
            $table->boolean('multiple');
            $table->text('options');
            $table->timestamps();
            $table->boolean('status')->default(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dynamic_forms');
    }
};
