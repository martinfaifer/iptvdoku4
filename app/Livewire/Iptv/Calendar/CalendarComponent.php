<?php

namespace App\Livewire\Iptv\Calendar;

use App\Models\Tag;
use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Traits\Livewire\NotificationTrait;
use App\Models\NanguIspTagToChannelPackage;
use App\Traits\Calendar\RunningEventsTrait;
use App\Traits\Calendar\UpcomingEventsTrait;
use App\Traits\Users\GetUsersFromCacheTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Sftps\GetSftpServersFromCache;
use App\Livewire\Forms\UpdateCalendarEventForm;
use App\Traits\Channels\GetChannelFromCacheTrait;
use App\Actions\CssColors\GetCssColorsFromCacheAction;
use App\Traits\Tags\GetNanguIspTagsToChannelPackagesTrait;

class CalendarComponent extends Component
{
    use GetChannelFromCacheTrait,
        GetSftpServersFromCache,
        GetUsersFromCacheTrait,
        NotificationTrait,
        RunningEventsTrait,
        UpcomingEventsTrait,
        WithFileUploads,
        GetNanguIspTagsToChannelPackagesTrait;

    public UpdateCalendarEventForm $form;

    public array $events;

    public array $upcomingEvents;

    public array $runningEvents;

    public array $dayEvents;

    public bool $updateModal = false;

    public Collection $cssColors;

    public Collection $users;

    public Collection $channels;

    public Collection $sftpServers;

    public array $tags;

    public function mount()
    {
        $this->sftpServers = $this->get_sftp_servers_from_cache();
        $this->cssColors = (new GetCssColorsFromCacheAction())();
        $this->upcomingEvents = $this->upcoming_events();
        $this->runningEvents = $this->running_events();
        $this->channels = $this->get_channels_from_cache();
        $this->users = $this->get_users_from_cache();
        $this->tags = $this->get_nangu_isp_tags_to_channels();

        $this->show_events();
    }

    public function show_events()
    {
        $allEvents = Event::take(50)->with('background_color')->get();
        foreach ($allEvents as $singleEvent) {
            if ($singleEvent->start_date == $singleEvent->end_date || is_null($singleEvent->end_date)) {
                $this->events[] = [
                    'label' => $singleEvent->label,
                    'description' => Str::markdown($singleEvent->description),
                    'css' => is_null($singleEvent->background_color) ? '!bg-red-500/20' : '!' . $singleEvent->background_color->color . '/20',
                    'date' => now()->createFromFormat('Y-m-d', $singleEvent->start_date),
                ];
            } else {
                $this->events[] = [
                    'label' => $singleEvent->label,
                    'description' => Str::markdown($singleEvent->description),
                    'css' => is_null($singleEvent->background_color) ? '!bg-red-500/20' : '!' . $singleEvent->background_color->color . '/20',
                    'range' => [now()->createFromFormat('Y-m-d', $singleEvent->start_date), now()->createFromFormat('Y-m-d', $singleEvent->end_date)],
                ];
            }
        }
        // dd($this->events);
    }

    public function edit(Event $event)
    {
        $this->form->setEvent($event);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->form->update();
        $this->closeModal();
        $this->redirect('/calendar', true);

        return $this->success_alert('Upraveno');
    }

    public function closeModal()
    {
        $this->resetErrorBag();
        $this->form->reset();
        $this->redirect('/calendar', true);

        return $this->updateModal = false;
    }

    public function destroy(Event $event)
    {
        $event->delete();

        $this->redirect('/calendar', true);

        return $this->success_alert('Odebrána událost');
    }

    public function render()
    {
        return view('livewire.iptv.calendar.calendar-component');
    }
}
