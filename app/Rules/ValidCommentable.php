<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCommentable implements ValidationRule
{
    protected $allowedTypes = [
        'task' => \App\Models\Task::class,
        'subtask' => \App\Models\Subtask::class,
    ];

    protected $commentableType;

    public function __construct($commentableType)
    {
        $this->commentableType = strtolower($commentableType);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!array_key_exists($this->commentableType, $this->allowedTypes)) {
            $fail("Invalid commentable type provided.");
        }

        $modelClass = $this->allowedTypes[$this->commentableType];

        if (!$modelClass::find($value)) {
            $fail("The selected {$this->commentableType} does not exist.");
        }
    }
}
