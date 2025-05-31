<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the users table.
 * This table stores basic user information and serves as the parent table for bookings.
 */
return new class extends Migration
{
    /**
     * Creates the users table with the following structure:
     * - user_id: UUID primary key
     * - name: User's full name
     * - email: Unique email address
     * - timestamps: created_at and updated_at
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Drops the users table and all its data.
     * This will cascade delete all related bookings due to foreign key constraints.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
