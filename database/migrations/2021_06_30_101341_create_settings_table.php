<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key',50)->index();
            $table->string('heading');
            $table->longText('description');
            $table->longText('description2');
            $table->string('image');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        $data = [
            [
                'key' => 'aboutus',
                'heading' => 'About Us',
                'description' => "<p>Promusictutor.com was designed by Musicians for Musicians.</p>
                    <p>Our aim is to provide our customers with high quality tuitional HD products that are as acurate as possible.</p>
                    <p>We are proud that our partners are Dogstar Media Limited who provide the filming and editing expertise that enable us to produce these high quality products.</p>
                    <p>Our musicians/tutors are chosen based on their achivements, reputation, knowledge and musical ability. With this in mind we hope to pass on the skills that they have learned throughout their carrers to our customers.</p>
                    <p>We will continue to work closely with our musicians/tutors to continue to produce high quality tuitional products that can benefit our customers in every way.</p>
                    <p>Promusictutor.com's aim is to make its products accessable to all, by providing it's products at very resonable prices Customers will be able to purchase products in bite size chunks making purchasing more affordable.</p>",
                'description2' => "<p>We provide our customers with their own account. In their own account area they can view, stream or download the products they have purchased in HD quality.</p>
                    <p>We wouls also ask our customers to provide us with feedback in order to maintain our product standards and produce products that are in high demand.</p>
                    <p>Within this site we provide a 'sugestion box' facility. We would ask that our customers provide us with feedback through the 'sugestion box' facility. Please tell us what type of products you would like to see on the site.
                    </p>
                    <p>We will provide as many variations and genres of music as possible giving customers a wide variety of choice. We will also provide a wide range of instruments to choose from and ensure that we employ the best tutors possible.
                    </p>
                    <p>Please be aware that if you are trying to stream HD quality videos you will require a high speed internet connection. If you find that your computer is buffering please download the product.
                    </p>
                    <p>Most of all please be assured that we value you custom and we hope that you will continue to use promusictutor for many years to come.</p>
                    <p>Please feel free to browse the site. We have given you multiple ways to navigate this website and we have also provided a search facility.
                    </p>
                    <p>We hope to provide you with the tools you need to become a great musician. Therefore our philosophy is 'if you want to play like a pro, learn from the pro's'. This we beleive is the best way to become a great player.
                    </p>",
                'image' => 'design/img/about_img.png',
            ],
            [
                'key' => 'howitworkMain',
                'heading' => 'How It Work',
                'description' => 'Pro Music Tutor offers a range of high definition music tutoring videos and exceptional quality backing tracks. Our instructional videos feature tutors selected for their reputation and talent with the guitar and with the saxophone.',
                'image' => 'design/img/how-it-banner.jpg',
                'description2' => '',
            ],
            [
                'key' => 'howitworkChild',
                'heading' => 'LOG IN OR SIGN UP',
                'description' => "This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis",
                'image' => 'design/img/how-icon-1.png',
                'description2' => '',
            ],
            [
                'key' => 'howitworkChild',
                'heading' => 'BECOME A MEMBER',
                'description' => "This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis",
                'image' => 'design/img/how-icon-2.png',
                'description2' => '',
            ],
            [
                'key' => 'howitworkChild',
                'heading' => 'ENJOY OUR SERVICES',
                'description' => "This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis",
                'image' => 'design/img/how-icon-3.png',
                'description2' => '',
            ],
            [
                'key' => 'refundPolicy',
                'heading' => 'Refund Policy',
                'description' => "<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat conse.</p><ul><li>Nam nec tellus a odio tincidunt auctor a ornare odiofeugiat, velit mauris.</li><li>consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo</li><li>lorem quis bibendum auctor, nisi elit consequat ipsum</li></ul><p>Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat conse.</p>",
                'image' => 'design/img/privacy.jpg',
                'description2' => '',
            ],
            [
                'key' => 'termsCondition',
                'heading' => 'Terms and Condition',
                'description' => "<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat conse.</p><ul><li>Nam nec tellus a odio tincidunt auctor a ornare odiofeugiat, velit mauris.</li><li>consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo</li><li>lorem quis bibendum auctor, nisi elit consequat ipsum</li></ul><p>Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat conse.</p>",
                'image' => 'design/img/trams.png',
                'description2' => '',
            ],
            [
                'key' => 'privacyPolicy',
                'heading' => 'Privacy Policy',
                'description' => "<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat conse.</p><ul><li>Nam nec tellus a odio tincidunt auctor a ornare odiofeugiat, velit mauris.</li><li>consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo</li><li>lorem quis bibendum auctor, nisi elit consequat ipsum</li></ul><p>Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat conse.</p>",
                'image' => 'design/img/privacy.jpg',
                'description2' => '',
            ],
        ];
        DB::table('settings')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
