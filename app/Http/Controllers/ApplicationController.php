<?php

namespace App\Http\Controllers;

use App\Models\Champs;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\ApplicationField;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::filter($request->search)->paginate(10);
        $champs = Champs::all();

        if ($request->ajax()) {
            return view('application.datatable', [
                'applications' => $applications,
            ]);
        }

        return view('application.index', [
            'applications' => $applications,
            'champs' => $champs
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'libelle' => 'required|unique:applications',
            ],
            [
                'libelle.required' => 'Le libelle est obligatoire.',
                'libelle.unique' => "L'application existe déjà"
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
            $application = new Application();
            $application->libelle = $validatedRequest['libelle'];

            $application->statut = $request->input('statut') ?? 0;
            $application->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function update(Request $request, Application $application)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'libelle' => 'required|unique:applications,libelle,' . $application->id . ',id',
                'application_type' => 'required',
                'application_role' => 'required',
            ],
            [
                'libelle.required' => 'Le champ libelle est obligatoire.',
                'libelle.unique' => '  Cette application existe déjà',
                'application_type.required' => 'Le type est obligatoire.',
                'application_role.required' => 'Le role est obligatoire.'
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
            $application->libelle = $validatedRequest['libelle'];
            $application->application_type_id = $validatedRequest['application_type'];
            $application->application_role_id = $validatedRequest['application_role'];

            $application->save();
            DB::commit();

            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }
    public function delete(Application $application)
    {
        DB::beginTransaction();
        try {
            $application->delete();
            DB::commit();
            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function activate(Application $application)
    {
        $application->statut = !$application->statut;
        $application->save();
        return response()->json(['message' => successMessage(), 'success' => true, 'route' => route('app_role_index')]);
    }

    public function champs(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'champs_id' => 'required|unique:application_fields',
            ],
            [
                'champs_id.required' => 'Le champ est obligatoire.',
                'champs_id.unique' => 'Ce champ existe déjà.',
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
            $applicationField = new ApplicationField();
            $applicationField->application_id = $request->input('application_id');
            $applicationField->champs_id = $request->input('champs_id');
            $applicationField->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function showRoles(Application $application)
    {
        $application->load('roles');
        return view('application.datarole', [
            'applications' =>  $application
        ]);
    }

    public function loadField(Request $request)
    {
        $selectedApplicationIds = $request->input('applications');
        $applications = Application::whereIn('id', $selectedApplicationIds)->get();
        return view('habilitation.formPart', [
            'applications' => $applications
        ]);
    }

    public function loadProfils(Application $application, Request $request)
    {
        $profils = $application->roles;
        return view('application.profilsPart', [
            'profils' => $profils
        ]);
    }
    public function loadChamps(Application $application, Request $request)
    {

        $value = ApplicationField::with('champ')->where('application_id', $application->id)->get();
        $champs = [];
        foreach ($value as $champ) {
            $champs[] = $champ->champ;
        }

        return view('application.champsPart', [
            'champs' => $champs
        ]);
    }

}
