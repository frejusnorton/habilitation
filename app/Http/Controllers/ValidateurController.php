<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChampsDetail;
use App\Models\DemandeField;
use Illuminate\Http\Request;
use App\Models\FluxHistorique;
use App\Models\DemandeApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ValidateurController extends Controller
{
    public function index(Request $request)
    {
        $validateurs = FluxHistorique::filter($request->search)->paginate(10);
        if ($request->ajax()) {
            return view('validateur.datatable', [
                'validateurs' => $validateurs
            ]);
        }
        return view('validateur.index', [
            'validateurs' => $validateurs
        ]);
    }
    
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'validateur' => 'required',
                'rang' => 'required',
            ],
            [
                'validateur.required' => 'Le validateur est obligatoire.',
                'rang.required' => ' Le rang est obligatoire',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        $user = auth()->user();
        try {
            $validateur_id = $request->validateur;
            $rang = $request->rang;

            if ($rang == 1) {
                $user->validateur_1 = $validateur_id;
            } elseif ($rang == 2) {
                $user->validateur_2 = $validateur_id;
            } elseif ($rang == 3) {
                $user->validateur_3 = $validateur_id;
            }

            DB::table('users')->where('id', $user->id)->update([
                'validateur_1' => $user->validateur_1,
                'validateur_2' => $user->validateur_2,
                'validateur_3' => $user->validateur_3,
            ]);

            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    // public function update(Request $request, Aprobateur $aprobateur)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'code' => 'required|unique:departements,code,' . $aprobateur->id . ',id',
    //             'libelle' => 'required',
    //         ],
    //         [
    //             'code.required' => 'Le champ code est obligatoire.',
    //             'code.unique' => '  Ce code departement existe déjà',
    //             'libelle.required' => 'Le champ libelle est obligatoire.'
    //         ]
    //     );
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $validatedRequest = $validator->getData();

    //         $aprobateur->code = $validatedRequest['code'];
    //         $aprobateur->libelle = $validatedRequest['libelle'];
    //         $aprobateur->statut = $request->input('statut') ?? 0;
    //         $aprobateur->save();

    //         DB::commit();
    //         return response()->json(['message' => successMessage(), 'success' => true]);
    //     } catch (\Throwable $th) {
    //         Log::info($th);
    //         DB::rollBack();
    //         return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
    //     }
    // }


    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }
}
