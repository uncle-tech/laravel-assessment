<?php

namespace App\Repositories;
use App\Tour;

class Tours extends EloquentRepository
{
    protected function model() : Tour
    {
        return new Tour;
    }

    protected function validFields() : array
    {
        return [
            'start',
            'end',
            'price',
        ];
    }
}
