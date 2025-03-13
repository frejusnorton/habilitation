<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\RolePageAction;
use App\Service\RoleService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return view('role.index', [
            'roles' => Role::paginate(10),
            'menus' => Menu::all(),
        ]);
    }


    public function create(Request $request)
    {
       
        if ($request->post()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'role_name' => 'required|unique:roles,role_name',
                    'menus' => 'array'
                ]
            );
            if ($validator->fails()) {
                return response()->json(['message' => view('error.error', ['errors' => $validator->errors()])->render(), 'success' => false]);
            }
            DB::beginTransaction();
            try {
                $validatedRequest = $validator->getData();
                $role = new Role();
                $role->role_name = $validatedRequest['role_name'];
                $role->description = $validatedRequest['role_description'];
                // $role->statut =$request->input('statut');

                $role->save();
               
                if (isset($validatedRequest['menu'])) {
                    foreach ($validatedRequest['menu'] as  $menu) {
                        if ($this->roleService->verifyMenuExist($menu) == true) {
                            $saveRoleMenu = new RoleMenu();
                            $saveRoleMenu->role_id = $role->id;
                            $saveRoleMenu->menu_id = $menu;
                            $saveRoleMenu->save();
                        }
                    }
                }

                if (isset($validatedRequest['actions'])) {
                    foreach ($validatedRequest['actions'] as  $action) {
                        if ($this->roleService->verifyAclExist($action) == true) {
                            $saveRolePageAction = new RolePageAction();
                            $saveRolePageAction->role_id = $role->id;
                            $saveRolePageAction->acl = $action;
                            $saveRolePageAction->save();
                        }
                    }
                }
                // dd($role);
                DB::commit();
                return response()->json(['message' => successMessage(), 'success' => true, 'route' => route('app_role_index')]);
            } catch (\Throwable $th) {

                DB::rollBack();
                return response()->json(['message' => $th->getMessage(), 'success' => false, 'route' => route('app_role_index')]);
            }
        }

        return view('role.add', [
            'menus' => Menu::where('statut', 1)->get(),
        ]);
    }

    public function update(Request $request, Role $role)
    {  
        if ($request->post()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'role_name' => 'required|unique:roles,role_name,' . $role->id,
                    'menus' => 'array'
                ]
            );
            if ($validator->fails()) {
                return response()->json(['message' => view('error.error', ['errors' => $validator->errors()])->render(), 'success' => false]);
            }
            DB::beginTransaction();
            try {
                $validatedRequest = $validator->getData();
                $role->role_name = $validatedRequest['role_name'];
                $role->description = $validatedRequest['role_description'];
                $role->save();

                if (isset($validatedRequest['menu'])) {
                    RoleMenu::where("role_id", $role->id)->delete();
                    foreach ($validatedRequest['menu'] as  $menu) {
                        if ($this->roleService->verifyMenuExist($menu) == true) {
                            $saveRoleMenu = new RoleMenu();
                            $saveRoleMenu->role_id = $role->id;
                            $saveRoleMenu->menu_id = $menu;
                            $saveRoleMenu->save();
                        }
                    }
                }

                if (isset($validatedRequest['actions'])) {
                    RolePageAction::where("role_id", $role->id)->delete();
                    foreach ($validatedRequest['actions'] as  $action) {
                        if ($this->roleService->verifyAclExist($action) == true) {
                            $saveRolePageAction = new RolePageAction();
                            $saveRolePageAction->role_id = $role->id;
                            $saveRolePageAction->acl = $action;
                            $saveRolePageAction->save();
                        }
                    }
                }
                DB::commit();
                return response()->json(['message' => successMessage(), 'success' => true, 'route' => route('app_role_index')]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['message' => $th->getMessage(), 'success' => false, 'route' => route('app_role_index')]);
            }
        }

        return view('role.add', [
            'menus' => Menu::where('statut', 1)->get(),
            'role' => $role
        ]);
    }
    public function activate(Role $role)
    {
        $role->statut = !$role->statut;
        $role->save();
        return response()->json(['message' => successMessage(), 'success' => true, 'route' => route('app_role_index')]);
    }

    public function delete(Role $role)
    {
        try {
            $role->delete();
            return response()->json(['message' => successMessage(), 'success' => true, 'route' => route('app_role_index')]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'success' => false, 'route' => route('app_role_index')]);
        }
    }
}
