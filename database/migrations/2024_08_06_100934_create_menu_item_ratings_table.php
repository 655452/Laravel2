
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_item_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->default(0);
            $table->text('review')->nullable();
            $table->unsignedTinyInteger('status');
            $table->auditColumn();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_item_ratings');
    }
};

