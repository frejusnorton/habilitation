<?php

namespace App\Http\Controllers;


use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DirectionController extends Controller
{
    public function index(Request $request)
    {
        $directions = Direction::filter($request->search)->paginate(10);
        if ($request->ajax()) {
            return view('direction.datatable', [
                'directions' => $directions
            ]);
        }
        return view('direction.index', [
            'directions' => $directions
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|unique:directions',
                'libelle' => 'required',
            ],[
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce code direction existe déjà',
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
            $service = new Direction();
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

    public function update(Request $request, Direction $direction)
    {
        $validator = Validator::make(
            $request->all(),
            [
              'code' => 'required|unique:directions,code,' . $direction->id . ',id',
                'libelle' => 'required',
            ],[
                'code.required' => 'Le champ code est obligatoire.',
                'code.unique' => '  Ce code direction existe déjà',
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
            $direction->code = $validatedRequest['code'];
            $direction->libelle = $validatedRequest['libelle'];
            $direction->statut = $request->input('statut') ?? 0;
            $direction->save();
            DB::commit();
            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }
    public function delete(Direction $direction)
    {
        DB::beginTransaction();
        try {
            $direction->delete();
            DB::commit();
            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

}
