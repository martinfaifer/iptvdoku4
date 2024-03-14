<?php

namespace App\Livewire\Iptv\Calendar;

use App\Livewire\Forms\UpdateCalendarEventForm;
use App\Models\CssColor;
use App\Models\Event;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class CalendarComponent extends Component
{
    use NotificationTrait;

    public UpdateCalendarEventForm $form;

    public array $events;

    public array $upcomingEvents;

    public array $dayEvents;

    public bool $updateModal = false;

    public function mount()
    {
        $this->upcomingEvents = Event::where('start_date', ">=",now()->format('Y-m-d'))->orderBy('start_date', "ASC")->with('user')->get()->toArray();
        $this->show_events();
    }

    public function show_events()
    {
        $allEvents = Event::take(50)->get();
        foreach ($allEvents as $singleEvent) {
            $color = CssColor::where('color', $singleEvent->color)->first()->hex;
            if($singleEvent->start_date == $singleEvent->end_date || is_null($singleEvent->end_date )) {
                $this->events[] = [
                    'label' => $singleEvent->label,
                    'description' => $singleEvent->description,
                    'css' => "!bg-". str_replace("cs-", "", $singleEvent->color),
                    'date' => now()->createFromFormat("Y-m-d", $singleEvent->start_date),
                ];
            } else {
                $this->events[] = [
                    'label' => $singleEvent->label,
                    'description' => $singleEvent->description,
                    'css' => "!bg-". str_replace("cs-", "", $singleEvent->color),
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
