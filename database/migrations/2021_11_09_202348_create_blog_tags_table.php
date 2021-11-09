<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            ['title' => 'Guitar Lessons'],
            ['title' => 'Guitar tips'],
            ['title' => 'Lessons'],
            ['title' => 'Music for Relaxation'],
            ['title' => 'Music Lessons'],
            ['title' => 'Online Music'],
            ['title' => 'Online Music Lessons'],
            ['title' => 'Pentatonic Scale'],
            ['title' => 'saxophone'],
            ['title' => 'saxophone lessons'],
            ['title' => 'Spanish Songs'],
            ['title' => 'tony remy'],
        ];
        DB::table('blog_tags')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_tags');
    }
}
