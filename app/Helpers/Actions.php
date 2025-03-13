<?php

use App\Models\Role;
use App\Models\RolePageAction;
use Illuminate\Database\Eloquent\Collection;

function permissions($id)
{
    $actionList = [];
    $role = Role::find($id);

    if ($role) {

        //Recuperation des actions lies au role
        $roleMenu = $role->menus;
        $actions = $role->actions;

        if ($actions instanceof Collection) {
            $actions = $actions->pluck('acl')->toArray();
        }

        $actionList = RolePageAction::whereIn('id', $actions)->get();
    }
    return $actionList;
}

function successMessage()
{
    return "Enregistrement effectué";
}

function errorMessage()
{
    return "Enregistrement non effectué";
}

function warningMessage()
{
    return "Attention, Enregistrement non effectué";
}

// function permissions($id)
// {
//     $actionList = [];
//     $role = Role::find($id);

//     if ($role) {

//         //Recuperation des actions lies au role
//         $roleMenu = $role->menus;
//         $actions = $role->actions;

//         if ($actions instanceof Collection) {
//             $actions = $actions->pluck('acl')->toArray();
//         }

//         $actionList = RolePageAction::whereIn('id', $actions)->get();
//     }
//     return $actionList;
// }
