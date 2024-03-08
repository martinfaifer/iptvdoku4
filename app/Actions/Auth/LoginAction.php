<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function __construct(public string $email, public string $password)
    {
        //
    }

    public function __invoke(): bool
    {
        $attempt = Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            true
        );

        // dd($this->email, $this->password);
        if ($attempt) {
            return true;
        }

        return false;
    }
}
