<?php

namespace Tests\Feature;

use App\Models\Character;
use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RouteApiGameHistoryTest extends TestCase
{
    private const ENDPOINT = "api.games.history";

    public function test_it_returns_422_unauthorized_if_user_is_not_authenticated() {
        $response = $this->postJson(route(self::ENDPOINT));
        $response->assertUnauthorized();
    }

    public function test_it_returns_422_with_errors_if_character_name_is_missing_in_payload() {
        $user = User::inRandomOrder()->first();

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
        $user = User::inRandomOrder()->first();

        $response = $this->actingAs($user)
                         ->postJson(route(self::ENDPOINT), ["name" => Hash::make(5)]);

        $response->assertJsonValidationErrors(
            [
                "name"
            ]);
    }

    public function test_it_returns_all_games_in_order_with_character_data() {
        $user      = User::inRandomOrder()->first();
        $character = Character::inRandomOrder()->first();
        $assert    = [];

        $games = Game::ofUser($user->id)
                     ->ofCharacterName($character->name)
                     ->orderBy("match_date")
                     ->get();

        $assert["games"]     = $games->toArray();
        $assert["total"]     = $games->count();
        $assert["character"] = $character->toArray();

        $response = $this->actingAs($user)
                         ->postJson(route(self::ENDPOINT), ["name" => $character->name]);

        $response->assertSuccessful()
                 ->assertJson($assert);
    }
}
