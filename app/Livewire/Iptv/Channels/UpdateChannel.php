<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use App\Models\ChannelRegion;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Models\ChannelProgramer;
use Illuminate\Support\Facades\Cache;
use App\Models\GeniusTvChannelPackage;
use App\Livewire\Forms\UpdateIptvChannel;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\ChannelRegionTrait;
use App\Traits\Channels\ChannelProgramerTrait;
use App\Traits\Channels\GeniusTVChannelPackagesTrait;
use App\Traits\Channels\GetChannelsCategoriesFromCacheTrait;

class UpdateChannel extends Component
{
    use GetChannelsCategoriesFromCacheTrait, NotificationTrait, WithFileUploads, ChannelRegionTrait, ChannelProgramerTrait, GeniusTVChannelPackagesTrait;

    public UpdateIptvChannel $form;

    #[Locked]
    public ?Channel $channel;

    public mixed $channelType;

    public mixed $logo = null;

    public bool $updateModal = false;

    public array $qualities = Channel::QUALITIES;

    public mixed $channelCategories;

    public mixed $geniusTVChannelPackages;

    public array $channelsEpgs;

    public $regions;
    public $channelProgramers;

    public function mount(?string $channelType = null): void
    {
        $this->channelCategories = $this->get_channels_categories_from_cache();
        $this->geniusTVChannelPackages = $this->getCachedGeniusTvChannelPackages();
        $this->channelsEpgs = ! Cache::has('channelEpgIds') ? [] : Cache::get('channelEpgIds');
        $this->regions = $this->getCachedChannelRegions();
        $this->channelProgramers = $this->getCachedChannelProgramers();
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
