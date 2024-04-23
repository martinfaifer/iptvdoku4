<?php

namespace App\Models;

use App\Observers\TagOnItemObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(TagOnItemObserver::class)]
class TagOnItem extends Model
{
    protected $fillable = [
        'type', // channel, device ...
        'item_id',
        'tag_id',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }

    public function scopeOnlyDevicesWithTag(Builder $query, int $tagId)
    {
        return $query->where('type', 'device')->where('tag_id', $tagId);
    }
}
