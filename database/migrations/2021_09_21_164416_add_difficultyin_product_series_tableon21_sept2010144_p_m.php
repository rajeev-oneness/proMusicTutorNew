<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDifficultyinProductSeriesTableon21Sept2010144PM extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_series', function (Blueprint $table) {
            $table->string('difficulty', 20)->after('video_url');
        });
        $product = DB::table('product_series')->get();
        $difficulty = ['Easy','Medium','Hard'];
        foreach ($product as $key => $value) {
            DB::table('product_series')->where('id',$value->id)->update(['difficulty' => $difficulty[rand(0,2)]]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_series', function (Blueprint $table) {
            $table->dropColumn(['difficulty']);
        });
    }
}
