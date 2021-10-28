<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumntoUserPurchaseLessionSeriesTableon28Oct20210604PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_product_lession_purchases', function (Blueprint $table) {
            $table->bigInteger('authorId')->after('offerId');
        });

        // Previous Migration Table Problem Will Resolving Here
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('createdBy');
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->bigInteger('createdBy')->after('id');
        });
        DB::table('offers')->update(['createdBy' => 2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_product_lession_purchases', function (Blueprint $table) {
            $table->dropColumn('authorId');
        });

        // Previous Migration Table Problem Will Resolving Here
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('createdBy');
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->string('createdBy')->after('id');
        });
        DB::table('offers')->update(['createdBy' => 2]);
    }
}
