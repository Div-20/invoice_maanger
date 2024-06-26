<?php

use App\Models\Faq;
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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->integer('parent_id')->nullable();
            $table->mediumInteger('order_by')->default(0);
            $table->string('title');
            $table->longText('description')->default(NULL);
            $table->timestamps();
            $table->tinyInteger('status')->default(Faq::STATUS_ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
};
