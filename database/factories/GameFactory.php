<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stat>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Game::class;

    public function definition()
    {
        return [
            "kill" => fake()->numberBetween(0, 20),
            "death" => fake()->numberBetween(0,20),
            "assist" => fake()->numberBetween(0, 20),
            "damage" => fake()->numberBetween(0, 10000),
            "heal" => fake()->numberBetween(0, 10000),
            "mitigate" => fake()->numberBetween(0, 10000),
            "accuracy" => fake()->randomFloat(2, 0.00, 100.00),
            "user_id" => User::inRandomORder()->first()->id,
            "character_id" => User::inRandomORder()->first()->id,
            "match_date" => Carbon::now()->subMinutes(rand(1, 129600)),
        ];
    }
}
