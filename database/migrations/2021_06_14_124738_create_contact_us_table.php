<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(2)->comment('1:Setting,2:Contacts List');
            $table->string('name');
            $table->string('phone',20);
            $table->string('email');
            $table->string('subject');
            $table->bigInteger('contactedBy')->comment('userId from Users Table');
            $table->longText('remarks');
            $table->longText('description');
            $table->string('address');
            $table->string('image');
            $table->string('facebook');
            $table->string('linkedin');
            $table->string('youtube');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'type' => 1,
                'name' => 'Headquarters',
                'address' => '5/13 Fielden Way, Port Kennedy,WA, 6172, Dummy location',
                'phone' => '[88] 657 524 332',
                'email' => 'info@example.com',
                'image' => 'design/img/pic-1.png',
                'facebook' => 'https://www.facebook.com/',
                'linkedin' => 'https://www.linkedin.com/',
                'youtube' => 'https://www.youtube.com/',
            ],
        ];
        DB::table('contact_us')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us');
    }
}
