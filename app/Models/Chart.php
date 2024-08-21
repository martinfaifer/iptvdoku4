<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Chart extends Model
{
    use Prunable;

    protected $fillable = [
        'item', // 'device:id || channel:id ...
        'value',
    ];

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->submonths(1)); // @phpstan-ignore-line
    }

    public function scopeItemCharts(Builder $query, string $item): void
    {
        $query->where('item', 'like', '%' . $item . ':%');
    }

    public function scopeSpecificItemCharts(Builder $query, string $item, int $rows = 20): void
    {
        $query->where('item', $item)->orderBy('id', 'DESC')->take($rows);
    }
}
