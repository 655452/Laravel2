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
        Schema::create('order_line_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('menu_item_id');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 13, 2);
            $table->decimal('discounted_price', 13, 2)->default(0);
            $table->decimal('item_total', 13, 2);
            $table->unsignedBigInteger('menu_item_variation_id')->nullable();
            $table->longText('options')->nullable();
            $table->longText('instructions')->nullable();
            $table->unsignedDouble('options_total')->nullable();
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
        Schema::dropIfExists('order_line_items');
    }
};
