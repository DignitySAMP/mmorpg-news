<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location' => fake()->country(),
            'gender' => fake()->randomElement(['male', 'female', 'other', 'hidden']),
            'date_of_birth' => fake()->dateTime(),
            'show_profile' => fake()->boolean(80),
            'show_online_status' => fake()->boolean(50),
            'show_comments' => fake()->boolean(50),
        ];
    }
}
