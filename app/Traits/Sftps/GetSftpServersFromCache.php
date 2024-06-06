<?php
namespace App\Traits\Sftps;

use App\Models\SftpServer;
use Illuminate\Support\Facades\Cache;

trait GetSftpServersFromCache
{
    public function get_sftp_servers_from_cache()
    {
        if(!Cache::has('sftp_servers')) {
            Cache::forever('sftp_servers', SftpServer::get(['id', 'name']));
        }
        return Cache::get('sftp_servers');
    }
}
