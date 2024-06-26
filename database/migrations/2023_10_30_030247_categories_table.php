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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id', 50);
            $table->foreignId('parent_id')->nullable();
            $table->string('name', 50);
            $table->string('description')->nullable();
            $table->integer('icon')->nullable();
            $table->integer('image')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(10);

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->dropForeign('categories_parent_id_foreign');
        });
        Schema::dropIfExists('categories');
    }
};
