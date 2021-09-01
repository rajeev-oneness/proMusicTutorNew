<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToGuitarLessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guitar_lessions', function (Blueprint $table) {
            $table->double('gbp', 8, 2)->default('0.00')->after('price');
            $table->double('price_usd', 8, 2)->default('0.00')->after('gbp');
            $table->double('price_euro', 8, 2)->default('0.00')->after('price_usd');
            $table->string('status')->default('active')->after('description');
            $table->string('keywords')->after('status');
            $table->integer('genre')->after('keywords');
            $table->string('item_clean_url')->after('genre');
            $table->string('product_code')->after('item_clean_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guitar_lessions', function (Blueprint $table) {
            $table->dropColumn('gbp');
            $table->dropColumn('price_usd');
            $table->dropColumn('price_euro');
            $table->dropColumn('status');
            $table->dropColumn('keywords');
            $table->dropColumn('genre');
            $table->dropColumn('item_clean_url');
            $table->dropColumn('product_code');
        });
    }
}
