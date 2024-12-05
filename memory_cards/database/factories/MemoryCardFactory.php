<?php

namespace Database\Factories;

use App\Models\Groups;
use App\Models\Langs;
use App\Models\MemoryCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemoryCard>
 */
class MemoryCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'foreign_word' => fake()->word(),
            'translation' => fake()->word(),
            'group_id' => Groups::factory(),
            'color' => fake()->hexcolor(),
        ];
    }
}
