<?php

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EmptyTablesSeeder;
use App\Models\Character;
use App\Models\User;
use App\Models\Game;

define("DEFAULTHEADERS", [
    "Accept"       => "application/json",
    "Content-Type" => "application/json"
]);

beforeEach(function () {
    $this->seed(EmptyTablesSeeder::class);
    $this->seed(DatabaseSeeder::class);
});

test("it_returns_401_user_is_not_authenticated", function () {
    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->post(route("api-stat-sum"));
    $response->assertStatus(401);
});

test("it_returns_422_with_errors_if_name_is_missing", function () {
    $user      = User::inRandomOrder()->first();
    $arrErrors = [
        "errors" => [
            "name" => ["The name field is required."],
        ]
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->post(route("api-stat-sum"));

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_name_is_invalid", function () {
    $user       = User::inRandomOrder()->first();
    $arrErrors  = [
        "errors" => [
            "name" => ["The selected name is invalid."],
        ]
    ];
    $arrPayload = [
        "name" => "invalid",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-sum"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_stat_is_invalid", function () {
    $user       = User::inRandomOrder()->first();
    $arrErrors  = [
        "errors" => [
            "stat" => ["The selected stat is invalid."],
        ]
    ];
    $arrPayload = [
        "stat" => "invalid",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-sum"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_200_with_user_sum_of_all_stats_for_the_selected_character_if_name_is_valid", function () {
    //Picking random entries
    $user      = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();
    $stats     = Game::ofCharacter($character->id)
                     ->ofUser($user->id)
                     ->get();
    $assert    = [];

    foreach (Game::STATS as $stat) {
        $assert[$stat] = $stats->pluck($stat)->sum();
    }

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-sum"), [
                         "name" => $character->name
                     ]);

    $response->assertStatus(200)
             ->assertJson($assert);
});

test("it_returns_200_with_user_selected_stat_for_the_selected_character_if_name_is_valid", function () {
    //Picking random entries
    $user      = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();
    $stat      = Game::STATS[rand(0, count(Game::STATS) - 1)]; //pick a random stat

    //Setting the assert
    $assert = Game::ofCharacter($character->id)
                  ->ofUser($user->id)
                  ->get()
                  ->pluck($stat)
                  ->sum();

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-sum"), [
                         "stat" => $stat,
                         "name" => $character->name
                     ]);

    $response->assertStatus(200)
             ->assertSee($assert);
});
