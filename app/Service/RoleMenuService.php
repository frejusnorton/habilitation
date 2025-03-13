<?php

namespace App\Service;

use App\Models\RoleMenu;

class RoleMenuService {

    public function verifyCheckBox($value)
    {
        if ($value == true) {
            $data = true;
        } else {
            $data = false;
        }

        return $data;
    }

    public function searchRoleMenu($value)
    {
        if (is_null($value)) {
            return RoleMenu::all();
        }

        $getMenu = RoleMenu::orWhere('libelle', 'like', '%' . $value . '%')
            ->orWhere('identifiant', 'like', '%' . $value . '%')
            ->get();

        return $getMenu;
    }

    function verifyExistsRoleMenu($role, $menu)
    {
        $roleMenu = RoleMenu::where('role_id', $role)->where('menu_id', $menu)->first();

        if (!$roleMenu instanceof RoleMenu) {
            return false;
        }
        return true;
    }
}
