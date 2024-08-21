<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceVendor extends Model
{
    protected $fillable = [
        'name',
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'device_vendor_id', 'id');
    }

    public function hasSnmp(): HasMany
    {
        return $this->hasMany(DeviceVendorSnmp::class, 'device_vendor_id');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', '%'.$search.'%');
    }
}
