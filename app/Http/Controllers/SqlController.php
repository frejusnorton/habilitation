<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class SqlController extends Controller
{
    public function index(Request $request)

    {
        $sql = File::get(base_path('script.sql'));
        $results =   DB::connection('dbedi')->select($sql);
        return response()->json($results);
    }
}
