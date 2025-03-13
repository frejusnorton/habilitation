<?php

namespace App\Service;
use App\Models\Acl;
use App\Models\Menu;
use App\Models\RoleMenu;

class RoleService {

    public function verifyAclExist ($id)
    {
        $action = Acl::where('id', $id)->first();

        if ($action instanceof Acl) {
            $data = true;
        }else {
            $data = false;
        }

        return $data;
    }
    public function verifyMenuExist ($id)
    {
        $menu = Menu::where('id', $id)->first();

        if ($menu instanceof Menu) {
            $data = true;
        }else {
            $data = false;
        }

        return $data;
    }

    public function verifyRoleAndMenuExist ($role, $menu)
    {
        $verifyRoleAndMenuExist = RoleMenu::where('menu_id', $menu)->where('role_id', $role)->first();

        if ($verifyRoleAndMenuExist instanceof RoleMenu) {
            $data = true;
        }else {
            $data = false;
        }

        return $data;
    }

    public function getAcl ($id)
    {
        $getAcl = Acl::where('id', $id)->first();

        return $getAcl;
    }
}
