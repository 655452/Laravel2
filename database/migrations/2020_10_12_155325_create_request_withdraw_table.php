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
        Schema::create('request_withdraw', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->double('amount');
            $table->unsignedTinyInteger('status');
            $table->datetime('date');
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
        Schema::dropIfExists('request_withdraw');
    }
};
