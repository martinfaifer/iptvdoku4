<?php

namespace App\Livewire\Iptv\Calendar;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Traits\Livewire\NotificationTrait;
use App\Models\NanguIspTagToChannelPackage;
use App\Traits\Users\GetUsersFromCacheTrait;
use App\Traits\Sftps\GetSftpServersFromCache;
use App\Livewire\Forms\CreateCalendarEventForm;
use App\Traits\Channels\GetChannelFromCacheTrait;
use App\Actions\CssColors\GetCssColorsFromCacheAction;
use App\Traits\Tags\GetNanguIspTagsToChannelPackagesTrait;

class CreateCalendarEventComponent extends Component
{
    use GetChannelFromCacheTrait,
        GetSftpServersFromCache,
        GetUsersFromCacheTrait,
        NotificationTrait,
        WithFileUploads,
        GetNanguIspTagsToChannelPackagesTrait;

    public CreateCalendarEventForm $form;

    public bool $storeModal = false;

    public Collection $users;

    public Collection $cssColors;

    public Collection $channels;

    public Collection $sftpServers;

    public array $tags;

    public function mount()
    {
        $this->cssColors = (new GetCssColorsFromCacheAction())();
        $this->users = $this->get_users_from_cache();
        $this->channels = $this->get_channels_from_cache();
        $this->sftpServers = $this->get_sftp_servers_from_cache();
        $this->tags = $this->get_nangu_isp_tags_to_channels();
    }

    public function create()
    {
        $this->form->create();
        $this->redirect(url()->previous(), true);
        $this->closeModal();

        return $this->success_alert('Přidáno');
    }

    public function openModal()
    {
        return $this->storeModal = true;
    }

    public function closeModal()
    {
        $this->form->reset();

        return $this->storeModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.calendar.create-calendar-event-component');
    }
}
