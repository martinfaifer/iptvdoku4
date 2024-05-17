<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class ChangeUserPasswordForm extends Form
{
    #[Validate('required', message: "Vyplňte heslo")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('min:8', message: "Minimální počet znaků je :min")]
    #[Validate('max:99', message: "Maximální počet znaků je :max")]
    public string $password = "";

    #[Validate('required', message: "Vyplňte heslo")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('min:8', message: "Minimální počet znaků je :min")]
    #[Validate('max:99', message: "Maximální počet znaků je :max")]
    #[Validate('same:password', message: "Hesla se neshodují")]
    public string $newpassword = "";

    public function update()
    {
        $this->validate();

        Auth::user()->update([
            'password' => $this->password
        ]);

        $this->reset();
    }
}
