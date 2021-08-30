<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuitarSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guitar_series', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('categoryId');
            $table->string('title');
            $table->longText('description');
            $table->string('image');
            $table->string('video_url');
            $table->bigInteger('createdBy');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'categoryId' => 1,
                'title' => 'Building The Blues Series 1',
                'description' => "Learn from Micky Moody the legendary Whitesnake guitarist. In this series Micky 's aim is to pass on ....",
                'image' => '/design/img/guitar_3.png',
                'video_url' => 'https://player.vimeo.com/video/137857207',
                'createdBy' => 2,
            ],
            [
                'categoryId' => 1,
                'title' => 'Building The Blues Series 1',
                'description' => "Learn from Micky Moody the legendary Whitesnake guitarist. In this series Micky 's aim is to pass on ....",
                'image' => '/design/img/guitar_2.png',
                'video_url' => 'https://player.vimeo.com/video/137857207',
                'createdBy' => 2,
            ],
            [
                'categoryId' => 2,
                'title' => 'Building The Blues Series 1',
                'description' => "Learn from Micky Moody the legendary Whitesnake guitarist. In this series Micky 's aim is to pass on ....",
                'image' => '/design/img/guitar_1.png',
                'video_url' => 'https://player.vimeo.com/video/137857207',
                'createdBy' => 3,
            ],
            [
                'categoryId' => 2,
                'title' => 'Building The Blues Series 1',
                'description' => "Learn from Micky Moody the legendary Whitesnake guitarist. In this series Micky 's aim is to pass on ....",
                'image' => '/design/img/guitar_4.png',
                'video_url' => 'https://player.vimeo.com/video/137857207',
                'createdBy' => 3,
            ],
            [
                'categoryId' => 3,
                'title' => 'Building The Blues Series 1',
                'description' => "Learn from Micky Moody the legendary Whitesnake guitarist. In this series Micky 's aim is to pass on ....",
                'image' => '/design/img/guitar_5.png',
                'video_url' => 'https://player.vimeo.com/video/137857207',
                'createdBy' => 4,
            ],
            [
                'categoryId' => 3,
                'title' => 'Building The Blues Series 1',
                'description' => "Learn from Micky Moody the legendary Whitesnake guitarist. In this series Micky 's aim is to pass on ....",
                'image' => '/design/img/guitar_6.png',
                'video_url' => 'https://player.vimeo.com/video/137857207',
                'createdBy' => 4,
            ],
        ];
        DB::table('guitar_series')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guitar_series');
    }
}
