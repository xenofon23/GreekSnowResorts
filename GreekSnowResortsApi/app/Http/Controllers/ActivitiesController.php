<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{

    public function index()
    {
        $slopes = Activities::all();
        return response()->json($slopes);
    }

    public function show($id)
    {
        $slope = Activities::findOrFail($id);
        return response()->json($slope);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'snow_resort_id' => 'required|integer',
            'type' => 'required|string|max:255',
            'language' => 'required|string|max:50',
        ]);

        $slope = Activities::create($validatedData);
        return response()->json($slope, 201);
    }

    public function Activities(Request $request, $id)
    {
        $validatedData = $request->validate([
            'resort_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'difficulty' => 'nullable|string|max:50',
            'length_m' => 'required|integer',
            'altitude_m' => 'nullable|integer',
            'average_slope_percent' => 'nullable|numeric',
            'details' => 'nullable|string',
        ]);

        $slope = Activities::findOrFail($id);
        $slope->update($validatedData);

        return response()->json($slope);
    }

    public function destroy($id)
    {
        $slope = Activities::findOrFail($id);
        $slope->delete();

        return response()->json(null, 204);
    }
}
