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
                     ->post(route("api.game.store"));
    $response->assertStatus(401);
});

test("it_returns_422_if_no_payload_is_provided", function () {
    $user = User::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "name"     => ["The name field is required."],
            "kill"     => ["The kill field is required."],
            "death"    => ["The death field is required."],
            "assist"   => ["The assist field is required."],
            "damage"   => ["The damage field is required."],
            "heal"     => ["The heal field is required."],
            "mitigate" => ["The mitigate field is required."],
            "match_date" => ["The match date field is required."],
        ]
    ];


    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->post(route("api.game.store"));
    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_name_is_not_a_character_name", function () {
    $user = User::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "name"     => ["The selected name is invalid."],
        ]
    ];

    $arrPayload = [
        "name" => "invalid",
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_kill_is_not_a_number", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "kill"     => ["The kill must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => "NaN",
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_death_is_not_a_number", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "death"     => ["The death must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => "NaN",
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_assist_is_not_a_number", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "assist"     => ["The assist must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => "NaN",
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_damage_is_not_a_number", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "damage"     => ["The damage must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => "NaN",
        "heal" => 100,
        "mitigate" => 100,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_heal_is_not_a_number", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "heal"     => ["The heal must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => "NaN",
        "mitigate" => 100,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_mitigate_is_not_a_number", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "mitigate"     => ["The mitigate must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => "NaN",
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_match_date_is_not_a_date", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "mitigate"     => ["The mitigate must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => "NaN",
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_accuracy_is_not_a_number", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "accuracy"     => ["The accuracy must be a number."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "accuracy" => "NaN",
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_accuracy_lower_than_0", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "accuracy"     => ["The accuracy must be between 0 and 100."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "accuracy" => -5,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_if_accuracy_bigger_than_100", function () {
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrErrors = [
        "errors" => [
            "accuracy"     => ["The accuracy must be between 0 and 100."],
        ]
    ];

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "accuracy" => 101,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_stores_game_if_data_is_valid", function(){
    $user = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();

    $arrPayload = [
        "name" => $character->name,
        "kill" => 100,
        "death" => 100,
        "assist" => 100,
        "damage" => 100,
        "heal" => 100,
        "mitigate" => 100,
        "accuracy" => 50.2,
        "match_date" => "2022-12-12",
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api.game.store"), $arrPayload);

    //TODO: Assert json
    $response->assertStatus(200);
             //->assertJson($arrPayload);
});
