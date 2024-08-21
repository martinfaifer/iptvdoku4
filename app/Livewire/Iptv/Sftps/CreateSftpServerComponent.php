<?php

namespace App\Livewire\Iptv\Sftps;

use Livewire\Component;
use App\Models\SftpServer;
use App\Livewire\Iptv\Sftps\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSftpServerForm;

class CreateSftpServerComponent extends Component
{
    use NotificationTrait;

    public CreateSftpServerForm $storeForm;

    public bool $storeModal = false;

    public array $connectionTypes = SftpServer::CONNECTION_TYPES;

    public function create(): mixed
    {
        $storedServer = $this->storeForm->create();
        $this->closeDialog();
        $this->redirect('/sftps/' . $storedServer->id, true);

        return $this->success_alert('Vytvořeno');
    }

    public function openModal(): void
    {
        $this->resetErrorBag();

        $this->storeModal = true;
    }

    public function closeDialog(): void
    {
        $this->storeModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.sftps.create-sftp-server-component');
    }
}
