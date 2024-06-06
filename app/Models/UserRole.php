<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_role_id', 'id');
    }

    public function scopeAdmin(Builder $query)
    {
        return $query->where('name', 'admin');
    }

    public function scopeTechnik(Builder $query)
    {
        return $query->where('name', 'technik');
    }

    public function scopeAdministrativa(Builder $query)
    {
        return $query->where('name', 'administrativa');
    }

    public function scopeApi(Builder $query)
    {
        return $query->where('name', 'API');
    }

    public function scopeReader(Builder $query)
    {
        return $query->where('name', 'reader');
    }
}
