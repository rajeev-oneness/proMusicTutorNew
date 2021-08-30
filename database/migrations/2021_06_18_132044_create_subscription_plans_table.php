<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->float('price',8,2);
            $table->integer('currencyId');
            $table->integer('valid_for')->comment('Valid In Months');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [];
        for ($i=0; $i < 6; $i++) { 
            $data[] = [
                'title' => 'Monthly Subscripton - Saxophone',
                'image' => '/design/img/guitar_'.($i+1).'.png',
                'currencyId' => 3,
                'price' => rand(5,9).'.99',
                'valid_for' => 1,
            ];
        }
        DB::table('subscription_plans')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
}
