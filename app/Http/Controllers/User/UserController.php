<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Exports\UsersExport;
use App\Services\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Summary of show user lists
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'data' => $users,
            'result' => 1,
            'message' => "Register success!"
        ]);
    }

    /**
     * export excel file
     */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     * import excel file
     */
    public function import(Request $request)
    {
        $file = $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return response()->json($failures);
        }
    }
}
