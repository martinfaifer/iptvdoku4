<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
}
