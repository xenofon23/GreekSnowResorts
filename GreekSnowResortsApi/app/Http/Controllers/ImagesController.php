<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;


class ImagesController extends Controller
{
    public function index()
    {
        $images = Images::all();
        return response()->json($images);
    }

    public function show($id)
    {
        try {
            $image = Images::findOrFail($id);
            return response()->json($image);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Image not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'snow_resort_id' => 'required|integer',
            'image_url' => 'required|string',
            'caption' => 'required|string',
        ]);

        $image = Images::create($validatedData);
        return response()->json($image, 201);
    }

    public function destroy($id)
    {
        try {
            $image = Images::findOrFail($id);
            $image->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Image not found'], 404);
        }
    }













}
