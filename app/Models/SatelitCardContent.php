<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SatelitCardContent extends Model
{
    protected $fillable = [
        'satelit_card_id',
        'file_name',
        'path'
    ];

    public function satelitCard(): BelongsTo
    {
        return $this->belongsTo(SatelitCard::class, 'satelit_card_id', 'id');
    }
}
