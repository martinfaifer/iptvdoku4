<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Loger extends Model
{
    use Prunable;

    const CREATED_TYPE = 'created';

    const UPDATED_TYPE = 'updated';

    const DELETED_TYPE = 'deleted';

    protected $fillable = [
        'user', // email
        'type', // create, update , delete
        'item', // device:id , multicast:id ...
        'payload', // content
    ];

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->submonths(2)); // @phpstan-ignore-line
    }

    public function scopeForUser(Builder $query, string $user): void
    {
        $query->where('user', $user);
    }

    public function scopeSearch(Builder $query, string $search = ''): void
    {
        $query->where('user', 'like', '%'.$search.'%')->orWhere('payload', 'like', '%'.$search.'%');
    }
}
