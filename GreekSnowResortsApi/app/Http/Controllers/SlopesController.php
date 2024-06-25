<?php

namespace App\Http\Controllers;

use App\Models\Slopes;
use Illuminate\Http\Request;

class SlopesController extends Controller
{

        public function index()
    {
        $slopes = Slopes::all();
        return response()->json($slopes);
    }

        public function show($id)
    {
        $slope = Slopes::findOrFail($id);
        return response()->json($slope);
    }

        public function store(Request $request)
    {
        $validatedData = $request->validate([
            'snow_resort_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'difficulty' => 'nullable|string|max:50',
            'length_m' => 'required|integer',
            'altitude_m' => 'nullable|integer',
            'average_slope_percent' => 'nullable|numeric',
            'details' => 'nullable|string',
        ]);

        $slope = Slopes::create($validatedData);
        return response()->json($slope, 201);
    }

        public function update(Request $request, $id)
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

        $slope = Slopes::findOrFail($id);
        $slope->update($validatedData);

        return response()->json($slope);
    }

        public function destroy($id)
    {
        $slope = Slopes::findOrFail($id);
        $slope->delete();

        return response()->json(null, 204);
    }
    }
