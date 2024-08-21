<?php

namespace App\Livewire\Iptv\Calendar;

use App\Actions\CssColors\GetCssColorsFromCacheAction;
use App\Livewire\Forms\CreateCalendarEventForm;
use App\Traits\Channels\GetChannelFromCacheTrait;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Sftps\GetSftpServersFromCache;
use App\Traits\Tags\GetNanguIspTagsToChannelPackagesTrait;
use App\Traits\Users\GetUsersFromCacheTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCalendarEventComponent extends Component
{
    use GetChannelFromCacheTrait,
        GetNanguIspTagsToChannelPackagesTrait,
        GetSftpServersFromCache,
        GetUsersFromCacheTrait,
        NotificationTrait,
        WithFileUploads;

    public CreateCalendarEventForm $form;

    public bool $storeModal = false;

    public Collection $users;

    public Collection $cssColors;

    public Collection $channels;

    public Collection $sftpServers;

    public array $tags;

    public function mount(): void
    {
        $this->cssColors = (new GetCssColorsFromCacheAction())();
        $this->users = $this->get_users_from_cache();
        $this->channels = $this->get_channels_from_cache();
        $this->sftpServers = $this->get_sftp_servers_from_cache();
        $this->tags = $this->get_nangu_isp_tags_to_channels();
    }

    public function create(): mixed
    {
        $this->form->create();
        $this->redirect(url()->previous(), true);
        $this->closeModal();

        return $this->success_alert('Přidáno');
    }

    public function openModal(): void
    {
        $this->storeModal = true;
    }

    public function closeModal(): void
    {
        $this->form->reset();

        $this->storeModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.calendar.create-calendar-event-component');
    }
}
