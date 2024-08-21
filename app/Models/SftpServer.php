<?php

namespace App\Models;

use App\Observers\SftpServerObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SftpServerObserver::class)]
class SftpServer extends Model
{
    const CONNECTION_TYPES = [
        [
            'id' => 'sftp',
            'name' => 'sftp',
        ],
        [
            'id' => 'ftp',
            'name' => 'ftp',
        ],
    ];

    protected $fillable = [
        'name',
        'url',
        'username',
        'password',
        'path_to_folder',
        'connection_type',
    ];

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', '%' . $search . '%')->orWhere('url', 'like', '%' . $search . '%');
    }
}
