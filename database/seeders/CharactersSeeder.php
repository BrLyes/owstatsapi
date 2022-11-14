<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\Game;

class CharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $arrOwCharacters = [
            [
                "name" => "D.Va",
                "role" => "tank"
            ],
            [
                "name" => "Doomfist",
                "role" => "tank"
            ],
            [
                "name" => "Junker Queen",
                "role" => "tank"
            ],
            [
                "name" => "Orisa",
                "role" => "tank"
            ],
            [
                "name" => "Reinhardt",
                "role" => "tank"
            ],
            [
                "name" => "Roadhog",
                "role" => "tank"
            ],
            [
                "name" => "Sigma",
                "role" => "tank"
            ],
            [
                "name" => "Winston",
                "role" => "tank"
            ],
            [
                "name" => "Wrecking Ball",
                "role" => "tank"
            ],
            [
                "name" => "Zarya",
                "role" => "tank"
            ],
            [
                "name" => "Ashe",
                "role" => "damage"
            ],
            [
                "name" => "Bastion",
                "role" => "damage"
            ],
            [
                "name" => "Cassidy",
                "role" => "damage"
            ],
            [
                "name" => "Echo",
                "role" => "damage"
            ],
            [
                "name" => "Genji",
                "role" => "damage"
            ],
            [
                "name" => "Hanzo",
                "role" => "damage"
            ],
            [
                "name" => "Junkrat",
                "role" => "damage"
            ],
            [
                "name" => "Mei",
                "role" => "damage"
            ],
            [
                "name" => "Pharah",
                "role" => "damage"
            ],
            [
                "name" => "Reaper",
                "role" => "damage"
            ],
            [
                "name" => "Soldier76",
                "role" => "damage"
            ],
            [
                "name" => "Sojourn",
                "role" => "damage"
            ],
            [
                "name" => "Sombra",
                "role" => "damage"
            ],
            [
                "name" => "Symmetra",
                "role" => "damage"
            ],
            [
                "name" => "Torbjorn",
                "role" => "damage"
            ],
            [
                "name" => "Tracer",
                "role" => "damage"
            ],
            [
                "name" => "Widowmaker",
                "role" => "damage"
            ],
            [
                "name" => "Ana",
                "role" => "support"
            ],
            [
                "name" => "Baptiste",
                "role" => "support"
            ],
            [
                "name" => "Brigitte",
                "role" => "support"
            ],
            [
                "name" => "Kiriko",
                "role" => "support"
            ],
            [
                "name" => "Lucio",
                "role" => "support"
            ],
            [
                "name" => "Mercy",
                "role" => "support"
            ],
            [
                "name" => "Moira",
                "role" => "support"
            ],
            [
                "name" => "Zenyatta",
                "role" => "support"
            ],
        ];

        foreach ($arrOwCharacters as $character) {
            Character::firstOrCreate($character);
        }
    }
}
