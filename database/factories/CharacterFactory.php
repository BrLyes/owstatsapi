<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Stat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stat>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Character::class;

    public function definition()
    {
        return [
            "name" => fake()->name,
        ];
    }
}
