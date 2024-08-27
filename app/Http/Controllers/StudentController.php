<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    public function store(Request $request, String $classroom_id)
    {
        $data = GoogleSheetController::getStudentsFromSheet($request->id_sheet, $request->page_name);

        if (isset($data['error'])) {
            return response()->json([
                'message' => $data['error']
            ], 500);
        }

        $studentsSaved = [];
        $errors = [];
        $existingNames = Student::where('classroom_id', $classroom_id)->pluck('name')->toArray();

        foreach ($data as $key => $student) {
            try {
                if (!isset($student['nombre'])) {
                    $errors[] = [
                        'record' => $student,
                        'error' => 'Missing nombre field'
                    ];
                    continue;
                }
                $name = $student['nombre'];
                if (in_array($name, $existingNames)) {
                    $errors[] = [
                        'record' => $student,
                        'error' => 'Duplicate nombre detected'
                    ];
                    continue;
                }

                $newStudent = Student::create([
                    'name' => $student['nombre'],
                    'classroom_id' => $classroom_id,
                ]);
                
                array_push($studentsSaved, $newStudent);
            } catch (\Throwable $th) {
                $errors[] = [
                    'record' => $student,
                    'error' => $th->getMessage()
                ];
            }
        }
        return response()->json([
            'message' => 'Students Add Successfully',
            'data' => $studentsSaved,
            'errors' => $errors
        ]);
    }
}
