<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First create hotels
        $this->call(HotelSeeder::class);
        
        // Then create users
        $this->call(UserSeeder::class);
        
        // Then create rooms (which depend on hotels)
        $this->call(RoomSeeder::class);
        
        // Finally create bookings (which depend on users, rooms and hotels)
        $this->call(BookingSeeder::class);
    }
}
