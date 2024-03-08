<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SatelitCardVendor extends Model
{
    protected $fillable = [
        'name'
    ];

    public function satelit_cards(): HasMany
    {
        return $this->hasMany(SatelitCard::class, 'satelit_card_vendor_id', 'id');
    }
}
