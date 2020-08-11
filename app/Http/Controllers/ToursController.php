<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tour;
use Validator;

class ToursController extends Controller
{
    public function readAll(){

        $tour = new Tour;
        $param = ['price', 'start', 'end'];
        
        //Para cada parametro possivel, verificar se foi passado no request
        foreach($param as $value){
            if (request()->has($value)){
                
                //Cria uma collection com chave => valor e em seguida um array com a key
                $col = collect(request()->get($value));
                $key = $col->keys();

                //Verifica o valor da key(eq, lte, gte) e adiciona ao where
                if($key[0] == 'eq')
                    $tour = $tour->where($value, '=', request($value));
                if($key[0] == 'lte')
                    $tour = $tour->where($value, '<=', request($value));
                if($key[0] == 'gte')
                    $tour = $tour->where($value, '>=', request($value));
            }  
        } 
        return response()->json($tour->paginate(20), 200);   
    }
        

    public function readById($id){

        $tour = Tour::find($id);
        if (is_null($tour)){
            return response()->json(["message" => "Record not found"], 404);
        }
        return response()->json($tour, 200);
    }

    public function create(Request $request){

        $data = $request->all();
        $rules = ['start' => 'required',
                  'end' => 'required',
                  'price' => 'required'];

        $validator = Validator::make($data, $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        return response()->json(Tour::create(
            ['start' => $data['start'],
             'end' => $data['end'],
             'price' => $data['price']   
            ]), 201);
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::find($id);
        if (is_null($tour)){
            return response()->json(["message" => "Record not found"], 404);
        }
        $tour->update($request->all());
        return response()->json($tour, 200);
    }

    public function delete($id){
        $tour = Tour::find($id);

        if (is_null($tour)){
            return response()->json(["message" => "Record not found"], 404);
        }
        $tour->delete();
        return response()->json(null, 204);
    }
}