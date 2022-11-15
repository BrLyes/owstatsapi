<?php

namespace Tests\Feature;

use App\Models\Character;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RouteApiLifetimeStatsTest extends TestCase
{
    private const ENDPOINT = "api.lifetime.stats";

    public function test_it_returns_422_unauthorized_if_user_is_not_authenticated() {
        $response = $this->postJson(route(self::ENDPOINT));
        $response->assertUnauthorized();
    }

    public function test_it_returns_422_with_errors_if_character_name_is_missing_in_payload() {
        $user   = User::inRandomOrder()->first();

        $response = $this->actingAs($user)
                         ->postJson(route(self::ENDPOINT));

        $response->assertJsonValidationErrors(
            [
                "name" => [
                    "required"
                ]
            ]);
    }

    public function test_it_returns_422_with_errors_if_character_name_is_invalid_in_payload() {
        $user   = User::inRandomOrder()->first();

        $response = $this->actingAs($user)
                         ->postJson(route(self::ENDPOINT), ["name" => Hash::make(5)]);

        $response->assertJsonValidationErrors(
            [
                "name"
            ]);
    }

    public function test_it_returns_all_stats_in_sum_with_character_data_and_total_games_played() {
        $user      = User::inRandomOrder()->first();
        $character = Character::inRandomOrder()->first();
        $assert    = [];

        $games = Game::ofUser($user->id)
                     ->ofCharacterName($character->name)
                     ->get();

        $assert["games"]     = $games->count();
        $assert["character"] = $character->toArray();

        foreach (Game::STATS as $stat) {
            $assert[$stat] = $games->pluck($stat)->sum();
        }

        $response = $this->actingAs($user)
                         ->postJson(route(self::ENDPOINT), ["name" => $character->name]);

        $response->assertSuccessful()
                 ->assertJson($assert);
    }
}
