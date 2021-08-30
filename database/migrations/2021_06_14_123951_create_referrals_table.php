<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('code',20)->unique();
            $table->bigInteger('userId');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            ['code' => 'AAAAAAA','userId'=>1],
            ['code' => 'AAAAAAB','userId'=>2],
            ['code' => 'AAAAAAC','userId'=>3],
            ['code' => 'AAAAAAD','userId'=>4],
            ['code' => 'AAAAAAE','userId'=>5],
            ['code' => 'AAAAAAF','userId'=>5],
        ];
        DB::table('referrals')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referrals');
    }
}
