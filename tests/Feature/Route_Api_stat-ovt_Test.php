<?php

use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EmptyTablesSeeder;
use App\Models\Character;
use App\Models\User;
use App\Models\Game;

beforeEach(function () {
    $this->seed(EmptyTablesSeeder::class);
    $this->seed(DatabaseSeeder::class);
});

test("it_returns_401_user_is_not_authenticated", function () {
    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->post(route("api-stat-avg"));
    $response->assertStatus(401);
});

test("it_returns_422_with_errors_if_no_payload_is_present", function () {
    $user      = User::inRandomOrder()->first();
    $arrErrors = [
        "errors" => [
            "name"   => ["The name field is required."],
            "stat"   => ["The stat field is required."],
            "before" => ["The before field is required."],
            "after"  => ["The after field is required."],
        ]
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->post(route("api-stat-ovt"));

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_name_is_not_character_table_name_column", function () {
    $user      = User::inRandomOrder()->first();
    $arrErrors = [
        "errors" => [
            "name" => ["The selected name is invalid."],
        ]
    ];

    $arrPayload = [
        "name"   => "invalid",
        "stat"   => "accuracy",
        "after"  => "2022-12-12",
        "before" => "2022-12-13"
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_stat_is_not_in_Stat::STATS", function () {
    $user      = User::inRandomOrder()->first();
    $arrErrors = [
        "errors" => [
            "stat" => ["The selected stat is invalid."],
        ]
    ];

    $arrPayload = [
        "name"   => "ashe",
        "stat"   => "invalid",
        "after"  => "2022-12-12",
        "before" => "2022-12-13"
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_after_is_not_a_date", function () {
    $user      = User::inRandomOrder()->first();
    $arrErrors = [
        "errors" => [
            "after" => ["The after is not a valid date."],
        ]
    ];

    $arrPayload = [
        "name"   => "ashe",
        "stat"   => "accuracy",
        "after"  => "invalid",
        "before" => "2022-12-13"
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_before_is_not_a_date", function () {
    $user      = User::inRandomOrder()->first();
    $arrErrors = [
        "errors" => [
            "before" => ["The before is not a valid date."],
        ]
    ];

    $arrPayload = [
        "name"   => "ashe",
        "stat"   => "accuracy",
        "after"  => "2022-12-13",
        "before" => "invalid"
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_200_if_payload_is_valid", function () {
    $user       = User::inRandomOrder()->first();
    $arrPayload = [
        "name"   => "ashe",
        "stat"   => "accuracy",
        "after"  => "2022-12-13",
        "before" => "2022-12-12"
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(200);
});

test("it_returns_200_with_data_ordered_by_match_date_if_payload_is_valid", function () {
    $user      = User::inRandomOrder()->first();
    $character = Character::inRandomOrder()->first();
    $stat      = Game::STATS[rand(0, count(Game::STATS) - 1)]; //pick a random stat
    $randomMin = rand(0, 99999);
    $after     = Carbon::now()->subMinutes($randomMin);
    $before    = $after->addMinutes(99999);
    $stats     = Game::ofUser($user->id)
                     ->ofCharacter($character->id)
                     ->get()->map->only([$stat, "match_date"])
                                 ->sortBy("match_date")
                                 ->whereBetween("match_date", $after, $before)
                                 ->values()
                                 ->toArray();

    $arrPayload = [
        "name"   => $character->name,
        "stat"   => $stat,
        "after"  => $after,
        "before" => $before
    ];

    $response = $this::withHeaders(DEFAULTHEADERS)
                     ->actingAs($user)
                     ->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(200)
             ->assertJson($stats);
});
