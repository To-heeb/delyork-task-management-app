<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use App\Rules\ValidCommentable;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $comment = Comment::find($this->route('comment'));

        return $comment && $this->user()->can('update comments');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:1500'],
            'commentable_id' => ['required', 'integer', new ValidCommentable($this->input('commentable_type'))],
            'commentable_type' => ['required', 'integer', Rule::in(['task', 'subtask'])],
        ];
    }
}
