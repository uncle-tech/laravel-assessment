<?php

namespace App\Http\Controllers\api\Services;
use Illuminate\Http\Request;
use App\Models\Tours;
use \Validator;
use App\Http\Controllers\api\ToursController;
class FilterQueryService{


    // FILTERING THE OPERATOR AND CALLING THE FACTORYQUERY FUNCTION
    public static function filter($request, $field, $limit, $offset){
        
        if(array_key_exists("eq", $request)){
            if($field == "price" && is_numeric($request["eq"])){
                return FilterQueryService::factoryQuery("eq", $request["eq"], $field, $limit, $offset);
            }else if($field != "price"){
                return FilterQueryService::factoryQuery("eq", $request["eq"], $field, $limit, $offset);
            }else{
                return ToursController::json(["response" => false, "message" => "write a number on the price param"]);
            }
        }
        else if(array_key_exists("lte", $request)){
            if($field == "price" && is_numeric($request["lte"])){
                return FilterQueryService::factoryQuery("lte", $request["lte"], $field, $limit, $offset);
            }else if($field != "price"){
                return FilterQueryService::factoryQuery("lte", $request["lte"], $field, $limit, $offset);
            }else{
                return ToursController::json(["response" => false, "message" => "write a number on the price param"]);
            }
        }
        else if(array_key_exists("gte", $request)){
            if($field == "price" && is_numeric($request["gte"])){
                return FilterQueryService::factoryQuery("gte", $request["gte"], $field, $limit, $offset);
            }else if($field != "price"){
                return FilterQueryService::factoryQuery("gte", $request["gte"], $field, $limit, $offset);
            }else{
                return ToursController::json(["response" => false, "message" => "write a number on the price param"]);
            }
        }else{
            return ToursController::json(["response" => false, "message" => "Invalid Operator"]);
        }
    }

    // CREATING DATABASE OPERATION TO REDEEM VALUES
    public static function factoryQuery($operator, $value, $field, $limit, $offset){

        $limit = $limit != "" ? $limit : 1000000;
        switch($operator){
            case "eq":
                $tours =  Tours::where($field, $value)->limit($limit)->offset($offset)->get();
                return ToursController::json($tours);
            break;
            case "lte":
                $tours =  Tours::where($field,"<=", $value)->limit($limit)->offset($offset)->get();
                return ToursController::json($tours);
            break;
            case "gte":
                $tours =  Tours::where($field,">=", $value)->limit($limit)->offset($offset)->get();
                return ToursController::json($tours);
            break;
            
        }
        
    }



}