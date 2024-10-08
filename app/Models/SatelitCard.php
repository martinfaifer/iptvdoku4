<?php

namespace App\Models;

use App\Observers\SatelitCardObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(SatelitCardObserver::class)]
class SatelitCard extends Model
{
    protected $fillable = [
        'name',
        'satelit_card_vendor_id',
        'status',
        'expiration',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(SatelitCardVendor::class, 'satelit_card_vendor_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(SatelitCardContent::class, 'satelit_card_id');
    }

    public function scopeSearch(Builder $query, string $search = ''): void
    {
        $query->where('name', 'like', '%'.$search.'%');
    }
}
