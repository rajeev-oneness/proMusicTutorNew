<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductSeriesLessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_series_lessions', function (Blueprint $table) {
            $table->string('preview_video')->after('price_euro');
            $table->string('video')->after('preview_video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_series_lessions', function (Blueprint $table) {
            $table->dropColumn('preview_video');
            $table->dropColumn('video');
        });
    }
}
