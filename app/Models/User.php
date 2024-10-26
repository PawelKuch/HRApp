<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



/**
 * @mixin \Illuminate\Database\Query\Builder
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userId',
        'name',
        'surname',
        'email',
        'password',
    ];

    protected $guarded = [
        'isBlocked',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
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

    public function getFillable(): array
    {
        return $this->fillable;
    }


    public static function findByUserId($userId) : ?User{
        return self::where('userId', $userId)->first();
    }

    public function workTime() : HasMany{
        return $this->hasMany(WorkTime::class);
    }

    public function expense() : HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function leave() : hasMany
    {
        return $this->hasMany(Leave::class);
    }

}
