<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the hotels table.
 * This table stores hotel information and serves as the parent table for rooms and bookings.
 */
return new class extends Migration
{
    /**
     * Creates the hotels table with the following structure:
     * - hotel_id: UUID primary key
     * - name: Hotel name
     * - city: City where the hotel is located
     * - country: Country where the hotel is located
     * - timestamps: created_at and updated_at
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->uuid('hotel_id')->primary();
            $table->string('name');
            $table->string('city');
            $table->string('country');

            $table->timestamps();
        });
    }

    /**
     * Drops the hotels table and all its data.
     * This will cascade delete all related rooms and bookings due to foreign key constraints.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
