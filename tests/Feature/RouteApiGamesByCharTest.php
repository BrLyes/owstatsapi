<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RouteApiGamesByCharTest extends TestCase
{
    private const ENDPOINT = "api.games.by.char";

    public function test_it_returns_422_unauthorized_if_user_is_not_authenticated() {
        $response = $this->getJson(route(self::ENDPOINT));
        $response->assertUnauthorized();
    }

    public function test_it_returns_characters_with_ordered_by_games_played_if_user_is_authenticated() {
        $user  = User::inRandomOrder()->first();
        $games = Game::select(DB::raw("character_id, count(*) as total"))
                     ->ofUser($user->id)
                     ->with("character")
                     ->groupBy("character_id")
                     ->orderBy("total","desc")
                     ->get();

        $response = $this->actingAs($user)
                         ->get(route(self::ENDPOINT));

        $response->assertSuccessful()
                 ->assertJson($games->toArray());
    }
}
