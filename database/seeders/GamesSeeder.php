<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach (User::all() as $user) {
            Game::factory([
                              "character_id" => Character::inRandomOrder()->first()->id,
                              "user_id"      => $user->id
                          ]
            )->count(rand(5, 100))->create();
        }
    }
}
