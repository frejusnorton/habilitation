<?php

namespace App\Http\Controllers;
use App\Models\Agence;
use Illuminate\Http\Request;


class AgenceController extends Controller
{
    public function index(Request $request)
    {   
        $agences = Agence::filter($request->search)->paginate(10);
        if ($request->ajax()) {
            return view('agence.datatable', [
                'agences' => $agences
            ]);
        }
        return view('agence.index', [
            'agences' => $agences
        ]);
    }
}
