<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Acl;
use App\Models\Menu;
use App\Service\AclService;
use Illuminate\Http\Request;
use App\Service\GlobalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AclController extends Controller
{
    protected $aclService;
    protected $globalService;
    protected $helper;

    public function __construct(AclService $aclService, GlobalService $globalService, Helper $helper)
    {
        $this->aclService = $aclService;
        $this->globalService = $globalService;
        $this->helper = $helper;
    }

    public function index(Menu $menu)
    {
        return view('menu.permissions-part', [
            'actions' => Acl::orderBy('created_at', 'DESC')->where('menu_id', $menu->id)->get(),
            'menu' => $menu
        ]);
    }

    public function create(Request $request, Menu $menu)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'identifiant' => 'required',
                'libelle' => 'required',
            ]
        );


        if ($validator->fails()) {
            return response()->json(['message' => view('error.error', ['errors' => $validator->errors()])->render(), 'success' => false]);
        }

        DB::beginTransaction();

        try {
            $validatedRequest = $validator->getData();

            $acl = new Acl();
            $acl->identifiant =  $validatedRequest['identifiant'] ?? '';
            $acl->libelle = $validatedRequest['libelle'] ?? '';
            $acl->menu_id = $menu->id ?? '';
            $acl->statut = isset($validatedRequest['statut']) && $validatedRequest['statut'] == 1 ? true : false;
            $acl->save();

            DB::commit();

            return response()->json(['message' => view('menu.permissions-part', [
                'actions' => Acl::orderBy('created_at', 'DESC')->where('menu_id', $menu->id)->get(),
                'menu' => $menu
            ])->render(), 'success' => true]);
        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }


    public function delete(Acl $acl, Menu $menu)
    {
        DB::beginTransaction();

        try {
            $acl->delete();

            DB::commit();

            return response()->json(['message' => view('menu.permissions-part', [
                'actions' => Acl::orderBy('created_at', 'DESC')->where('menu_id', $menu->id)->get(),
                'menu' => $menu
            ])->render(), 'success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message' => errorMessage() . $th->getMessage(), 'success' => false]);
        }
    }
}
