<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'user_role_id',
        'avatar_url'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }


    public function userRole(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    public function isAdmin()
    {
        return $this->user_role_id == UserRole::admin()->first()->id;
    }

    public function isTechnik()
    {
        return $this->user_role_id == UserRole::technik()->first()->id;
    }

    public function isAdministrativa()
    {
        return $this->user_role_id == UserRole::administrativa()->first()->id;
    }

    public function isApi()
    {
        return $this->user_role_id == UserRole::api()->first()->id;
    }

    public function isReader()
    {
        return $this->user_role_id == UserRole::reader()->first()->id;
    }



    public function scopeSearch(Builder $query, string $search)
    {
        return $query
            ->where('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', '%' . $search . '%')
            ->orWhere('email', '%' . $search . '%');
    }
}
