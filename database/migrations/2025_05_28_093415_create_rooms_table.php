<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('room_id')->primary();
            $table->uuid('hotel_id');
            $table->string('room_label');
            $table->timestamps();

            $table->foreign('hotel_id')
                ->references('hotel_id')->on('hotels')
                ->onDelete('cascade');

            $table->unique(['hotel_id', 'room_label']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
