<?php

namespace App\Livewire\Settings\Channels\Banners;

use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SettingsChannelsBannersComponent extends Component
{
    use NotificationTrait;

    public array $filesInFolder = [];

    public function mount(): void
    {
        $files = Storage::allFiles('/public/NanguBanners/');

        foreach ($files as $file) {
            array_push($this->filesInFolder, config('app.url').'/'.str_replace('public', 'storage', $file));
        }
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.channels.banners.settings-channels-banners-component');
    }
}
