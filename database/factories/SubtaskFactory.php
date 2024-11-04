<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subtask>
 */
class SubtaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::all()->random()->id,
            'assigned_user_id' => User::all()->random()->id,
            'title' => fake()->word(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(TaskStatus::cases()),
        ];
    }
}
