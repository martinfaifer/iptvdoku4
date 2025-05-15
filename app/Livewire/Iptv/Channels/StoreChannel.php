<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ChannelProgramer;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Cache;
use App\Livewire\Forms\StoreChannelForm;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\ChannelRegionTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Channels\GetChannelPackagesTrait;
use App\Traits\Channels\GetChannelsCategoriesFromCacheTrait;

class StoreChannel extends Component
{
    use GetChannelsCategoriesFromCacheTrait, NotificationTrait, WithFileUploads, GetChannelPackagesTrait, ChannelRegionTrait;

    public StoreChannelForm $form;

    public bool $storeModal = false;
    public array $qualities = Channel::QUALITIES;
    public mixed $geniusTVChannelPackages;
    public mixed $channelCategories;
    public array $channelsEpgs;

    public mixed $regions;
    public Collection $channelProgramers;

    public function mount(): void
    {
        $this->channelCategories = $this->get_channels_categories_from_cache();
        $this->geniusTVChannelPackages = $this->getPackages();
        $this->channelsEpgs = ! Cache::has('channelEpgIds') ? [] : Cache::get('channelEpgIds');
        $this->regions = $this->getCachedChannelRegions();
        $this->channelProgramers = ChannelProgramer::get();
    }

    public function store(): mixed
    {
        $channelId = $this->form->submit();
        $this->redirect('/channels/' . $channelId . '/multicast', true);

        return $this->success_alert('Kanál přidán');
    }

    public function closeDialog(): void
    {
        $this->storeModal = false;
        $this->resetErrorBag();
        $this->form->reset();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.channels.store-channel');
    }
}
