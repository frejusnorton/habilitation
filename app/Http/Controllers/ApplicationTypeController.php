<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApplicationTypeController extends Controller
{
    public function index(Request $request)
    {
        $apkTypes = ApplicationType::filter($request->search)->paginate(4);
        if ($request->ajax()) {
            return view('application_type.datatable', [
                'apkTypes' => $apkTypes
            ]);
        }
        return view('application_type.index', [
            'apkTypes' => $apkTypes
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|unique:applications_type',
                'libelle' => 'required',
            ],
            [
                'code.required' => 'Le code est obligatoire.',
                'libelle.required' => 'Le libelle est obligatoire.',
                'code.unique' => "Le code type existe déjà"
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
            $applicationType = new ApplicationType();
            $applicationType->libelle = $validatedRequest['libelle'];
            $applicationType->code = $validatedRequest['code'];
            $applicationType->statut =  $request->input('statut') ?? 0;
            $applicationType->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function update(Request $request, ApplicationType $applicationType)
    { 
        $validator = Validator::make(
            $request->all(),
            [
              'code' => 'required|unique:applications_type,code,' . $applicationType->id . ',id',
                'libelle' => 'required',
            ],[
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce type existe déjà',
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
            $applicationType->code = $validatedRequest['code'];
            $applicationType->libelle = $validatedRequest['libelle'];
            $applicationType->statut = $request->input('statut') ?? 0;
            $applicationType->save();

            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }


    public function delete(ApplicationType $applicationType)
    {
        DB::beginTransaction();

        try {
            $applicationType->delete();
            DB::commit();

            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function activate(ApplicationType $applicationType)
    {
       
        $applicationType->statut = !$applicationType->statut;
        $applicationType->save();
        return response()->json(['message' => successMessage(), 'success' => true, 'route' => route('app_role_index')]);
    }


}
