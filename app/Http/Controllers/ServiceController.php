<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::filter($request->search)->paginate(10);
        // dd(     $services );
        
        if ($request->ajax()) {
            return view('service.datatable', [
                'services' => $services
            ]);
        }
        return view('service.index', [
            'services' => $services
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|unique:services',
                'libelle' => 'required',
            ],[
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce code service existe déjà',
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
            $service = new Service();
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

    public function update(Request $request, Service $service)
    { 
        $validator = Validator::make(
            $request->all(),
            [
              'code' => 'required|unique:services,code,' . $service->id . ',id',
                'libelle' => 'required',
            ],[
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce code service existe déjà',
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
            
            $service->code = $validatedRequest['code'];
            $service->libelle = $validatedRequest['libelle'];
            $service->statut = $request->input('statut') ?? 0;
            $service->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    
    public function delete(Service $service)
    {
        DB::beginTransaction();
        try {
            $service->delete();
            DB::commit();
            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

}
