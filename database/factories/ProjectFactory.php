<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Supervisor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'supervisor_id' => Supervisor::inRandomOrder()->first()->id ?? Supervisor::factory(),
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(),
            'year' => $this->faker->year(),
            'grade' => $this->faker->randomElement(['A', 'B+', 'C+', 'C', 'F', 'pending']),
            'is_archiv' => $this->faker->boolean(),
        ];
    }
}
