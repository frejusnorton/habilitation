<?php

namespace App\Http\Controllers;

use App\Models\Champs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;


class ChampsController extends Controller
{

    public function index(Request $request)
    {

        $champs = Champs::filter($request->search)->paginate(10);
        
        if ($request->ajax()) {
            return view('champs.datatable', [
                'champs' => $champs
            ]);
        }
        return view('champs.index', [
            'champs' => $champs
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|unique:champs',
                'libelle' => 'required',
                'type' => 'required',
                'query' => ['nullable', function ($attribute, $value, $fail) {
                    if (!str_starts_with(strtoupper($value), 'SELECT')) {
                        $fail('Seules les requêtes SELECT sont autorisées.');
                    }
                }]
            ],
            [
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce code existe déjà',
                'libelle.required' => 'Le libelle est obligatoire.',
                'type.required' => 'Le type est obligatoire.',
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
            $champs = new Champs();
            $champs->code = $validatedRequest['code'];
            $champs->type = $validatedRequest['type'];
            $champs->libelle = $validatedRequest['libelle'];
            $champs->query = $validatedRequest['query'] ?? "";

            $results = [];
            if (!empty($validatedRequest['query'])) {
                if (!str_starts_with(strtoupper($validatedRequest['query']), 'SELECT')) {
                    throw new \Exception("La requête doit être une requête SELECT valide.");
                }
                $results = DB::select($validatedRequest['query']);
            }
            $champs->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function update(Request $request, Champs $champ)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|unique:champs,code,' . $champ->id . ',id',
                'libelle' => 'required',
                'type' => 'required',
                'query' => ['nullable', function ($attribute, $value, $fail) {
                    if (!str_starts_with(strtoupper($value), 'SELECT')) {
                        $fail('Seules les requêtes SELECT sont autorisées.');
                    }
                }],
                'connexion' => "string"
            ],
            [
                'code.required' => 'Le code est obligatoire.',
                'code.unique' => '  Ce code existe déjà',
                'type.string' => "Le type est obligatoire",
                'libelle.required' => 'Le libelle est obligatoire.',
                'connexion.string' => "Le nom de la connexion n'est pas valide.",
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
            $champ->code = $validatedRequest['code'];
            $champ->libelle = $validatedRequest['libelle'];
            $champ->type = $validatedRequest['type'];
            $champ->query =  $validatedRequest['query'] ?? "";
            $champ->connexion =  $validatedRequest['connexion'] ?? "";
            $champ->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function delete(Champs $champ)
    {
        DB::beginTransaction();
        try {
            $champ->delete();
            DB::commit();

            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    // public function handleQuery(Request $request)
    // {

    //     $query = $request->input('query');
    //     $champs = $request->input('champs');

    //     try {
    //         $connexion = $request->input('connexion');
    //         $results = DB::connection($connexion)->select($query);
    //         $champsIds = [];

    //         foreach ($champs as $champ) {
    //             $champsIds[] = $champ['id'];
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'data' => view('habilitation.listspart', ['results' => $results, 'champ_id' => $champsIds])->render(),
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => $th->getMessage()
    //         ]);
    //     }
    // }

   
   
    public function handleQuery(Request $request)
    {
      
        $query = $request->input('query');
        try {
            $connexion = $request->input('connexion');
            $results = DB::connection($connexion)->select($query);
         
            return response()->json( $results);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ]);
        }
    }
}
