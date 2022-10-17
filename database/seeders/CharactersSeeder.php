<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\Stat;

class CharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Characters
        $ashe = Character::create(
            [
                "name" => "Ashe",
            ]
        );

        //Stats
        Stat::factory(["character_id" => $ashe->id])->count(rand(10, 100))->create();
    }
}
