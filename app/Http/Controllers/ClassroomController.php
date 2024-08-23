<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ClassroomController extends Controller
{
    /**
     * Display the specified classroom.
     *
     * @param string $id The ID of the classroom to retrieve.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response containing the classroom data or an error message.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the classroom with the specified ID is not found.
     * @throws \Throwable If any other error occurs during the retrieval process.
     */
    public function index(String $id)
    {
        $classroom = Classroom::findOrFail($id);

        try {
            return response()->json([
                'status' => 'success',
                'data' => $classroom
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving the classroom',
                'details' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created classroom in the database.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the classroom data.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response with either a success message and data or an error message.
     *
     * @throws \Illuminate\Validation\ValidationException If the request data fails validation.
     * @throws \Throwable If any other error occurs during the creation of the classroom.
     */
    public function store(ClassroomRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        try {
            $newClassroom = Classroom::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'user_id' => $user->id
            ]);

            return response()->json(['status' => 'success', 'data' => $newClassroom], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the classroom',
                'details' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified classroom in the database.
     *
     * @param \App\Http\Requests\ClassroomRequest $request The incoming HTTP request containing the updated classroom data.
     * @param int $id The ID of the classroom to be updated.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response with either a success message and updated data or an error message.
     *
     * @throws \Illuminate\Validation\ValidationException If the request data fails validation.
     * @throws \Throwable If any other error occurs during the update process.
     */

    public function update(ClassroomRequest $request, String $id)
    {
        $classroom = Classroom::findOrFail($id);

        try {
            $classroom->update([
                'name' => $request['name'],
                'description' => $request['description']
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $classroom,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the classroom',
                'details' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified classroom from the database.
     *
     * @param string $id The ID of the classroom to be deleted.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response with either a success message and deleted data or an error message.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the classroom with the specified ID is not found.
     * @throws \Throwable If any other error occurs during the deletion process.
     */
    public function destroy(String $id)
    {
        $classroom = Classroom::findOrFail($id);

        try {
            $classroom->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'The classroom was deleted successfully',
                'data' => $classroom,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the classroom',
                'details' => $th->getMessage()
            ], 500);
        }
    }
}
