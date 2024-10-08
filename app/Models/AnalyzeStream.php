<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class AnalyzeStream extends Model
{
    use Prunable;

    const MULTICAST_PORT = ':1234';

    protected $fillable = [
        'stream_url',
        'analyze',
    ];

    protected $casts = [
        'created_at' => 'datetime:H:i d.m. Y',
    ];

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->submonths(2)); // @phpstan-ignore-line
    }

    protected function analyze(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value)
        );
    }
}
