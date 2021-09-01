<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToGuitarSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guitar_series', function (Blueprint $table) {
            $table->double('gbp', 8, 2)->default('0.00')->after('video_url');
            $table->double('price_usd', 8, 2)->default('0.00')->after('gbp');
            $table->double('price_euro', 8, 2)->default('0.00')->after('price_usd');
            $table->integer('genre')->after('price_euro');
            $table->string('difficulty', 20)->after('genre');
            $table->string('item_clean_url')->after('difficulty');
            $table->string('seo_meta_description')->after('item_clean_url');
            $table->string('seo_meta_keywords')->after('seo_meta_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guitar_series', function (Blueprint $table) {
            $table->dropColumn('gbp');
            $table->dropColumn('price_usd');
            $table->dropColumn('price_euro');
            $table->dropColumn('genre');
            $table->dropColumn('difficulty');
            $table->dropColumn('item_clean_url');
            $table->dropColumn('seo_meta_description');
            $table->dropColumn('seo_meta_keywords');
        });
    }
}
