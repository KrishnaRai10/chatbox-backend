<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and rooms
        $users = User::all();
        $rooms = Room::all();

        // Sample statuses
        $statuses = ['online', 'offline', 'away'];
   // Only seed if users and rooms exist
        if ($users->isEmpty() || $rooms->isEmpty()) {
            $this->command->warn('No users or rooms available for seeding.');
            return;
        }
        foreach ($users as $user) {
            foreach ($rooms as $room) {
                DB::table('user_statuses')->insert([
                    'id' => Str::uuid(),
                    'status' => $statuses[array_rand($statuses)],
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'last_active_at' => now()->subMinutes(rand(1, 60)),
                ]);
            }
        }
    }
}
