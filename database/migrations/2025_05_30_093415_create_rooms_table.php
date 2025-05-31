<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the rooms table.
 * This table stores room information and serves as a child table for hotels and parent table for bookings.
 */
return new class extends Migration
{
    /**
     * Creates the rooms table with the following structure:
     * - room_id: UUID primary key
     * - hotel_id: Foreign key to hotels table
     * - room_label: Unique room identifier within a hotel
     * - timestamps: created_at and updated_at
     * 
     * Constraints:
     * - Foreign key to hotels table with cascade delete
     * - Unique constraint on (hotel_id, room_label) combination
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('room_id')->primary();
            $table->uuid('hotel_id')->index();
            $table->string('room_label');
            $table->timestamps();

            $table->foreign('hotel_id')
                ->references('hotel_id')->on('hotels')
                ->onDelete('cascade');

            $table->unique(['hotel_id', 'room_label']);
        });
    }

    /**
     * Drops the rooms table and all its data.
     * This will cascade delete all related bookings due to foreign key constraints.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
