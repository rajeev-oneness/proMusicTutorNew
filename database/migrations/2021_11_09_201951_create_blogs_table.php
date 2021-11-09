<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blogCategoryId');
            $table->string('title');
            $table->string('image');
            $table->longText('description');
            $table->bigInteger('createdBy');
            $table->longText('tags')->comment('tagId are stored here with Comma Separated');
            $table->longText('facebook_link');
            $table->longText('twitter_link');
            $table->longText('instagram_link');
            $table->longText('youtube_link');
            $table->longText('google_link');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
