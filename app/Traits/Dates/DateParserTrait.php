<?php

namespace App\Traits\Dates;

trait DateParserTrait
{
    function stringTimeParseToDayMonthYear(string $stringTime)
    {
        $explodedString = explode('T', $stringTime);
        $explodedDate = explode('-', $explodedString[0]);
        $explodedTime = explode('+', $explodedString[1]);

        return $explodedTime[0] . ' ' . $explodedDate[2] . '.' . $explodedDate[1] . ' ' . $explodedDate[0];
    }
}
