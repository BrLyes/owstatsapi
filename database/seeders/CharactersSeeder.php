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
            "D.va",
            "Doomfist",
            "Junker Queen",
            "Orisa",
            "Ramattra",
            "Reinhardt",
            "Roadhog",
            "Sigma",
            "Winston",
            "Wrecking Ball",
            "Zarya",
            "Ashe",
            "Bastion",
            "Cassidy",
            "Echo",
            "Genji",
            "Hanzo",
            "Junkrat",
            "Mei",
            "Pharah",
            "Reaper",
            "Soldier76",
            "Sojourn",
            "Sombra",
            "Symmetra",
            "Torbjorn",
            "Tracer",
            "Widowmaker",
            "Ana",
            "Baptiste",
            "Brigitte",
            "Kiriko",
            "Lucio",
            "Mercy",
            "Moira",
            "Zenyatta",
        ];

        foreach ($arrOwCharacters as $character) {
            Character::firstOrCreate(
                [
                    "name" => strtoupper($character)
                ]
            );
        }
    }
}
