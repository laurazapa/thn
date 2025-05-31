<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the bookings table.
 * This table stores booking information and serves as a child table for users, rooms, and hotels.
 */
return new class extends Migration
{
    /**
     * Creates the bookings table with the following structure:
     * - booking_id: UUID primary key
     * - user_id: Foreign key to users table
     * - room_id: Foreign key to rooms table
     * - hotel_id: Foreign key to hotels table (denormalized for query performance)
     * - check_in_date: Date when the booking starts
     * - check_out_date: Date when the booking ends
     * - timestamps: created_at and updated_at
     *
     * Constraints:
     * - Foreign keys to users, rooms, and hotels tables with cascade delete
     * - hotel_id is denormalized for improved query performance
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('booking_id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('room_id')->index();
            $table->uuid('hotel_id')->index();
            $table->date('check_in_date');
            $table->date('check_out_date');

            $table->foreign('user_id')
                ->references('user_id')->on('users')
                ->onDelete('cascade');

            $table->foreign('room_id')
                ->references('room_id')->on('rooms')
                ->onDelete('cascade');

            $table->foreign('hotel_id')
                ->references('hotel_id')->on('hotels')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Drops the bookings table and all its data.
     * This operation is safe as bookings are child records.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
