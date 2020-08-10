<?php

namespace App\Http\Controllers;

use App\Tours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Tours::all()->get(1)->paginate(20);

        return response()->json($all, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start' => 'required|date',
            'end' => 'required|date',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }

        $craete_tour = Tours::create($request->all());

        return response()->json([$craete_tour, "messege" => "Tours created successfully"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $find_tour = Tours::find($id);

            return response()->json($find_tour, 200);
        } catch (\Throwable $e) {

            return response()->json($e->getMessage(), 400);
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
        try {
            $update_tours = Tours::find($id);
            $update_tours->update($request->all());

            return response()->json([$update_tours, "messege" => "Tours update successfully"], 201);
        } catch (\Throwable $th) {

            return response()->json($th->getMessage(), 400);
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
        try {
            $delete_tours = Tours::destroy($id);

            return response()->json([$delete_tours, "messege" => "Tours deleted successfully"], 201);
        } catch (\Throwable $th) {

            return response()->json($th->getMessage(), 400);
        }
    }
}
