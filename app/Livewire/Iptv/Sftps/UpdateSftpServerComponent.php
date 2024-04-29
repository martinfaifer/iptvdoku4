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

    public function edit()
    {
        $this->updateForm->set_sftp_server($this->sftpServer);
        $this->resetErrorBag();

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->redirect('/sftps/'.$this->sftpServer->id, true);

        return $this->success_alert('Upraveno');
    }

    public function closeDialog()
    {
        return $this->updateModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.sftps.update-sftp-server-component');
    }
}
