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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->longText('address')->nullable();
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('current_status');
            $table->unsignedTinyInteger('delivery_status');
            $table->unsignedTinyInteger('pickup_status');
            $table->unsignedTinyInteger('table_status');
            $table->boolean('applied')->nullable();
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
        Schema::dropIfExists('restaurants');
    }
};
