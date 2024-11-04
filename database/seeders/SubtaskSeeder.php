<?php

namespace Database\Seeders;

use App\Models\Subtask;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubtaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subtask::factory()
            ->count(3)
            ->create();
    }
}
