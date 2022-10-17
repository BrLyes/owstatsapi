<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Character;
use App\Models\Stat;
use Carbon\Carbon;

test("it_returns_422_with_errors_if_no_payload_is_present", function () {
    $arrErrors = [
        "errors" => [
            "name"   => ["The name field is required."],
        ]
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->post(route("api-stat-avg"));

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_name_is_not_character_table_name_column", function () {
    $character = Character::factory()
                          ->create();

    $arrErrors = [
        "errors" => [
            "name" => ["The selected name is invalid."],
        ]
    ];

    $arrPayload = [
        "name"   => Str::random(16),
        "stat"   => "accuracy",
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-avg"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_stat_is_not_in_Stat::STATS", function () {
    $character = Character::factory()
                          ->create();
    $arrErrors = [
        "errors" => [
            "stat" => ["The selected stat is invalid."],
        ]
    ];

    $arrPayload = [
        "name"   => $character->name,
        "stat"   => "invalid",
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-avg"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_200_if_payload_is_valid", function () {
    $character = Character::factory()
                          ->create();
    $stat = Stat::STATS[rand(0, count(Stat::STATS)-1)]; //pick a random stat

    $arrPayload = [
        "name"   => $character->name,
        "stat"   => $stat,
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-avg"), $arrPayload);

    $response->assertStatus(200);
});

test("it_returns_200_with_avg_of_all_stats_if_name_is_provided", function () {
    $character = Character::factory()
                          ->has(Stat::factory()->count(rand(2, 10)))
                          ->create();

    $stats = $character->stats;
    $assertedResponse = [];
    foreach (Stat::STATS as $stat) {
        $assertedResponse[$stat] = number_format($stats->pluck($stat)->avg(),2);
    }

    $arrPayload = [
        "name"   => $character->name,
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-avg"), $arrPayload);

    $response->assertStatus(200)
             ->assertJson($assertedResponse);
});

test("it_returns_200_with_avg_of_stat_if_name_and_stat_are_provided", function () {
    $character = Character::factory()
                          ->has(Stat::factory()->count(rand(2, 10)))
                          ->create();

    $stat = Stat::STATS[rand(0, count(Stat::STATS)-1)]; //pick a random stat
    $assertedResponse = number_format($character->stats->pluck($stat)->avg(),2);

    $arrPayload = [
        "name"   => $character->name,
        "stat"   => $stat,
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-avg"), $arrPayload);

    $response->assertStatus(200)
             ->assertSee($assertedResponse);
});
