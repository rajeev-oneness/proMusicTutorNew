<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        $preview_video = [
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyrides.mp4',
        ];

        $lession_video = [
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/SubaruOutbackOnStreetAndDirt.mp4',
            'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4'
        ];

        $lession = DB::table('product_series_lessions')->get();

        foreach ($lession as $key => $value) {
            DB::table('product_series_lessions')->where('id',$value->id)->update([
                'preview_video' => $preview_video[rand(0, count($preview_video)-1)], 
                'video' => $lession_video[rand(0, count($lession_video)-1)],
            ]);
        }
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
