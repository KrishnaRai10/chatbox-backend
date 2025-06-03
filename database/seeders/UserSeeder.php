<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' =>  Str::uuid(),
                'username' => 'johndoe',
                'email' => 'john.doe@example.com',
                'avatar' => '/assets/images/user1.jpg',
                'display_name' => 'John D.',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'janesmith',
                'email' => 'jane.smith@example.com',
                'avatar' => 'avatars/jane.jpg',
                'display_name' => 'Jane S.',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'michaelbrown',
                'email' => 'michael.brown@example.com',
                'avatar' => null,
                'display_name' => null,
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'emilydavis',
                'email' => 'emily.davis@example.com',
                'avatar' => 'avatars/emily.jpg',
                'display_name' => 'Emily D.',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'williamj',
                'email' => 'william.johnson@example.com',
                'avatar' => null,
                'display_name' => 'Will J.',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'sarahwilson',
                'email' => 'sarah.wilson@example.com',
                'avatar' => 'avatars/sarah.jpg',
                'display_name' => null,
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'davidlee',
                'email' => 'david.lee@example.com',
                'avatar' => null,
                'display_name' => 'David L.',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'lisaanderson',
                'email' => 'lisa.anderson@example.com',
                'avatar' => 'avatars/lisa.jpg',
                'display_name' => 'Lisa A.',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'thomasclark',
                'email' => 'thomas.clark@example.com',
                'avatar' => null,
                'display_name' => null,
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid(),
                'username' => 'emmataylor',
                'email' => 'emma.taylor@example.com',
                'avatar' => 'avatars/emma.jpg',
                'display_name' => 'Emma T.',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}