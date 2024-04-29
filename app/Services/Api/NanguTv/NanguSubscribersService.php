<?php

namespace App\Services\Api\NanguTv;

use App\Models\NanguIsp;
use App\Models\NanguSubscriber;

class NanguSubscribersService
{
    public function get()
    {
        $connection = (new ConnectService('subscriber'));

        $numberOfRecords = 0;
        foreach (NanguIsp::get() as $nanguIsp) {

            do {
                $nanguResponse = $connection->connect(
                    ['search' => [
                        'firstResult' => $numberOfRecords,
                        'ispCode' => $nanguIsp->nangu_isp_id,
                        'orderBy' => 'SUBSCRIBER_ID',
                    ]],
                    'search'
                );

                $numberOfRecords += 500;
                if (! array_key_exists('subscribers', $nanguResponse)) {
                    break;
                }

                foreach ($nanguResponse['subscribers'] as $subscriber) {
                    try {
                        if (! NanguSubscriber::where('subscriberCode', $subscriber['subscriberCode'])
                            ->where('nangu_isp_id', $nanguIsp->nangu_isp_id)
                            ->first()) {
                            NanguSubscriber::create([
                                'subscriberCode' => $subscriber['subscriberCode'],
                                'nangu_isp_id' => $nanguIsp->id,
                            ]);
                        } else {
                            echo $subscriber['subscriberCode'].' '.$nanguIsp->nangu_isp_id.PHP_EOL;
                        }
                    } catch (\Throwable $th) {
                        if (! NanguSubscriber::where('subscriberCode', $nanguResponse['subscribers']['subscriberCode'])
                            ->where('nangu_isp_id', $nanguIsp->nangu_isp_id)
                            ->first()) {
                            NanguSubscriber::create([
                                'subscriberCode' => $nanguResponse['subscribers']['subscriberCode'],
                                'nangu_isp_id' => $nanguIsp->id,
                            ]);
                        }
                    }
                }
            } while (count($nanguResponse['subscribers']) == 500);
            $numberOfRecords = 0;
        }
    }
}
