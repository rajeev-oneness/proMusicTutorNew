<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSeriesLessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_series_lessions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('instrumentId');
            $table->bigInteger('categoryId');
            $table->bigInteger('productSeriesId');
            $table->string('title');
            $table->string('image');
            $table->integer('currencyId');
            $table->float('price',8,2);
            $table->longText('description');
            // New Column Addition
            $table->double('gbp', 8, 2);
            $table->double('price_usd', 8, 2);
            $table->double('price_euro', 8, 2);
            $table->string('keywords');
            $table->integer('genre');
            $table->string('item_clean_url');
            $table->string('product_code');
            // END
            $table->bigInteger('createdBy');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [];
        $series = DB::table('product_series')->get();
        foreach ($series as $key => $value) {
            $data[] = [
                'instrumentId' => $value->instrumentId,
                'categoryId' => $value->categoryId,
                'productSeriesId' => $value->id,
                'title' => 'Series '.($key+1).' - Lesson 1',
                'image' => '/design/img/guitar_1.png',
                'currencyId' => 3,
                'price' => rand(2,9).'.99',
                'description' => "During this series you will be taught and directed by the legendary 'Whitesnake' guitarist, Micky Moody. Throughtout the lessons he'll demonstrate valuable riffs, licks and ideas across a number of styles, including; Bluegrass, Blues, slide and will demonstrate some of his own work using unusual tuning methods. He will demonstrate some of the methods he uses and goes into detail as to slide and picking techniques This series is perfect for the seasoned guitarist - so bring your bottleneck, capo and don't worry - you're in good hands with Micky Moody",
                'createdBy' => $value->createdBy,
            ];
            $data[] = [
                'instrumentId' => $value->instrumentId,
                'categoryId' => $value->categoryId,
                'productSeriesId' => $value->id,
                'title' => 'Series '.($key+1).' - Lesson 2',
                'image' => '/design/img/guitar_2.png',
                'currencyId' => 3,
                'price' => rand(2,9).'.99',
                'description' => "During this series you will be taught and directed by the legendary 'Whitesnake' guitarist, Micky Moody. Throughtout the lessons he'll demonstrate valuable riffs, licks and ideas across a number of styles, including; Bluegrass, Blues, slide and will demonstrate some of his own work using unusual tuning methods. He will demonstrate some of the methods he uses and goes into detail as to slide and picking techniques This series is perfect for the seasoned guitarist - so bring your bottleneck, capo and don't worry - you're in good hands with Micky Moody",
                'createdBy' => $value->createdBy,
            ];
            $data[] = [
                'instrumentId' => $value->instrumentId,
                'categoryId' => $value->categoryId,
                'productSeriesId' => $value->id,
                'title' => 'Series '.($key+1).' - Lesson 3',
                'image' => '/design/img/guitar_3.png',
                'currencyId' => 3,
                'price' => rand(2,9).'.99',
                'description' => "During this series you will be taught and directed by the legendary 'Whitesnake' guitarist, Micky Moody. Throughtout the lessons he'll demonstrate valuable riffs, licks and ideas across a number of styles, including; Bluegrass, Blues, slide and will demonstrate some of his own work using unusual tuning methods. He will demonstrate some of the methods he uses and goes into detail as to slide and picking techniques This series is perfect for the seasoned guitarist - so bring your bottleneck, capo and don't worry - you're in good hands with Micky Moody",
                'createdBy' => $value->createdBy,
            ];
            $data[] = [
                'instrumentId' => $value->instrumentId,
                'categoryId' => $value->categoryId,
                'productSeriesId' => $value->id,
                'title' => 'Series '.($key+1).'  - Lesson 4',
                'image' => '/design/img/guitar_4.png',
                'currencyId' => 3,
                'price' => rand(2,9).'.99',
                'description' => "During this series you will be taught and directed by the legendary 'Whitesnake' guitarist, Micky Moody. Throughtout the lessons he'll demonstrate valuable riffs, licks and ideas across a number of styles, including; Bluegrass, Blues, slide and will demonstrate some of his own work using unusual tuning methods. He will demonstrate some of the methods he uses and goes into detail as to slide and picking techniques This series is perfect for the seasoned guitarist - so bring your bottleneck, capo and don't worry - you're in good hands with Micky Moody",
                'createdBy' => $value->createdBy,
            ];
            $data[] = [
                'instrumentId' => $value->instrumentId,
                'categoryId' => $value->categoryId,
                'productSeriesId' => $value->id,
                'title' => 'Series '.($key+1).'  - Lesson 5',
                'image' => '/design/img/guitar_5.png',
                'currencyId' => 3,
                'price' => rand(2,9).'.99',
                'description' => "During this series you will be taught and directed by the legendary 'Whitesnake' guitarist, Micky Moody. Throughtout the lessons he'll demonstrate valuable riffs, licks and ideas across a number of styles, including; Bluegrass, Blues, slide and will demonstrate some of his own work using unusual tuning methods. He will demonstrate some of the methods he uses and goes into detail as to slide and picking techniques This series is perfect for the seasoned guitarist - so bring your bottleneck, capo and don't worry - you're in good hands with Micky Moody",
                'createdBy' => $value->createdBy,
            ];
            $data[] = [
                'instrumentId' => $value->instrumentId,
                'categoryId' => $value->categoryId,
                'productSeriesId' => $value->id,
                'title' => 'Series 1 - Lesson 6',
                'image' => '/design/img/guitar_6.png',
                'currencyId' => 3,
                'price' => rand(2,9).'.99',
                'description' => "During this series you will be taught and directed by the legendary 'Whitesnake' guitarist, Micky Moody. Throughtout the lessons he'll demonstrate valuable riffs, licks and ideas across a number of styles, including; Bluegrass, Blues, slide and will demonstrate some of his own work using unusual tuning methods. He will demonstrate some of the methods he uses and goes into detail as to slide and picking techniques This series is perfect for the seasoned guitarist - so bring your bottleneck, capo and don't worry - you're in good hands with Micky Moody",
                'createdBy' => $value->createdBy,
            ];
        }
        DB::table('product_series_lessions')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_series_lessions');
    }
}
