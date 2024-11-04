<?php

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', array_column(TaskPriority::cases(), 'value'))->default(TaskPriority::MEDIUM->value);
            $table->enum('status', array_column(TaskStatus::cases(), 'value'))->default(TaskStatus::TODO->value);
            $table->date('due_date')->nullable();
            $table->integer('estimated_time')->nullable()->comment('Time in minutes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
