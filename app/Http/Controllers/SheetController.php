<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class SheetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sheet_id' => 'required|integer',
            'classroom' => 'required|string',
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        $classroom = $user->classrooms()
            ->where('name', $request->classroom)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$classroom) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }

        $sheet = new Sheet([
            'id' => $request->sheet_id,
            'classroom_id' => $classroom->id,
        ]);

        try {
            $sheet->save();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error saving sheet'], 500);
        }

        return response()->json(['message' => 'Sheet created successfully', 'data' => $sheet], 201);
    }
}
