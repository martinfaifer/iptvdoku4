<?php

namespace App\Livewire\Iptv\Calendar;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use App\Models\Channel;
use Livewire\Component;
use App\Models\CssColor;
use App\Models\SftpServer;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Traits\Livewire\NotificationTrait;
use App\Models\NanguIspTagToChannelPackage;
use App\Traits\Calendar\RunningEventsTrait;
use App\Traits\Calendar\UpcomingEventsTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\UpdateCalendarEventForm;

class CalendarComponent extends Component
{
    use NotificationTrait, UpcomingEventsTrait, RunningEventsTrait, WithFileUploads;

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
        $this->sftpServers = SftpServer::get(['id', 'name']);
        $this->cssColors = CssColor::get();
        $this->upcomingEvents = $this->upcoming_events();
        $this->runningEvents = $this->running_events();
        $this->channels = Channel::orderBy('name', "ASC")->get(['id', 'name']);
        $this->users = User::get();
        if (NanguIspTagToChannelPackage::first()) {
            foreach (NanguIspTagToChannelPackage::distinct()->get('tag_id') as $nanguIspTagToChannelPackage) {

                $this->tags[] = [
                    'id' => $nanguIspTagToChannelPackage->tag_id,
                    'name' => Tag::find($nanguIspTagToChannelPackage->tag_id)->name
                ];
            }
        }

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
                    'css' => is_null($singleEvent->background_color) ? "!bg-red-500/20" : "!".$singleEvent->background_color->color."/20",
                    'date' => now()->createFromFormat("Y-m-d", $singleEvent->start_date),
                ];
            } else {
                $this->events[] = [
                    'label' => $singleEvent->label,
                    'description' => Str::markdown($singleEvent->description),
                    'css' => is_null($singleEvent->background_color) ? "!bg-red-500/20" : "!".$singleEvent->background_color->color."/20",
                    'range' => [now()->createFromFormat("Y-m-d", $singleEvent->start_date), now()->createFromFormat("Y-m-d", $singleEvent->end_date)],
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
        return $this->success_alert("Upraveno");
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
        return $this->success_alert("Odebrána událost");
    }


    public function render()
    {
        return view('livewire.iptv.calendar.calendar-component');
    }
}
