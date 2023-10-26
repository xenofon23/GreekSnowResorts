<?php

namespace App\Http\Controllers;

use App\Models\SnowResorts;
use Illuminate\Http\Request;

class SnowResortController extends Controller
{
    public function index()
    {
        $snowResorts = SnowResorts::all();
        return response()->json($snowResorts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        $snowResort = SnowResorts::create($data);
        return response()->json($snowResort, 201);
    }
    public function show($id)
    {
        $liftAvailability = SnowResorts::find($id);

        if (!$liftAvailability) {
            return response()->json(['message' => 'snow resort not found'], 404);
        }

        return response()->json($liftAvailability);
    }
}
