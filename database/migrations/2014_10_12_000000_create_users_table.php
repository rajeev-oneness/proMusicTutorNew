<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /***** note if you change anything in to migration,
        you have to also change
        1. Referral Migration
        2. User Point Migration *****/
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_type')->default(3);
            $table->string('name');
            $table->string('email',150)->unique();
            $table->string('mobile',20);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('otp',10);
            $table->longText('about');
            $table->date('carrier_started');
            $table->tinyInteger('subscribed')->default(1)->comment('1:Subscribed ,0:Un-Subscribed');
            $table->tinyInteger('status')->comment('1:Active,0:In-Active')->default(1);
            $table->string('image')->default('/defaultImages/user.jpg');
            $table->string('referral_code',10)->unique()->comment('Referral Code');
            $table->bigInteger('referred_by')->comment('Referred By UserId');
            $table->string('gender',20)->comment('Male,Female,Not specified');
            $table->date('dob');
            $table->string('marital',20)->comment('Single,Married,Divorced');
            $table->date('aniversary');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'user_type' => 1,
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('secret'),
                'referral_code' => 'AAAAAAA',
                'about' => '',
                'image' => '/defaultImages/user.jpg',
            ],
            [
                'user_type' => 2,
                'name' => 'Andy Sheppard',
                'email' => 'andysheppard@tutor.com',
                'password' => Hash::make('secret'),
                'referral_code' => 'AAAAAAB',
                'about' => 'Andy Sheppard is one of Europe’s best saxophonist and is one of the few British sax players to make waves on the international jazz scene in recent years.',
                'image' => '/design/img/team-1.jpg',
            ],
            [
                'user_type' => 2,
                'name' => 'Craig Crofton',
                'email' => 'craigcrofton@tutor.com',
                'password' => Hash::make('secret'),
                'referral_code' => 'AAAAAAC',
                'about' => 'Craig Crofton is one of Europe’s best saxophonist and is one of the few British sax players to make waves on the international jazz scene in recent years.',
                'image' => '/design/img/team-2.jpg',
            ],
            [
                'user_type' => 2,
                'name' => 'Innes Sibun',
                'email' => 'innessibun@tutor.com',
                'password' => Hash::make('secret'),
                'referral_code' => 'AAAAAAD',
                'about' => 'Innes Sibun is one of Europe’s best saxophonist and is one of the few British sax players to make waves on the international jazz scene in recent years.',
                'image' => '/design/img/team-3.jpg',
            ],
            [
                'user_type' => 3,
                'name' => 'John Doe',
                'email' => 'jogndoe@user.com',
                'password' => Hash::make('secret'),
                'referral_code' => 'AAAAAAE',
                'about' => '',
                'image' => '/design/img/testi-1.png',
            ],
            [
                'user_type' => 2,
                'name' => 'Demo Tutor',
                'email' => 'tutor@tutor.com',
                'password' => Hash::make('secret'),
                'referral_code' => 'AAAAAAF',
                'about' => 'Demo is one of Europe’s best saxophonist and is one of the few British sax players to make waves on the international jazz scene in recent years.',
                'image' => '/defaultImages/user.jpg',
            ],
        ];

        DB::table('users')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
