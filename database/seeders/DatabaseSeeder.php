<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Ameen Al Mahozi',
            'email' => 'ameenalmahozi@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $team = Team::Create([
            'name' => 'Ameen Team',
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        $team = Team::Create([
            'name' => 'Budget',
            'user_id' => $user->id,
            'personal_team' => false,
        ]);

        $user = User::factory(10)->withPersonalTeam()->create();
    }
}
