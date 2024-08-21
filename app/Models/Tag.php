<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    const ACTIONS = [
        [
            'id' => 1,
            'name' => 'check_gpu',
        ],
        [
            'id' => 2,
            'name' => 'promo',
        ],
        [
            'id' => 3,
            'name' => 'nimble_api',
        ],
        [
            'id' => 4,
            'name' => 'ssh_login',
        ],
        [
            'id' => 5,
            'name' => 'grape_transcoder_api',
        ],
        [
            'id' => 6,
            'name' => 'can_channel_restart',
        ],
        [
            'id' => 7,
            'name' => 'channel_restart',
        ],
    ];

    protected $fillable = [
        'name',
        'color',
        'action',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(TagOnItem::class, 'tag_id', 'id');
    }

    public function nangu_isps(): HasMany
    {
        return $this->hasMany(NanguIspTagToChannelPackage::class, 'tag_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query
            ->where('name', 'like', '%'.$search.'%');
    }

    public function scopeHasActionChannelRestart(Builder $query): void
    {
        $query->where('action', 6);
    }
}
