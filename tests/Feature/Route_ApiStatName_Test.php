<?php

//TODO: REFACTOR THIS since it does not support auth and also should use the beforeEach of the other test bla bla bla

use App\Models\Character;
use App\Models\User;

test("it_returns_401_if_user_is_not_authenticated", function () {
    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ])
                     ->get(route("api-stat-name"));

    $response->assertStatus(401);
});

test("it_returns_422_if_no_name_is_provided", function () {
    $user     = User::factory()->create();
    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ])
                     ->actingAs($user)
                     ->get(route("api-stat-name"));

    $response->assertStatus(422);
});

test("it_returns_422_if_name_is_invalid", function () {
    $user     = User::factory()->create();
    $response = $this::withHeaders(
        [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ])
                     ->actingAs($user)
                     ->get(route("api-stat-name", "invalid"));
    $response->assertStatus(422);
});

test("it_returns_200_if_name_is_valid", function () {
    $user     = User::factory()->create();
    $character      = Character::factory()
                               ->create();

    $response = $this->actingAs($user)
                     ->get(route("api-stat-name", $character->name));
    $response->assertStatus(200);
});

test("it_returns_character_stats_if_name_is_valid", function () {
    $user           = User::factory()->create();
    $character      = Character::factory()
                               ->create();

    $characterStats = $character->stats->toArray();
    $response       = $this->actingAs($user)
                           ->get(route("api-stat-name", $character->name));
    $response->assertJson($characterStats);
});
