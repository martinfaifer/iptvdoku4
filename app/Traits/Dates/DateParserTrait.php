<?php

namespace App\Traits\Dates;

use DateTime;

trait DateParserTrait
{
    public function stringTimeParseToDayMonthYear(string $stringTime)
    {
        $explodedString = explode('T', $stringTime);
        $explodedDate = explode('-', $explodedString[0]);
        $explodedTime = explode('+', $explodedString[1]);

        return $explodedTime[0].' '.$explodedDate[2].'.'.$explodedDate[1].' '.$explodedDate[0];
    }

    public function stringTimeParseToTime(string $stringTime)
    {
        $explodedString = explode('T', $stringTime);
        $explodedDate = explode('-', $explodedString[0]);
        $explodedTime = explode('+', $explodedString[1]);

        return $explodedTime[0];
    }

    public function isTimeBetween(string $start, string $stop): string
    {
        $current_time = now()->format('H:i:s');
        $current = DateTime::createFromFormat('H:i:s', $current_time);
        $startTime = DateTime::createFromFormat('H:i:s', $this->stringTimeParseToTime($start));
        $endTime = DateTime::createFromFormat('H:i:s', $this->stringTimeParseToTime($stop));
        // dd($current, $startTime, $endTime);
        if ($current > $startTime && $current < $endTime) {
            return 'running-channel';
        }

        return 'not-running';
    }
}
