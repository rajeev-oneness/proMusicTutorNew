<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transactionId');
            $table->string('entity');
            $table->float('amount',8,2);
            $table->string('currency');
            $table->string('status');
            $table->string('order_id');
            $table->string('invoice_id');
            $table->string('international');
            $table->string('method');
            $table->string('amount_refunded');
            $table->string('refund_status');
            $table->string('captured');
            $table->longText('description');
            $table->string('card_id');
            $table->string('bank');
            $table->string('wallet');
            $table->string('vpa');
            $table->string('email');
            $table->string('contact');
            $table->string('created_at_time');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
