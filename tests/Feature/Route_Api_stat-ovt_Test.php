<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Character;
use App\Models\Stat;
use Carbon\Carbon;

test("it_returns_422_with_errors_if_no_payload_is_present", function () {
    $arrErrors = [
        "errors" => [
            "name"   => ["The name field is required."],
            "stat"   => ["The stat field is required."],
            "before" => ["The before field is required."],
            "after"  => ["The after field is required."],
        ]
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->post(route("api-stat-ovt"));

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_name_is_not_character_table_name_column", function () {
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

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_stat_is_not_in_Stat::STATS", function () {
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

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_after_is_not_a_date", function () {
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

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_422_with_errors_if_before_is_not_a_date", function () {
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

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(422)
             ->assertJson($arrErrors);
});

test("it_returns_200_if_payload_is_valid", function () {
    $arrPayload = [
        "name"   => "ashe",
        "stat"   => "accuracy",
        "after"  => "2022-12-13",
        "before" => "2022-12-12"
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(200);
});

//TODO: Randomise after and before and filter the $stats collection
test("it_returns_200_with_data_ordered_by_match_date_if_payload_is_valid", function () {
    $character = Character::factory()
                          ->has(Stat::factory()->count(rand(2, 10)))
                          ->create();
    $stat = Stat::STATS[rand(0, count(Stat::STATS)-1)]; //pick a random stat
    $stats = $character->stats->map->only([$stat,"match_date"])->sortBy("match_date")->values()->toArray();

    $arrPayload = [
        "name"   => $character->name,
        "stat"   => $stat,
        "after"  => "1990-01-01",
        "before" => Carbon::now()
    ];

    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ]
    )->postJson(route("api-stat-ovt"), $arrPayload);

    $response->assertStatus(200)
             ->assertJson($stats);
});
