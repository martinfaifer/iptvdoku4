<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
