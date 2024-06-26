<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total', 13, 2);
            $table->decimal('sub_total', 13, 2);
            $table->decimal('delivery_charge', 13, 2);
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('platform')->nullable();
            $table->unsignedTinyInteger('order_type')->default(1);
            $table->string('device_id')->nullable();
            $table->string('ip')->nullable();
            $table->unsignedTinyInteger('payment_status');
            $table->decimal('paid_amount', 13, 2);
            $table->longText('address');
            $table->string('mobile');
            $table->string('lat');
            $table->string('long');
            $table->longText('misc')->nullable();
            $table->uuid('invoice_id')->nullable();
            $table->unsignedBigInteger('restaurant_id');
            $table->bigInteger('delivery_boy_id')->nullable();
            $table->tinyInteger('product_received')->default(10);
            $table->unsignedTinyInteger('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
