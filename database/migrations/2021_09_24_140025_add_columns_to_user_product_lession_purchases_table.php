<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUserProductLessionPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_product_lession_purchases', function (Blueprint $table) {
            $table->string('type_of_product', 50)->after('transactionId');
            $table->integer('offerId')->after('type_of_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_product_lession_purchases', function (Blueprint $table) {
            $table->dropColumn('type_of_product');
            $table->dropColumn('offerId');
        });
    }
}
