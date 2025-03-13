<?php

namespace App\Http\Controllers;


use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    public function index(Request $request)
    {
        $departements = Departement::filter($request->search)->paginate(10);
        if ($request->ajax()) {
            return view('departement.datatable', [
                'departements' => $departements
            ]);
        }
        return view('departement.index', [
            'departements' => $departements
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|unique:departements',
                'libelle' => 'required',
            ],[
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce code departement existe déjà',
                'libelle.required' => 'Le champ libelle est obligatoire.'
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
            $service = new Departement();
            $service->code = $validatedRequest['code'];
            $service->libelle = $validatedRequest['libelle'];
            $service->statut = $request->input('statut');
            $service->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);

        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function update(Request $request, Departement $departement)
    {
        $validator = Validator::make(
            $request->all(),
            [
              'code' => 'required|unique:departements,code,' . $departement->id . ',id',
                'libelle' => 'required',
            ],[
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce code departement existe déjà',
                'libelle.required' => 'Le champ libelle est obligatoire.'
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

            $departement->code = $validatedRequest['code'];
            $departement->libelle = $validatedRequest['libelle'];
            $departement->statut = $request->input('statut') ?? 0;
            $departement->save();

            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }
    public function delete(Departement $departement)
    {
        DB::beginTransaction();
        try {
            $departement->delete();
            DB::commit();
            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

}
