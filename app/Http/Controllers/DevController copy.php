<?php

namespace App\Http\Controllers;

use App\Helpers\Helper_021224;
use App\Http\Controllers\DEC\DatariskController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DevController extends Controller
{
    public function dev()
    {
        ini_set("memory_limit", -1);
        set_time_limit(-1);

        DatariskController::restructures();
    }

    static function setParam($search, $val, $content)
    {
        return  str_replace($search, "'$val'", $content);
    }
}
