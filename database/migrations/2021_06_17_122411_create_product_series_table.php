<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_series', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('instrumentId');
            $table->bigInteger('categoryId');
            $table->string('title');
            $table->longText('description');
            $table->string('image');
            $table->string('video_url');
            // New Column Addition
            $table->double('gbp', 8, 2);
            $table->double('price_usd', 8, 2);
            $table->double('price_euro', 8, 2);
            $table->integer('genre');
            $table->longText('item_clean_url');
            $table->longText('seo_meta_description');
            $table->string('seo_meta_keywords');
            // End
            $table->bigInteger('createdBy');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [];
        $category = DB::table('categories')->get();
        foreach ($category as $key => $cat) {
            $data[] = [
                'categoryId' => $cat->id,
                'instrumentId' => $cat->instrumentId,
                'title' => 'Building The Blues Series '.($key + 1),
                'description' => "Learn from Micky Moody the legendary Whitesnake guitarist. In this series Micky 's aim is to pass on ....",
                'image' => '/design/img/guitar_'.($key+1).'.png',
                'video_url' => 'https://player.vimeo.com/video/137857207',
                'createdBy' => 2,
            ];
        }
        DB::table('product_series')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_series');
    }
}
