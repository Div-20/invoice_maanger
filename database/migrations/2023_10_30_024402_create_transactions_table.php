<?php

use App\Models\Transactions;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unique_id', 50);
            $table->bigInteger('wallet_id')->unsigned();
            $table->tinyInteger('type');
            $table->tinyInteger('reason');
            $table->double('amount', 6, 2);
            $table->double('total_tax', 6, 2)->default(0);
            $table->double('additional_amount', 6, 2)->default(0);
            $table->timestamps();
            $table->tinyInteger('status')->default(Transactions::STATUS_SUCCESS);

            $table->foreign('wallet_id')->references('id')->on('wallets')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_wallet_id_foreign');
        });

        Schema::dropIfExists('transactions');
    }
};
