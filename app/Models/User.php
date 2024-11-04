<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the projects that belongs to the user.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }


    /**
     * Get the tasks that belongs to the user.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_user_id');
    }

    /**
     * Get the tasks that belongs to the user.
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class, 'assigned_user_id');
    }

    /**
     * Check if the user is a super admin.
     *
     * @return bool Returns true if the user has the 'super-admin' role, false otherwise.
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool Returns true if the user has any of the roles, 'admin', 'super-admin' role, false otherwise.
     */
    public function isAdmin()
    {
        return $this->hasAnyRole(['admin', 'super_admin']);
    }
}
