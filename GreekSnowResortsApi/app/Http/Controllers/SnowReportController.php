<?php

namespace App\Http\Controllers;

use App\Models\SnowReport;
use Illuminate\Http\Request;

class SnowReportController extends Controller
{
    public function index()
    {
        $snowReports = SnowReport::with('snowResort')->get();
        return response()->json($snowReports);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'snow_resort_id' => 'required|exists:snow_resorts,id', // Ensure snow_resort_id exists in snow_resorts table
            'last_snowfall' => 'required|date',
            'depth_base' => 'required|numeric',
            'depth_top' => 'required|numeric',
        ]);

        $snowReport = SnowReport::create( $validated);

        return response()->json($snowReport, 201);
    }
    public function updateOrCreate($data,$id)
    {
        $snowReport = SnowReport::updateOrCreate(
            ['snow_resort_id' => $id],
            $data
        );
        return response()->json($snowReport, 201);
    }

    public function show($id)
    {
        $snowReport = SnowReport::with('snowResort')->findOrFail($id);
        return response()->json($snowReport);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'snow_resort_id' => 'required|exists:snow_resorts,id',
            'last_snowfall' => 'required|date',
            'depth_base' => 'required|numeric',
            'depth_top' => 'required|numeric',
        ]);

        $snowReport = SnowReport::findOrFail($id);
        $snowReport->update($validated);
        return response()->json($snowReport);
    }

    public function destroy($id)
    {
        $snowReport = SnowReport::findOrFail($id);
        $snowReport->delete();
        return response()->json(['message' => 'Snow report deleted successfully']);
    }
}
