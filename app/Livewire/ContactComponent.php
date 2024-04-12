<?php

namespace App\Livewire;

use App\Livewire\Forms\StoreContactForm;
use App\Livewire\Forms\UpdateContact;
use App\Models\Contact;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ContactComponent extends Component
{
    use NotificationTrait;

    public StoreContactForm $contactForm;

    public UpdateContact $updateForm;

    public Collection $contacts;

    public bool $storeModal = false;

    public bool $updateModal = false;

    public string $type;

    public int $item_id;

    public function mount(string $type, int $item_id)
    {
        $this->type = $type;
        $this->item_id = $item_id;
        $this->contacts = Contact::where('type', $type)->where('item_id', $item_id)->get();
    }

    public function openStoreModal()
    {
        return $this->storeModal = true;
    }

    public function create()
    {
        $this->contactForm->create($this->type, $this->item_id);

        $this->resetErrorBag();

        $this->closeDialog();

        $this->dispatch('refresh_contacts');

        return $this->success_alert('Kontakt přidán');
    }

    public function closeDialog()
    {
        $this->updateModal = false;

        return $this->storeModal = false;
    }

    public function edit(Contact $contact)
    {
        $this->updateForm->set_contact($contact);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->resetErrorBag();

        $this->closeDialog();

        $this->dispatch('refresh_contacts');

        return $this->success_alert('Kontakt upraven');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        $this->dispatch('refresh_contacts');

        return $this->success_alert('Kontakt odebrán');
    }

    #[On('refresh_contacts')]
    public function refresh_contacts()
    {
        return $this->contacts = Contact::where('type', $this->type)->where('item_id', $this->item_id)->get();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col gap-4 w-52">
                <div class="skeleton h-32 w-full"></div>
                <div class="skeleton h-4 w-28"></div>
                <div class="skeleton h-4 w-full"></div>
                <div class="skeleton h-4 w-full"></div>
            </div>
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.contact-component');
    }
}
