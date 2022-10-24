<?php

use App\Models\Character;
use App\Models\Game;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EmptyTablesSeeder;

beforeEach(function () {
    $this->seed(EmptyTablesSeeder::class);
    $this->seed(DatabaseSeeder::class);
});

test("it_returns_401_if_user_is_not_authenticated", function () {
    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->post(route("api.stat.all"));
    $response->assertStatus(401);
});

test("it_returns_422_if_no_name_is_provided", function () {
    $user     = User::inRandomOrder()->first();
    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->post(route("api.stat.all"));
    $response->assertStatus(422);
});

test("it_returns_422_if_name_is_invalid", function () {
    $user = User::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "name" => ["The selected name is invalid."],
        ]
    ];

    $arrPayload = [
        "name" => "invalid",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.stat.all"), $arrPayload);
    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_200_with_stats_if_name_is_valid", function () {
    $user      = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();
    $stats     = Game::ofUser($user->id)
                     ->ofCharacter($character->id)
                     ->get()
                     ->toArray();

    $arrPayload = [
        "name" => $character->name,
    ];

    $response = $this->actingAs($user)
                     ->postJson(route("api.stat.all"), $arrPayload);
    $response->assertStatus(200)
             ->assertJson($stats);
});
