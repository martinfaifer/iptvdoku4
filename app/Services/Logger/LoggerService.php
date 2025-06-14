<?php

namespace App\Services\Logger;

use App\Models\Loger;

class LoggerService
{
    public function __construct(public string $user = '', public string $type = '', public string $item = '', public mixed $payload = '')
    {
        //
    }

    public function log(): void
    {
        Loger::create([
            'user' => $this->user,
            'type' => $this->type,
            'item' => $this->item,
            'payload' => $this->payload,
        ]);
    }

    public function show(string $column, string $columnValue, int $records = 10, string $order = 'DESC'): mixed
    {
        return Loger::where($column, $columnValue)->take($records)->orderBy('id', $order)->take(10)->get();
    }
}
