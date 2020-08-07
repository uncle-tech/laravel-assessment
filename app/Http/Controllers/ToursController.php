<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 


use App\Tours;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $input = $request->all();
        $passeios = \DB::table('tours')->whereNull('deleted_at');

        if(isset($input['price'])){
            foreach($input['price'] as $key => $price){
                if($key == 'eq'){
                    $passeios->where('price',$price);
                }
                if($key == 'lte'){
                    $passeios->where('price','<=',$price);
                }
                if($key == 'gte'){
                    $passeios->where('price','>=',$price);
                }
                
            } 
        } 

        if(isset($input['start'])){
            foreach($input['start'] as $key => $start){
                if($key == 'eq'){
                    $passeios->where('start',$start);
                }
                if($key == 'lte'){
                    $passeios->where('start','<=',$start);
                }
                if($key == 'gte'){
                    $passeios->where('start','>=',$start);
                }
                
            } 
        }

        if(isset($input['end'])){
            foreach($input['end'] as $key => $end){
                if($key == 'eq'){
                    $passeios->where('end',$end);
                }
                if($key == 'lte'){
                    $passeios->where('end','<=',$end);
                }
                if($key == 'gte'){
                    $passeios->where('end','>=',$end);
                }
                
            } 
        } 

        if(isset($input['limit']) && isset($input['offset'])){
            $passeios->limit($input['limit'])->offset($input['offset']);

        }
        
        
        return response()->json(['passeios' => $passeios->get()], 200);
    }


    public function store(Request $request)
    {
        $dados = array_except($request->all(), array('token'));
        $passeio = Tours::create($dados);
        if ($passeio) {
            return response()->json(['passeio' => $passeio], 200);
        } else {
            return response()->json(['data' => 'Erro ao criar o passeio'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $passeio = Tours::find($id);
        return response()->json(['passeio' => $passeio], 200);
    }

 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dados = array_except($request->all(), array('token', 'id'));
        $passeio = Tours::find($id);
        if ($passeio) {
            $passeio->update($dados);
            return response()->json(['passeio' => $passeio], 200);
        } else {
            return response()->json(['data' => 'Não foi possivél atualizar o passeio'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $passeio = Tours::find($id);
        if ($passeio) {
            $passeio->delete();
            return response()->json(['message' => 'Passeio deletado'], 200);
        } else {
            return response()->json(['message' => 'Passeio não localizado'], 400);
        }
    }
}
