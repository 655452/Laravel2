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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->unsignedInteger('depth');
            $table->unsignedInteger('left');
            $table->unsignedInteger('right');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('requested')->default(CategoryRequested::NON_REQUESTED);
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
        Schema::dropIfExists('categories');
    }
};
