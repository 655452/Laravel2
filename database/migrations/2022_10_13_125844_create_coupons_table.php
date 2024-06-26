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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('discount_type');
            $table->unsignedInteger('coupon_type');
            $table->unsignedInteger('restaurant_id');
            $table->unsignedInteger('limit');
            $table->unsignedInteger('user_limit')->nullable();
            $table->decimal('amount', 13, 2);
            $table->decimal('minimum_order_amount', 13, 2)->nullable();
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->auditColumn();
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
        Schema::dropIfExists('coupons');
    }
};
