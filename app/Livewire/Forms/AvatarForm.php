<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class AvatarForm extends Form
{
    use WithFileUploads;

    #[Validate('required', message: "Nemůžete nahrát nic")]
    #[Validate('image', message: "Neplatný formát")]
    #[Validate('max:1024', message: "Maximální velikost souboru je :size")]
    public $avatar;

    public function upload_avatar()
    {
        $this->validate();
        $path = $this->avatar->store(path: 'public/avatars');
        Auth::user()->update([
            'avatar_url' => str_replace('public', "storage", $path)
        ]);

        $this->reset();
    }

    public function delete_avatar()
    {
        Auth::user()->update([
            'avatar_url' => null
        ]);
    }
}
