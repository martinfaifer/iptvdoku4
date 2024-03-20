<?php

namespace App\Livewire\Iptv\Sftps;

use Livewire\Component;
use App\Livewire\Forms\CreateSftpServerForm;
use App\Traits\Livewire\NotificationTrait;

class CreateSftpServerComponent extends Component
{
    use NotificationTrait;

    public CreateSftpServerForm $storeForm;

    public bool $storeModal = false;

    public function create()
    {
        $storedServer = $this->storeForm->create();
        $this->closeDialog();
        $this->redirect('/sftps/' . $storedServer->id, true);
        return $this->success_alert("Vytvořeno");
    }

    public function openModal()
    {
        $this->resetErrorBag();
        return $this->storeModal = true;
    }

    public function closeDialog()
    {
        return $this->storeModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.sftps.create-sftp-server-component');
    }
}
