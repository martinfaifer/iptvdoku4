<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceCategory extends Model
{
    protected $fillable = [
        'name',
        'icon'
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'device_category_id', 'id');
    }
}
