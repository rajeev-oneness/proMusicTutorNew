<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlanFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plan_features', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subscriptionPlanId');
            $table->string('title');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        $data = [];
        for ($i=1; $i <= 6 ; $i++) { 
            $data[] = [
                'subscriptionPlanId' => $i,
                'title' => 'Unlimited Streaming HD of all Sax lessons',
            ];
            $data[] = [
                'subscriptionPlanId' => $i,
                'title' => '50% off all downloads',
            ];
        }

        DB::table('subscription_plan_features')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plan_features');
    }
}
