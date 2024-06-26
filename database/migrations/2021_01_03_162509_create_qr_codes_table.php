<?php

use App\Enums\QrCodeBlockStyle;
use App\Enums\QrCodeEyeStyle;
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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id')->index();
            $table->string('style', 15)->nullable()->default(QrCodeBlockStyle::SQUARE);
            $table->string('eye_style', 15)->nullable()->default(QrCodeEyeStyle::SQUARE);
            $table->string('color')->nullable()->default("0,0,0");
            $table->string('background_color')->nullable()->default("255,255,255");
            $table->string('mode')->nullable();
            $table->string('qrcode_text')->nullable();
            $table->longText('qrcode_logo')->nullable();
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
        Schema::dropIfExists('qr_codes');
    }
};
