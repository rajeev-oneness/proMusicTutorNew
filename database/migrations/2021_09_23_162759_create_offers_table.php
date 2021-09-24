<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->double('price_usd', 8, 2);
            $table->double('price_euro', 8, 2);
            $table->double('price_gbp', 8, 2);
            $table->string('title');
            $table->text('description');
            $table->text('offer_description');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'image' => 'design/img/guitar_1.png',
                'price_usd' => '19.99',
                'price_euro' => '27.99',
                'price_gbp' => '22.99',
                'title' => 'Buy Building The Blues Series 1, 2 & 3 by Denny Ilett and receive 25% Discount',
                'description' => 'Here is a great opportunity to purchase James Mortons Funk Licks Series 1,2,3 and receive Funk Licks Series 4 completely free. These Series are great from all levels of player from Beginner to Advanced',
                'offer_description' => 'This is a time limited bulk discount special offer. Buy Funk Licks 1,2 and 3 and you will receive Series 4 absolutely free.',
            ]
        ];

        DB::table('offers')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
