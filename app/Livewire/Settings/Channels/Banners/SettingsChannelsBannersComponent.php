<?php

namespace App\Livewire\Settings\Channels\Banners;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class SettingsChannelsBannersComponent extends Component
{

    public array $filesInFolder = [];

    public function mount()
    {
        $files = Storage::allFiles('/public/NanguBanners/');

        foreach ($files as $file) {
            array_push($this->filesInFolder, config('app.url') . "/" . str_replace('public', 'storage', $file));
        }
    }

    public function render()
    {
        return view('livewire.settings.channels.banners.settings-channels-banners-component');
    }
}
