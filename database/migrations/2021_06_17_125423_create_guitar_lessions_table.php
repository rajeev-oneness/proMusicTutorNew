<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuitarLessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guitar_lessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('categoryId');
            $table->bigInteger('guitarSeriesId');
            $table->string('title');
            $table->string('image');
            $table->integer('currencyId');
            $table->float('price',8,2);
            $table->longText('description');
            $table->bigInteger('createdBy');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [];
        for ($i=0; $i < 3; $i++) {
            for ($j=0; $j < 6; $j++) {
                for ($k=0; $k < 3 ; $k++) {
                    $data[] = [
                        'categoryId' => ($i+1),
                        'guitarSeriesId' => ($j+1),
                        'title' => 'Series '.($i+1).' - Lesson '.($k+1),
                        'image' => '/design/img/guitar_'.(4+$k).'.png',
                        'currencyId' => 3,
                        'price' => rand(2,9).'.99',
                        'description' => "During this series you will be taught and directed by the legendary 'Whitesnake' guitarist, Micky Moody. Throughtout the lessons he'll demonstrate valuable riffs, licks and ideas across a number of styles, including; Bluegrass, Blues, slide and will demonstrate some of his own work using unusual tuning methods. He will demonstrate some of the methods he uses and goes into detail as to slide and picking techniques This series is perfect for the seasoned guitarist - so bring your bottleneck, capo and don't worry - you're in good hands with Micky Moody",
                        'createdBy' => (2+$i),
                    ];
                }
            }
        }
        DB::table('guitar_lessions')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guitar_lessions');
    }
}
