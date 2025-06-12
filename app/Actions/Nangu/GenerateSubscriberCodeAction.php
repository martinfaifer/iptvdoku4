<?php

namespace App\Actions\Nangu;

class GenerateSubscriberCodeAction
{
    public function execute($numberOfCharacters = 4, string $prefix = "PROMO-"): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $numberOfCharacters; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $prefix . $randomString;
    }
}
