<?php

namespace App\Livewire\Iptv\Channels;

use App\Livewire\Forms\UpdateIptvChannel;
use App\Models\Channel;
use App\Models\GeniusTvChannelPackage;
use App\Traits\Channels\GetChannelsCategoriesFromCacheTrait;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateChannel extends Component
{
    use GetChannelsCategoriesFromCacheTrait, NotificationTrait, WithFileUploads;

    public UpdateIptvChannel $form;

    public ?Channel $channel;

    public mixed $channelType;

    public mixed $logo = null;

    public bool $updateModal = false;

    public array $qualities = Channel::QUALITIES;

    public mixed $channelCategories;

    public mixed $geniusTVChannelPackages;

    public array $channelsEpgs;

    public function mount(?string $channelType = null): void
    {
        $this->channelCategories = $this->get_channels_categories_from_cache();
        $this->geniusTVChannelPackages = GeniusTvChannelPackage::get();
        $this->channelsEpgs = ! Cache::has('channelEpgIds') ? [] : Cache::get('channelEpgIds');
    }

    public function update(): mixed
    {
        $this->form->update();

        if (! is_null($this->logo)) {
            $path = $this->logo->store(path: 'public/Logos');
            $this->channel->update([
                'logo' => $path,
            ]);
        }

        $this->closeDialog();
        $this->redirect('/channels/' . $this->channel->id . '/multicast', true);

        return $this->success_alert('Upraveno');
    }

    public function closeDialog(): void
    {
        $this->updateModal = false;
    }

    public function edit(): void
    {
        $this->form->setChannel($this->channel, $this->qualities);
        $this->updateModal = true;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.channels.update-channel');
    }
}
