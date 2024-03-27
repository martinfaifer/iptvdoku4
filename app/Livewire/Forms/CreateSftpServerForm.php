<?php

namespace App\Livewire\Forms;

use App\Models\SftpServer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSftpServerForm extends Form
{
    #[Validate('required', message: "Vyplňte název serveru")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:100', message: "Maximální počet znaků je :max")]
    #[Validate('unique:sftp_servers,name', message: "Tento popis již existuje")]
    public string $name = "";

    #[Validate('required', message: "Vyplňte url serveru")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    #[Validate('unique:sftp_servers,url', message: "Tato url již existuje")]
    public string $url = "";

    #[Validate('required', message: "Vyplňte uživatelksé jméno pro přihlášení")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $username = "";

    #[Validate('required', message: "Vyplňte heslo pro přihlášení")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $password = "";

    #[Validate('nullable')]
    #[Validate('string', message: "Neplatný formát")]
    public string|null $path_to_folder = null;

    #[Validate('required', message: "Vybrrte typ připojení")]
    public string $connection_type = "";

    public function create()
    {
        $this->validate();

        $sftpServer = SftpServer::create([
            'name' => $this->name,
            'url' => $this->url,
            'username' => $this->username,
            'password' => $this->password,
            'path_to_folder' => $this->path_to_folder,
            'connection_type' => $this->connection_type
        ]);

        $this->reset();

        return $sftpServer;
    }
}
