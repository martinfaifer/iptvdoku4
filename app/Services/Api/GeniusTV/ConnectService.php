<?php

namespace App\Services\Api\GeniusTV;

use Illuminate\Support\Facades\DB;

class ConnectService
{
    public mixed $connection;
    public function __construct()
    {
        $this->connection = DB::build([
            'driver' => 'mysql',
            'host' => config('services.api.geniustv_database.host'),
            'port' => '3306',
            'database' => config('services.api.geniustv_database.name'),
            'username' => config('services.api.geniustv_database.username'),
            'password' => config('services.api.geniustv_database.password'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);
    }

    public function count_data_in_month()
    {
        // dd($this->connection);
        $result = $this->connection
            ->table('store_genius_customer_data')
            ->whereDate('created_at', '2025-06-10')
            ->count();

        dd($result);
    }
}
