<?php

namespace App\Service;

use App\Models\Acl;

class AclService {
    public function verifyCheckBox($value)
    {
        if ($value == true) {
            $data = true;
        } else {
            $data = false;
        }

        return $data;
    }

    public function searchAcl($value)
    {
        if (is_null($value)) {
            return Acl::all();
        }

        $getMenu = Acl::orWhere('libelle', 'like', '%' . $value . '%')
            ->orWhere('identifiant', 'like', '%' . $value . '%')
            ->get();

        return $getMenu;
    }
}
