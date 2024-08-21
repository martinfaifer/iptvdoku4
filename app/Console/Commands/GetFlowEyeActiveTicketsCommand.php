<?php

namespace App\Console\Commands;

use App\Events\BroadcastFlowEyeTicketsEvent;
use App\Services\Api\FlowEye\ConnectService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;

class GetFlowEyeActiveTicketsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'floweye:get-active-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting active tickets from ISP Floweye and store them in to the cache';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $status = null;
        $tickets = [];
        $connectService = (new ConnectService(
            endpointType: 'procesess',
            formData: [
                'templateId' => config('services.api.8.floweye.template_id'),
                'state' => is_null($status) ? 'active' : 'complete',
                'include' => 'template,currentStep,discussion,variables(detail,ticket,resolver,attached_files)',
                'limit' => 100,
                'variables' => json_encode([
                    'department_choosed' => config('services.api.8.floweye.department'),
                ]),
            ]
        ));

        // cacheKey: 'floweye_active_tickets'
        $response = $connectService->connect();

        if ($response['status'] != 'error') {
            foreach ($response['data'] as $ticket) {
                if ($ticket['current_step']['sid'] != 'assignment') {
                    if ($ticket['current_step']['sid'] != 'closed') {
                        // find user which resolving task
                        if ($ticket['current_step']['resolver'] != null) {
                            $ticket['resitel'] = (new ConnectService(
                                endpointType: 'user',
                                formData: null,
                                params: $ticket['current_step']['resolver']['id']
                            ))->connect();
                        }
                        $tickets['data'][] = $ticket;
                    }
                }
            }
            // $tickets = collect($tickets);
            Cache::put('floweye_active_tickets', $tickets, 3600);
            // store how many tickets left
            Cache::put('floweye_active_tickets_count', count($tickets['data']), 3600);

            BroadcastFlowEyeTicketsEvent::dispatch();
            // Broadcast::on('floweye_active_tickets')
            //     ->as('FlowEyeActiveTicketsEvent')
            //     ->send();
        }
    }
}
