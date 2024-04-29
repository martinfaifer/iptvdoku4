<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WikiCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(WikiTopic::class, 'wiki_category_id', 'id');
    }
}
