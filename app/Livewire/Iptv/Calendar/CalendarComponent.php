<?php

namespace App\Livewire\Iptv\Calendar;

use App\Models\Event;
use Livewire\Component;
use App\Models\CssColor;
use Illuminate\Support\Str;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Calendar\RunningEventsTrait;
use App\Traits\Calendar\UpcomingEventsTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\UpdateCalendarEventForm;

class CalendarComponent extends Component
{
    use NotificationTrait, UpcomingEventsTrait, RunningEventsTrait;

    public UpdateCalendarEventForm $form;

    public array $events;

    public array $upcomingEvents;

    public array $runningEvents;

    public array $dayEvents;

    public bool $updateModal = false;

    public function mount()
    {
        $this->upcomingEvents = $this->upcoming_events();
        $this->runningEvents = $this->running_events();
        $this->show_events();
    }

    public function show_events()
    {
        $allEvents = Event::take(50)->with('background_color')->get();
        foreach ($allEvents as $singleEvent) {
            if ($singleEvent->start_date == $singleEvent->end_date || is_null($singleEvent->end_date)) {
                $this->events[] = [
                    'label' => $singleEvent->label,
                    'description' => $singleEvent->description,
                    'css' => $singleEvent->background_color->color,
                    'date' => now()->createFromFormat("Y-m-d", $singleEvent->start_date),
                ];
            } else {
                $this->events[] = [
                    'label' => $singleEvent->label,
                    'description' => $singleEvent->description,
                    'css' => $singleEvent->background_color->color,
                    'range' => [now()->createFromFormat("Y-m-d", $singleEvent->start_date), now()->createFromFormat("Y-m-d", $singleEvent->end_date)],
                ];
            }
        }
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
