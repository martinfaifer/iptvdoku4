<?php

namespace App\Livewire\Iptv\Cards;

use Livewire\Component;
use App\Models\SatelitCard;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\SatelitCardContent;
use Illuminate\Support\Facades\Storage;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\StoreSatelitCardContentForm;

class SatelitCardContentsComponent extends Component
{
    use WithFileUploads, NotificationTrait, WithPagination;

    public SatelitCard $satCard;
    public StoreSatelitCardContentForm $storeForm;
    public bool $storeModal = false;

    public function openStoreModal()
    {
        return $this->storeModal = true;
    }

    public function create()
    {
        $this->storeForm->create($this->satCard->id);
        $this->success_alert("Nahráno");
        $this->dispatch('refresh_satelit_card_content');
        return $this->storeModal = false;
    }


    public function destroy(SatelitCardContent $file)
    {
        Storage::delete($file->path);
        $file->delete();
        $this->dispatch('refresh_satelit_card_content');
        return $this->success_alert("Soubor odebrán");
    }

    public function closeDialog()
    {
        return $this->storeModal = false;
    }

    #[On('refresh_satelit_card_content')]
    public function render()
    {
        return view('livewire.iptv.cards.satelit-card-contents-component', [
            'headers' => [
                ['key' => 'file_name', 'label' => 'Soubor', 'class' => 'text-white/80'],
                ['key' => 'created_at', 'label' => 'Nahráno', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
            'contents' => $this->satCard->contents()->paginate(10),
        ]);
    }
}
