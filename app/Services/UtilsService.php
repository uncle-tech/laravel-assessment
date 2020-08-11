<?php

namespace App\Services;
use Carbon\Carbon;

class UtilsService
{
    public function equalDates($date1, $date2)
    {
        return Carbon::create($date1)->eq(Carbon::create($date2));
    }
}
