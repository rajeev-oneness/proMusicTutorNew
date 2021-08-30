<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId');
            $table->float('points',8,2);
            $table->date('valid_till');
            $table->string('remarks')->comment('point Credit For');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [
            ['userId' => 1, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Joining Bonus'],
            ['userId' => 1, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Referral Bonus for UserId:2'],
            ['userId' => 2, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Joining Bonus'],
            ['userId' => 1, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Referral Bonus for UserId:3'],
            ['userId' => 3, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Joining Bonus'],
            ['userId' => 1, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Referral Bonus for UserId:4'],
            ['userId' => 4, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Joining Bonus'],
            ['userId' => 4, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Referral Bonus for UserId:5'],
            ['userId' => 5, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Joining Bonus'],
            ['userId' => 4, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Referral Bonus for UserId:6'],
            ['userId' => 6, 'points'=>10, 'valid_till' => date('Y-m-d',strtotime('+1 year')), 'remarks' => 'Joining Bonus'],
        ];
        DB::table('user_points')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_points');
    }
}
