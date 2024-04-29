<?php

namespace App\Services\Api\NanguTv;

class NanguHelper
{
    public static function getOffersAsString(array $offers): string
    {
        try {
            if (is_null($offers)) {
                return '';
            }

            if (is_string($offers['offerCodes'])) {
                return $offers['offerCodes'];
            }

            $result = [];

            foreach ($offers['offerCodes'] as $offer) {
                array_push($result, $offer);
            }

            return implode(',', $result);
        } catch (\Throwable $th) {
            dd($offers);
        }
    }
}
