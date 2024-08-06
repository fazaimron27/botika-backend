<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('id_ID');

        $name = $faker->name;

        return [
            'name' => $name,
            'email' => Str::lower(str_replace(' ', '', $name)) . '@mail.com',
            'phone' => $faker->phoneNumber,
            'job_id' => $faker->numberBetween(1, 5),
            'status' => $faker->randomElement(['active', 'inactive']),
        ];
    }
}
