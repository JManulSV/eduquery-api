<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;

class GoogleSheetController extends Controller
{
    public function indexFromSheet(Request $request)
    {
        try {
            $request->validate([
                'id_sheet' => 'required',
                'page_name' => 'required'
            ]);

            $idsheet = $request['id_sheet'];
            $pagename = $request['page_name'];


            $sheet = Sheets::spreadsheet($idsheet)->sheet($pagename)->get();
            $header = $sheet->pull(0);
            $values = Sheets::collection(header: $header, rows: $sheet);
            $values->toArray();

            return response()->json(['data' => $values]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public static function getStudentsFromSheet(String $id_sheet, String $page_name)
    {
        try {
            $sheet = Sheets::spreadsheet($id_sheet)->sheet($page_name)->get();
            $header = $sheet->pull(0);
            $values = Sheets::collection(header: $header, rows: $sheet);
            $values->toArray();

            return $values;
        } catch (\Throwable $th) {
            return ['error' => $th->getMessage()];
        }
    }
}
