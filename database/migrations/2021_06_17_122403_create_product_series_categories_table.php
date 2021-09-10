<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSeriesCategoriesTable extends Migration
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
            $table->bigInteger('instrumentId');
            $table->string('name',150);
            $table->string('image',150);
            $table->longText('description')->comment('Optional');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            [
                'instrumentId' => 1,
                'name' => 'Pro Licks',
                'image' => '/design/img/guitar_1.png'
            ],
            [
                'instrumentId' => 1,
                'name' => 'Techniques',
                'image' => '/design/img/guitar_2.png'
            ],
            [
                'instrumentId' => 1,
                'name' => 'Popular Songs',
                'image' => '/design/img/guitar_3.png'
            ],
            [
                'instrumentId' => 2,
                'name' => 'Pro Licks',
                'image' => '/design/img/guitar_1.png'
            ],
            [
                'instrumentId' => 2,
                'name' => 'Techniques',
                'image' => '/design/img/guitar_2.png'
            ],
            [
                'instrumentId' => 2,
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
