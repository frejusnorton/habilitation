<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Service\GlobalService;
use App\Service\RoleMenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleMenuController extends Controller
{
    protected $roleMenuService;
    protected $globalService;

    public function __construct(RoleMenuService $roleMenuService, GlobalService $globalService)
    {
        $this->roleMenuService = $roleMenuService;
        $this->globalService = $globalService;
    }

    public function index()
    {
        $rolemenus = RoleMenu::with(['role','menu'])->paginate(10);
        // dd(  $rolemenus);
        return view('role-menu.index', [
            'rolemenus' => $rolemenus,
            'roles' => Role::where('statut', true)->get(),
            'menus' => Menu::where('statut', true)->get(),
        ]);
    }
    public function create(Request $request)
    { 
        $request->validate([
            'role' => 'required',
            'menu' => 'required',
        ]);
        if ($this->roleMenuService->verifyExistsRoleMenu($request->role, $request->menu) == false) {
            return redirect()->route('app_role_menu_index')->with('warning', 'Donnée existante !');
        }
        dd( 'in');
        DB::beginTransaction();
        try {
           
            $menu = new RoleMenu();
            $menu->role_id = $request->role;
            $menu->menu_id = $request->menu;
            dd( $menu);
            $menu->save();
            DB::commit();
            return redirect()->route('app_role_menu_index')->with('success', successMessage());
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('app_role_menu_index')->with('success', errorMessage() . $th->getMessage());
        }
    }

    public function update(Request $request, RoleMenu $roleMenu)
    {
        $request->validate([
            'role' => 'required',
            'menu' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $roleMenu->role_id = $request->role;
            $roleMenu->menu_id = $request->menu;
            $roleMenu->save();

            DB::commit();

            return redirect()->route('role-menu.index')->with('success', successMessage());
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('role-menu.index')->with('error', errorMessage() . $th->getMessage());
        }
    }

    public function delete(RoleMenu $roleMenu)
    {
        DB::beginTransaction();

        try {
            $roleMenu->delete();

            DB::commit();

            return redirect()->route('role-menu.index')->with('success', successMessage());
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('role-menu.index')->with('error', errorMessage());
        }
    }

    public function searchDataInMenu(Request $request)
    {
        return view('role-menu.datatable', [
            'menus' => $this->roleMenuService->searchRoleMenu($request->search),
        ]);
    }

    public function export(Request $request)
    {
        if (is_null($request->searchData)) {

            $datas = RoleMenu::all();
        } else {

            $datas = $this->roleMenuService->searchRoleMenu($request->search);
        }

        if ($request->format == "excel") {

            return $this->globalService->getExcel("role-menu", "role-menu.excel", $datas, "role-menu");
        }

        if ($request->format == "pdf") {

            return $this->globalService->getPdf("role-menu", "role-menu.excel", $datas, "role-menu");

        }
    }
}
