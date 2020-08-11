<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ToursRepository;
use App\Tour;

class Tours extends EloquentRepository implements ToursRepository
{
    protected function model() : Model
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

    public function createWithId(int $id, array $data) : bool
    {
        $tour = $this->model();

        \array_map(function($attr) use ($tour, $data) {
            if (\array_key_exists($attr, $data))
                $tour->$attr = $data[$attr];
        }, $this->validFields());

        $tour->id = $id;

        return $tour->save();
    }
}
