<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NanguStb extends Model
{
    protected $fillable = [
        'nangu_stb_accountCode_id',
        'stb',
    ];

    public function stbAccountCode(): BelongsTo
    {
        return $this->belongsTo(NanguStbAccountCode::class, 'nangu_stb_accountCode_id', 'id');
    }
}
