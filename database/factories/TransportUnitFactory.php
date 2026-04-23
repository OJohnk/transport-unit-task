<?php

namespace Database\Factories;

use App\Models\TransportUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransportUnit>
 */
class TransportUnitFactory extends Factory
{
    public function definition(): array
	{
		return [
			'name' => fake()->bothify('Unit-??###'),
			'type' => fake()->randomElement(['truck', 'trailer']),
		];
	}
}
