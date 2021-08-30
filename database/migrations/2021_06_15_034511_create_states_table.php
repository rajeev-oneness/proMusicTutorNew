<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->integer('countryId');
            $table->string('name');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            ['countryId' => 1,'name' => 'West Bengal'],
            ['countryId' => 1,'name' => 'Bihar'],
            ['countryId' => 1,'name' => 'Delhi'],
            ['countryId' => 1,'name' => 'Tamil Nadu'],
            ['countryId' => 1,'name' => 'Uttar Pradesh'],
            ['countryId' => 1,'name' => 'Maharastra'],
            ['countryId' => 1,'name' => 'Madhya Pradesh'],
            ['countryId' => 2,'name' => 'New South Wales'],
            ['countryId' => 2,'name' => 'Queensland'],
            ['countryId' => 2,'name' => 'Victoria'],
            ['countryId' => 2,'name' => 'Tasmania'],
            ['countryId' => 2,'name' => 'Western Australia'],
            ['countryId' => 2,'name' => 'South Australia'],
        ];
        DB::table('states')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}
