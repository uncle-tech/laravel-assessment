<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use App\Tour;

class TourController extends Controller
{
    private $array = ['error' => '', 'result' => []];

    public function all(Request $request)
    {
        $key = $request->all();
        if ($key) {
            $newKey =  $this->converter($key);

            if ($newKey[0] === 'start' || $newKey[0] === 'end') {
                $newDate = str_replace('T', ' ', $newKey[2]);
               //$newValue = date("Y-m-d H:i:s", strtotime($newDate));
            } else {
                $newValue = $newKey[2];
            }

            if ($request->filled('limit') && $request->filled('offset')) {
                $tours = Tour::all()->take($key['limit'])->skip($key['offset']);
            } else {
                $tours = Tour::all()->where($newKey[0], $this->operator($newKey[1]), date($newDate));
            }
        } else {
            $tours = Tour::all();
        }

        foreach ($tours as $tour) {
            $this->array['result'][] = [
                'id' => $tour->id,
                'start' => $tour->start,
                'end' => $tour->end,
                'price' => $tour->price
            ];
        }

        return $this->array;
    }

    public function one($id)
    {
        $tour = Tour::find($id);

        if ($tour) {
            $this->array['result'] = [
                'id' => $tour->id,
                'start' => $tour->start,
                'end' => $tour->end,
                'price' => $tour->price
            ];
        } else {
            $this->array['error'] = 'ID not found';
        }

        return $this->array;
    }

    public function new(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $price = $request->input('price');

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->array['error'] = $validator->errors();
        } else {

            if ($start && $end && $price) {
                $tour = new Tour();
                $tour->start = $start;
                $tour->end = $end;
                $tour->price = $price;
                $tour->save();

                $this->array['result'] = [
                    'tour' => 'Created',
                    'id' => $tour->id,
                    'start' => $start,
                    'end' => $end,
                    'end' => $price
                ];
                /*} else {
                $this->array['error'] = 'unsent fields';
            }*/
            }
        }
        return $this->array;
    }

    public function edit(Request $request, $id)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $price = $request->input('price');

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->array['error'] = $validator->errors();
        } else {

            $tour = Tour::find($id);
            if ($tour) {
                $tour->start = $start;
                $tour->end = $end;
                $tour->price = $price;
                $tour->save();

                $this->array['result'] = [
                    'tour' => 'Updated',
                    'id' => $id,
                    'start' => $start,
                    'end' => $end,
                    'price' => $price
                ];
            } else {
                $this->array['error'] = 'non-existent id';
            }
        }
        return $this->array;
    }

    public function delete($id)
    {

        $tour = Tour::find($id);
        if ($tour) {
            $tour->delete();
            $this->array['result'] = ['Tour' => 'deleted'];
        } else {
            $this->array['error'] = 'non-existent id';
        }
        return $this->array;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'start' => 'required|date|date_format:Y-m-d H:i:s',
            'end' => 'required|date|date_format:Y-m-d H:i:s',
            'price' => 'required|numeric',
        ]);
    }
    protected function converter($value)
    {
        $value = json_encode($value);
        $value = str_replace(array('{', '}'), '', $value);
        $value = explode(':', $value);
        $value = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $value);
        return $value;
    }

    protected function operator($operator)
    {
        /* lte = menor ou igual a
           gte = maior ou igual a
           eq = igual
        */
        if ($operator === 'lte') {
            $operatorValue = '<=';
        } elseif ($operator === 'gte') {
            $operatorValue = '>=';
        } elseif($operator === 'eq') {
            $operatorValue = '=';
        }else{
            $operatorValue = '=';
        }
        return $operatorValue;
    }
}
