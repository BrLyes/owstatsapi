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
            foreach (Character::all() as $character){
                Game::factory([
                                  "character_id" => $character->id,
                                  "user_id"      => $user->id
                              ]
                )->count(rand(15, 100))->create();
            }
        }
    }
}
