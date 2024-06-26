<?php

use App\Models\LeadManagements;
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
        Schema::create('lead_managements', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('unique_id')->unique();
            $table->smallInteger('type');
            $table->integer('service_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_mobile')->nullable();
            $table->integer('staff_id')->nullable();
            $table->string('link')->nullable();
            $table->longText('content')->nullable();
            $table->integer('counter')->default(0);
            $table->string('call_date')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(LeadManagements::STATUS_ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_managements');
    }
};
