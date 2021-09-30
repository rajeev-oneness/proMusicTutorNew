<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DropAddAtterSomeTableon30Sept20212PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `product_series` CHANGE `gbp` `price_gbp` DOUBLE(8,2) NOT NULL");

        DB::statement("ALTER TABLE `product_series_lessions` CHANGE `gbp` `price_gbp` FLOAT(8,2) NOT NULL");

        DB::statement("ALTER TABLE `product_series_lessions` CHANGE `price_usd` `price_usd` FLOAT(8,2) NOT NULL, CHANGE `price_euro` `price_euro` FLOAT(8,2) NOT NULL");

        DB::statement("ALTER TABLE `product_series_lessions` DROP `price`");

        DB::statement("ALTER TABLE `product_series` CHANGE `price_gbp` `price_gbp` FLOAT(8,2) NOT NULL, CHANGE `price_usd` `price_usd` FLOAT(8,2) NOT NULL, CHANGE `price_euro` `price_euro` FLOAT(8,2) NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
