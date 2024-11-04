<?php

namespace App\Http\Requests\Subtask;

use App\Models\Subtask;
use App\Enums\TaskStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubtaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $subtask = Subtask::find($this->route('subtask'));

        return $subtask && $this->user()->can('update subtasks');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:tasks,id'],
            'assigned_user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string',  'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required',  Rule::enum(TaskStatus::class)],
        ];
    }
}