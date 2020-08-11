<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToursController extends Controller
{
    protected function repository()
    {
        return app()->make('App\Contracts\ToursRepository');
    }

    /**
     * Lists all the tours
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json($this->repository()->all());
    }

    /**
     * Gets the data of the tour whose id was specified in the request
     *
     * @param integer $id The id of the tour
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response()->json($this->repository()->find($id));
    }

    /**
     * Creates a new Tour
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'start' => 'required|date',
                'end' => 'required|date',
                'price' => 'required|numeric|min:0|max:9999',
            ]);
    
            return response()->json([
                'id' => $this->repository()->create($data),
                'success' => true,
                'message' => null,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'id' => null,
                'success' => false,
                'message' => $e->getMessage(),
            ], 409);
        }
    }

    protected function updateMethod(int $id) : string
    {
        return empty($this->repository()->find($id))
            ? 'createWithId'
            : 'update';
    }

    /**
     * Updates the tour data or creates it if the id does not exist.
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $method = $this->updateMethod($id);
            return response()->json([
                'success' => $this->repository()->$method(
                    $id,
                    $request->validate([
                        'start' => 'nullable|date',
                        'end' => 'nullable|date',
                        'price' => 'nullable|numeric|min:0|max:9999',
                    ])
                ),
                'message' => null,
            ], $method == 'update' ? 200 : 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 409);
        }
    }

    /**
     * Deletes the tour with the specified id
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return response()->json([
            'success' => $this->repository()->destroy($id),
        ]);
    }
}

