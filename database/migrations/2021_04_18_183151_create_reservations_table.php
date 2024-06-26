<?php

use App\Enums\CategoryRequested;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('ip_address')->nullable();
            $table->date('reservation_date');
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('time_slot_id');
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('guest_number');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('waiter_id')->nullable();
            $table->string('user_agent')->nullable();
            $table->unsignedTinyInteger('status')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('reservations');
    }
};
