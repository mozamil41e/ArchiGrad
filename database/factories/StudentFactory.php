<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory(),
            'project_id' => Project::inRandomOrder()->first()->id ?? Project::factory(),
            'name' => $this->faker->name(),
            'university_number' => $this->faker->unique()->numerify('##########'),
        ];
    }
}
