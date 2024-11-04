<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Taggable extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tag_id',
        'taggable_id',
        'taggable_type'
    ];

    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }
}
