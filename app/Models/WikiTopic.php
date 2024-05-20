<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\WikiTopicObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(WikiTopicObserver::class)]
class WikiTopic extends Model
{
    protected $fillable = [
        'title',
        'text',
        'creator',
        'wiki_category_id',
    ];

    // public function text(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Str::of($value)->markdown(),
    //     );
    // }

    public function category(): BelongsTo
    {
        return $this->belongsTo(WikiCategory::class, 'wiki_category_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('title', "like", "%" . $search)->orWhere('text', "like", "%" . $search . "%");
    }
}
