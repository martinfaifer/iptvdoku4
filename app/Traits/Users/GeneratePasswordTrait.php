<?php

namespace App\Traits\Users;

use Illuminate\Support\Str;

trait GeneratePasswordTrait
{
    public function generate_password(): string
    {
        return Str::password(length: 8, numbers: true, symbols: false, spaces: false);
    }
}
