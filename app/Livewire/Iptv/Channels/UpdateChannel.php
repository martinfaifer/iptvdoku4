<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ChannelCategory;
use App\Models\GeniusTvChannelPackage;
use App\Livewire\Forms\UpdateIptvChannel;
use App\Traits\Livewire\NotificationTrait;

class UpdateChannel extends Component
{
    use WithFileUploads, NotificationTrait;
    public UpdateIptvChannel $form;

    public ?Channel $channel;
    public $channelType;
    public $logo;
    public bool $updateModal = false;

    public $qualities = Channel::QUALITIES;
    public $channelCategories;
    public $geniusTVChannelPackages;

    public function mount($channelType = null)
    {
        $this->channelCategories = ChannelCategory::orderBy('name')->get(['id', 'name']);
        $this->geniusTVChannelPackages = GeniusTvChannelPackage::get();
    }

    public function update()
    {
        $this->form->update();

        if (!is_null($this->logo)) {
            $path = $this->logo->store(path: 'public/Logos');
            $this->channel->update([
                'logo' => $path
            ]);
        }

        $this->closeDialog();
        $this->dispatch('update_channels_sidebar');
        // $this->dispatch('update_iptv_channel.' . $this->channel->id);
        // $this->dispatch('update_iptv_channel_multicast.' . $this->channel->id, channelId: $this->channel->id);
        $this->success_alert("Upraveno");
        return $this->redirect("/channels/" . $this->channel->id . "/multicast", true);
    }

    public function closeDialog()
    {
        $this->updateModal = false;
    }

    public function edit()
    {
        $this->form->setChannel($this->channel, $this->qualities);
        $this->updateModal = true;
    }

    public function render()
    {
        return view('livewire.iptv.channels.update-channel');
    }
}
