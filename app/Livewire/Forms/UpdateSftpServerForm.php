<?php

namespace App\Livewire\Forms;

use App\Models\SftpServer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSftpServerForm extends Form
{
    public ?SftpServer $sftpServer;

    #[Validate('required', message: 'Vyplňte uživatelksé jméno pro přihlášení')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $username = '';

    #[Validate('required', message: 'Vyplňte heslo pro přihlášení')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $password = '';

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    public ?string $path_to_folder = null;

    public function set_sftp_server(object $sftpServer): void
    {
        $this->sftpServer = $sftpServer;
        $this->username = $sftpServer->username;
        $this->password = $sftpServer->password;
        $this->path_to_folder = $sftpServer->path_to_folder;
    }

    public function update(): void
    {
        $this->validate();

        $this->sftpServer->update([
            'username' => $this->username,
            'password' => $this->password,
            'path_to_folder' => $this->path_to_folder,
        ]);

        $this->reset();
    }
}
