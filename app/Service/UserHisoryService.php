<?php

namespace App\Service;

use App\Models\LogActivity;
use App\Models\SoldeLogManual;
use App\Models\UserHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserHisoryService
{
    public static function log($user, $action, $comment)
    {
        if (empty($comment)) $comment = 'RAS';
        UserHistory::create([
            'action' => $action,
            'userAct' => Auth::user()->id,
            'user' => $user,
            'comment' => $comment,
        ]);
    }

    public static function logActivity($action)
    {
        LogActivity::create([

            'user' => Auth::user()->id,
            'action' => $action
        ]);
    }
}
