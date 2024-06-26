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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('bank_name');
            $table->string('bank_code')->nullable();
            $table->string('recipient_name')->nullable();
            $table->unsignedBigInteger('account_number')->nullable()->unique();
            $table->string('mobile_agent_name')->nullable();
            $table->unsignedInteger('mobile_agent_number')->nullable();
            $table->string('paypal_id')->nullable();
            $table->string('upi_id')->nullable();
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
        Schema::dropIfExists('banks');
    }
};
