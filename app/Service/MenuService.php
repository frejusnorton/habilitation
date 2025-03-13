<?php

namespace App\Service;

use App\Models\Menu;


class MenuService
{
    public function verifyCheckBox($value)
    {
        if ($value == true) {
            $data = true;
        } else {
            $data = false;
        }

        return $data;
    }

    public function verifyParentExist($value)
    {
        $parent = Menu::where('id', $value)->first();

        if ($parent instanceof Menu) {
            $data = true;
        } else {
            $data = false;
        }

        return $data;
    }

    public function searchMenu($value)
    {
        if (is_null($value)) {
            return [];
        }

        $getMenu = Menu::orWhere('titre', 'like', '%' . $value . '%')
            ->orWhere('titreSecondaire', 'like', '%' . $value . '%')
            ->orWhere('routeName', 'like', '%' . $value . '%')
            ->get();

        return $getMenu;
    }
}
