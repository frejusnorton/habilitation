<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Exports\AllExport;
use App\Service\GlobalService;
use App\Service\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MenuController extends Controller
{
    protected $menuService;
    protected $globalService;

    public function __construct(MenuService $menuService, GlobalService $globalService)
    {
        $this->menuService = $menuService;
        $this->globalService = $globalService;
    }

    public function index(Request $request)
    {
        //  $menu = Menu::all();
        //  dd(  $menu );
        $menus = Menu::filter($request->search)->paginate(10);

        if ($request->ajax()) {
            return view('menu.datatable', [
                'menus' => $menus
            ]); 
        }
        return view('menu.index', [
            'menus' => $menus
        ]);
    }


    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'titre' => 'required',
                'titreSecondaire' => 'required',
                'icone' => 'required',
                'position' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => view('error.error', ['errors' => $validator->errors()])->render(), 'success' => false]);
        }


        DB::beginTransaction();
        try {
            $validatedRequest = $validator->getData();

            if (isset($validatedRequest['parent']) && $this->menuService->verifyParentExist($validatedRequest['parent']) == false) {
                return response()->json(['message' => view('error.error', ['errors' => "Parent inexistant"])->render(), 'statut' => 'error']);
            }
            $menu = new Menu();
            $menu->titre = $validatedRequest['titre'];
            $menu->titreSecondaire = $validatedRequest['titreSecondaire'];
            $menu->routename = $validatedRequest['routeName'];
            $menu->icone =  $validatedRequest['icone'];
            $menu->issubmenu = $this->menuService->verifyCheckBox($validatedRequest['isSubMenu'] ?? null);
            $menu->parent = $validatedRequest['parent'] ?? null;
            $menu->hassubmenu = $this->menuService->verifyCheckBox($validatedRequest['hasSubMenu'] ?? null);
            $menu->statut = $this->menuService->verifyCheckBox($validatedRequest['statut'] ?? null);
            $menu->position =  $validatedRequest['position'];


            $menu->save();

            DB::commit();

            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function update(Request $request, Menu $menu)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'titre' => 'required',
                'titreSecondaire' => 'required',
                // 'routeName' => 'required',
                'icone' => 'required',
                // 'issubmenu' => 'required',
                // 'parent' => 'required',
                'position' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['message' => view('error.error', ['errors' => $validator->errors()])->render(), 'success' => false]);
        }


        DB::beginTransaction();
        try {
            $validatedRequest = $validator->getData();
            if (isset($validatedRequest['parent']) && $this->menuService->verifyParentExist($validatedRequest['parent']) == false) {
                return response()->json(['message' => view('error.error', ['errors' => "Parent inexistant"])->render(), 'statut' => 'error']);
            }
            $menu->titre = $validatedRequest['titre'];
            $menu->titreSecondaire = $validatedRequest['titreSecondaire'];
            $menu->routename = $validatedRequest['routeName'];
            $menu->icone =  $validatedRequest['icone'];
            $menu->issubmenu = $this->menuService->verifyCheckBox($validatedRequest['isSubMenu'] ?? null);
            $menu->parent = $validatedRequest['parent'] ?? null;
            $menu->hassubmenu = $this->menuService->verifyCheckBox($validatedRequest['hasSubMenu'] ?? null);
            $menu->statut = $this->menuService->verifyCheckBox($validatedRequest['statut']);
            $menu->position =  $validatedRequest['position'];

            $menu->save();
            DB::commit();

            return response()->json(['message' => successMessage(), 'success' => true]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function delete(Menu $menu)
    {
        DB::beginTransaction();

        try {
            $menu->delete();

            DB::commit();

            return response()->json(['message' => 'Suppression effectuée avec succès', 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }

    public function export(Request $request)
    {
        $menus = Menu::filter($request->search)->get();

        if ($request->ajax()) {
            return view('menu.datatable', [
                'menus' => $menus
            ]);
        }

        $fileName = 'UTILS_MENU_' . Carbon::now()->format('d_m_Y_H_i_s');

        return Excel::download(new allExport('menu.excel', ['menus' => $menus]), $fileName . '.xlsx');
    }
}
