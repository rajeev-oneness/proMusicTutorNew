<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuitarSeriesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('image',150);
            $table->longText('description')->comment('Optional');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            [
                'name' => 'Pro Licks',
                'image' => '/design/img/guitar_1.png'
            ],
            [
                'name' => 'Techniques',
                'image' => '/design/img/guitar_2.png'
            ],
            [
                'name' => 'Popular Songs',
                'image' => '/design/img/guitar_3.png'
            ]
        ];
        DB::table('categories')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
