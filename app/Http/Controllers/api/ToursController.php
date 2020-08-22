<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tours;
use \Validator;
use App\Http\Controllers\api\Services\FilterQueryService;

class ToursController extends Controller
{
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'limit' => 'sometimes|numeric',
            'offset' => 'sometimes|numeric'
        ]);
        if($validation->fails()){
            return $this->json(["response" => false, "message" => 'The offset and limit field must be of the numeric type']);
        }
        if($request->price != ""){
            return FilterQueryService::filter($request->price, "price", $request->limit, $request->offset);
        }else if($request->start != ""){
            return FilterQueryService::filter($request->start, "start", $request->limit, $request->offset);
        }else if($request->end != ""){
            return FilterQueryService::filter($request->end, "end", $request->limit, $request->offset);
        }else{
            return Tours::all();
        }
    }

    // PARSE JSON FORMAT    
    public static function json($array){
        return json_encode($array);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'price' => 'sometimes|required|numeric|max:99999999',
            'start' => 'sometimes|required|date',
            'end' => 'sometimes|required|date|min:start'
        ]);

        if($validation->fails()){

            return $this->json(["response" => false, "message" => "Invalid Params"]);
        }
        if($request->end < $request->start || $request->start > $request->end){
            return $this->json(["response" => false, "message" => 'Start date must be less than end date']);
        }  
        $tour = Tours::create($request->all());
        if($tour == ""){
            return $this->json(["response" => false, "message" => 'Invalid Params']);
        }else{
            return $this->json(["response" => true, "message" => 'Created']);
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
        $tours = Tours::find($id);
        if($tours != ""){
            return $tours;
        }else{
            return $this->json(["response" => false, "message" => "Non existed id"]);
        }
        
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
        $tours = Tours::find($id);
        if($tours != ""){
            $validation = Validator::make($request->all(), [
                'price' => 'sometimes|required|numeric|max:99999999',
                'start' => 'sometimes|required|date',
                'end' => 'sometimes|required|date'
            ]);
    
            if($validation->fails()){
    
                return $this->json(["response" => false, "message" => "Invalid Params"]);
            }

            if($request->end < $request->start || $request->start > $request->end){
                return $this->json(["response" => false, "message" => 'Start date must be less than end date']);
            }  
            if($tours->updateOrCreate($request->all())){
                return $this->json(["response" => true, "message" => "Updated"]);
            }else{
                return $this->json(["response" => false, "message" => "Error in the database"]);
            }

        }else{
            return $this->json(["response" => false, "message" => "Non existed id"]);
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
        
        
        $tours = Tours::find($id);
        if($tours != ""){
            if($tours->delete()){
                return $this->json(["response" => true, "message" => "Deleted"]);
            }else{
                return $this->json(["response" => false, "message" => "Error in the database"]);
            }
        }else{
            return $this->json(["response" => false, "message" => "Non existed id"]);
        }
        
    }
}
