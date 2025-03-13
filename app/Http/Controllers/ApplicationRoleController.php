<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationRoleController extends Controller
{
    public function index(Request $request)
    {
        $apkRoles = ApplicationRole::filter($request->search)->paginate(4);
        if ($request->ajax()) {
            return view('application_role.datatable', [
                'apkRoles' => $apkRoles
            ]);
        }
        return view('application_role.index', [
            'apkRoles' => $apkRoles
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'libelle' => 'required',
            ],
            [
                'libelle.required' => 'Le libelle est obligatoire.',
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
            $applicationRole = new ApplicationRole();
            $applicationRole->libelle = $validatedRequest['libelle'];
            $applicationRole->statut = 1;
            $applicationRole->application_id = $request->input('application_id');
            $applicationRole->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function update(Request $request, ApplicationRole $application_role)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'libelle' => 'required|unique:applications_role,libelle,' . $application_role->id . ',id',
            ],
            [
                'libelle.unique' => '  Ce rôle existe déjà',
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
            $application_role->libelle = $validatedRequest['libelle'];
            $application_role->statut = 1;
            $application_role->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function activate(ApplicationRole $applicationRole)
    {
        $applicationRole->statut = !$applicationRole->statut;
        $applicationRole->save();
        return response()->json(['message' => successMessage(), 'success' => true, 'route' => route('app_role_index')]);
    }

    public function delete(ApplicationRole $applicationRole)
    {
        DB::beginTransaction();
        try {
            $applicationRole->delete();
            DB::commit();

            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }
}
