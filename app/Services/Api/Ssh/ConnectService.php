<?php

namespace App\Services\Api\Ssh;

use phpseclib3\Net\SSH2;

class ConnectService
{

    public $ssh;

    public function __construct(public string $ip, public string $username, public string $password)
    {
        $this->connect();
    }

    public function connect(): SSH2|false
    {
        try {
            $this->ssh = new SSH2($this->ip);

            if (!$this->ssh->login($this->username, $this->password)) {
                return false;
            }

            return $this->ssh;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function send_command(string $command): false|string
    {
        if ($this->ssh === false) {
            // nepodařilo se připojit
            return false;
        }

        $this->ssh->write($command . PHP_EOL);
        return $this->ssh->read();
    }
}
