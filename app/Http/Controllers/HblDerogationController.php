<?php

namespace App\Http\Controllers;
use App\Models\Agence;
use App\Models\Service;
use App\Models\Direction;
use App\Models\Derogation;
use App\Models\Application;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HblDerogationController extends Controller
{
    public function index(Request $request)
    {   
        $user = Auth::user();
        $agences = Agence::all();
        $services = Service::all();
        $direction = Direction::all();
        $departement = Departement::all();
        $application = Application::with(['roles','type'])->get();
      
        return view('derogation.index',[
            'user'=>   $user,
            'agences' => $agences,
            'services' => $services,
            'directions' => $direction,
            'departements' => $departement,
            'applications' =>  $application
        ]);
    }

    public function step1(Request $request)
    {   
        $validator = Validator::make(
            $request->all(),
            [
                'nom' => 'required|',
                'prenom' => 'required',
                'email' => 'required|email',
                'poste' => "required"
            ],
            [
                'nom.required' => 'Le nom est obligatoire.',
                'prenom.required' => 'Le prenom est obligatoire.',
                'email.required' => "L'email est obligatoire.",
                'poste.required' => "Le poste est obligatoire"
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        DB::beginTransaction();
        try {
            $validatedRequest = $validator->getData();
            $applicationRole = new Derogation();
            $applicationRole->libelle = $validatedRequest['libelle'];
            $applicationRole->code = $validatedRequest['code'];
            $applicationRole->statut =  $request->input('statut') ?? 0;
            $applicationRole->applications_id = $request->input('application_id');
            $applicationRole->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }
}
