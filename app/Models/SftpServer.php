<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SftpServer extends Model
{
    protected $fillable = [
        'name',
        'url',
        'username',
        'password',
        'path_to_folder'
    ];
}
