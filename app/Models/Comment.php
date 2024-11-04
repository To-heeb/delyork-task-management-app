<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'content',
        'commentable_id',
        'commentable_type',
    ];


    /**
     * Get the parent commentable model (task or subtask).
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
