<?php

use App\Models\Character;

//TODO: refactor this to use Factory

test("it_returns_422_if_no_name_is_provided", function(){
    $response = $this::withHeaders(
        [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ]
    )->get(route("api-stat-name"));
    $response->assertStatus(422);
});

test("it_returns_422_if_name_is_invalid", function(){
    $response = $this::withHeaders(
        [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ]
    )->get(route("api-stat-name","invalid"));
    $response->assertStatus(422);
});

test("it_returns_200_if_name_is_valid", function(){
    $response = $this->get(route("api-stat-name","ashe"));
    $response->assertStatus(200);
});

test("it_returns_character_stats_if_name_is_valid", function(){
    $characterStats = Character::where("name","ashe")->first()->stats->toArray();
    $response = $this->get(route("api-stat-name","ashe"));
    $response->assertJson($characterStats);
});
