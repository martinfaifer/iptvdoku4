<?php

namespace App\Observers;

use App\Models\SftpServer;
use Illuminate\Support\Facades\Cache;

class SftpServerObserver
{
    public function created(SftpServer $sftpServer)
    {
        Cache::forever('sftp_servers', SftpServer::get(['id', 'name']));
    }

    public function updated(SftpServer $sftpServer)
    {
        Cache::forever('sftp_servers', SftpServer::get(['id', 'name']));
    }

    public function deleted(SftpServer $sftpServer)
    {
        Cache::forever('sftp_servers', SftpServer::get(['id', 'name']));
    }
}
