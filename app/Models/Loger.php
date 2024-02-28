<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loger extends Model
{
    const CREATED_TYPE = "created";
    const UPDATED_TYPE = "updated";
    const DELETED_TYPE = "deleted";

    protected $fillable = [
        'user', // email
        'type', // create, update , delete
        'item', // device:id , multicast:id ...
        'payload' // content
    ];
}
