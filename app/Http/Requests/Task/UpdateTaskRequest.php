<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = Task::find($this->route('task'));

        return $task && $this->user()->can('update tasks');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string',  'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', Rule::enum(TaskPriority::class)],
            'status' => ['required',  Rule::enum(TaskStatus::class)],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'estimated_time' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
