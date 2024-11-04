<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::all()->random()->id,
            'assigned_user_id' => User::all()->random()->id,
            'title' => fake()->word(),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement(TaskPriority::cases()),
            'status' => fake()->randomElement(TaskStatus::cases()),
            'due_date' => null,
            'estimated_time' => null,
        ];
    }
}
