<?php

namespace App\Livewire\Iptv\Sftps;

use App\Livewire\Forms\UpdateSftpServerForm;
use App\Models\SftpServer;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class UpdateSftpServerComponent extends Component
{
    use NotificationTrait;

    public UpdateSftpServerForm $updateForm;

    public ?SftpServer $sftpServer;

    public bool $updateModal = false;

    public function edit(): void
    {
        $this->updateForm->set_sftp_server($this->sftpServer);
        $this->resetErrorBag();

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->redirect('/sftps/'.$this->sftpServer->id, true);

        return $this->success_alert('Upraveno');
    }

    public function closeDialog(): void
    {
        $this->updateModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.sftps.update-sftp-server-component');
    }
}
