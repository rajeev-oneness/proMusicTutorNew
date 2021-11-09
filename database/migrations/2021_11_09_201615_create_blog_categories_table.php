<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            ['title' => "Guitar Tips"],
            ['title' => "History"],
            ['title' => "How-To"],
            ['title' => "Interviews"],
            ['title' => "Music Industry"],
            ['title' => "Prolinks Guitar"],
            ['title' => "Prolinks Lessons"],
            ['title' => "Prolinks Tutor`s Profile"],
            ['title' => "Saxophone Tips"],
            ['title' => "Uncategorized"],
        ];

        DB::table('blog_categories')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_categories');
    }
}
