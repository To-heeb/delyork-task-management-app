<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];


    /**
     * Get all of the tasks that are assigned this tag.
     */
    public function tasks(): MorphToMany
    {
        return $this->morphedByMany(Task::class, 'taggable');
    }

    /**
     * Get all of the subtasks that are assigned this tag.
     */
    public function subtasks(): MorphToMany
    {
        return $this->morphedByMany(Subtask::class, 'taggable');
    }

    /**
     * Get all of the subtasks that are assigned this tag.
     */
    // public function related(): MorphOne
    // {
    //     return $this->morphOne(Taggable::class, 'taggable');
    // }
}
