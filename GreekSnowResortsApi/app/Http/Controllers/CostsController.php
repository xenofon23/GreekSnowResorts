<?php

namespace App\Http\Controllers;

use App\Models\Costs;
use Illuminate\Http\Request;

class CostsController extends Controller
{
    public function index()
    {
        $costs = Costs::all();
        return response()->json($costs);
    }

    public function show($id)
    {
        $costs = Slopes::findOrFail($id);
        return response()->json($costs);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'snow_resort_id' => 'required|integer',
            'type' => 'required|string|max:255',
            'costs' => 'required|integer',
        ]);

        $costs = Costs::create($validatedData);
        return response()->json($costs, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'snow_resort_id' => 'required|integer',
            'type' => 'required|string|max:255',
            'costs' => 'required|integer',
        ]);

        $costs = Costs::findOrFail($id);
        $costs->update($validatedData);

        return response()->json($costs);
    }

    public function destroy($id)
    {
        $costs = Costs::findOrFail($id);
        $costs->delete();

        return response()->json(null, 204);
    }
    public function getBySnowResortId($id)
    {
        $costs=Costs::where('snow_resort_id', $id)->get();
        return response()->json($costs);
    }
}
