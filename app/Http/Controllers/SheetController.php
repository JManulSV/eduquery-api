<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class SheetController extends Controller
{
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        // Buscar el aula más reciente
        $classroom = $user
            ->classrooms()
            ->where('name', $request->classroom)
            ->orderBy('created_at', 'desc')
            ->first();

        // Verificar si se encontró el aula
        if (!$classroom) {
            return response()->json(['error' => 'Classroom not found'], 404);
        }

        // Crear la nueva hoja
        $sheet = new Sheet([
            'id' => $request->sheet_id,
            'classroom_id' => $classroom->id,
        ]);

        $sheet->save();

        // Asumimos que la relación en Classroom se llama sheets
        //$newSheet = $classroom->sheet()->save($sheet);

        return response()->json(['data' => $sheet]);
    }
}
