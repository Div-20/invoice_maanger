<?php

use App\Helpers\SiteConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id', '50');
            $table->string('referral', '50')->nullable();
            $table->dateTime('prime')->nullable();
            $table->tinyInteger('role')->default(SiteConstants::ROLE_USER);
            $table->string('name');
            $table->string('email')->unique();
            $table->bigInteger('mobile')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('image')->nullable();
            $table->integer('country')->nullable();
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->integer('area')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('block')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
