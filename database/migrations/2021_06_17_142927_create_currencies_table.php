<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('iso',20);
            $table->string('name',100);
            $table->string('symbol',50);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            [
                'iso' => 'INR',
                'name' => 'Indian Rupee',
                'symbol' => '₹',
            ],
            [
                'iso' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
            ],
            [
                'iso' => 'GBP',
                'name' => 'British Pound',
                'symbol' => '£',
            ],
        ];
        DB::table('currencies')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
