<?php

use App\Models\Menu;
use App\Models\Role;
use App\Models\RolePageAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;


function buildMenu()
{
    $list = getMenus();
    $haveActive = '';

    $menus = <<<EOT

        EOT;

    foreach ($list as $value) {
        if ($value->hassubmenu == true) {

            $childs = getChilds($value->id);

            if (sizeOf($childs) > 0) {

                $subMenus = <<<EOT
                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                EOT;

                foreach ($childs as  $item) {

                    $url = $item->routename != null ?  getUrlFromName($item->routename) : '#';

                    $active = ckeckActive($item->routename);
                    if ($active == 'active') {
                        $haveActive = 'show';
                    }
                    $subMenus .= <<<EOT
                        <div class="menu-item">
                            <a class="menu-link active py-3" href="{$url}">
                                <span class="menu-icon">
                                    {$item->icone}
                                </span>
                                <span class="menu-title">{$item->titre}</span>
                            </a>
                        </div>
                    EOT;
                }

                $subMenus .= <<<EOT
                </div>
                <!--end:Menu sub-->
                EOT;
                // dd($subMenus);
            } else {
                $subMenus = '';
            }

            $menus .= <<<EOT

                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg  menu-state-icon-primary menu-state-bullet-primary  fw-bold my-5 my-lg-0 align-items-stretch mx-2"
                        id="#kt_header_menu" data-kt-menu="true">
                        <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                            class="menu-item here show menu-lg-down-accordion me-lg-1">
                            <a class="menu-link active py-3 text-white" href="{$url}">
                                <span class="menu-title"><span class='mx-2 text-white'>{$value->icone}</span> {$value->titre}</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </a>

                                {$subMenus}
                        </div>
                    </div>

                        <!--end:Menu item-->
            EOT;
        }

        if ($value->hassubmenu == false && $value->issubmenu == false && $value->parent == null) {

            $url = $value->routename != null ?  getUrlFromName($value->routename) : '#';
            $active = ckeckActive($value->routename);
            $menus .= <<<EOT
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {$active} text-white" href="{$url}">
                    <span class="menu-link">
                    <span class="menu-icon">{$value->icone}</span>
                        <span class="menu-title">{$value->titre}</span>
                        <span class=""></span>
                    </span>
                </a>
                <!--end:Menu link-->
            </div>
            EOT;
        }
    }


    $menus .= <<<EOT

    EOT;

    return $menus;
}


function getMenus()
{
    $menuList = [];
    if (Auth::user()) {
        $role = Role::find(Auth::user()->role);
        if ($role) {
            //Recuperation des menus lies au role
            $menus = $role->menus;

            if ($menus instanceof Collection) {
                $menus = $menus->pluck('menu_id')->toArray();
            }

            $menuList = Menu::whereIn('id', $menus)->orderBy('position')->get();
        }
    }
    return $menuList;
}

function getActions()
{
    $actionList = [];
    if (Auth::user()) {
        $role = Role::find(Auth::user()->role);
        if ($role) {

            //Recuperation des menus lies au role
            $actions = $role->actions;
            if ($actions instanceof Collection) {
                $actions = $actions->pluck('acl')->toArray();
            }

            $actionList = RolePageAction::whereIn('id', $actions)->get();
        }
    }
    return $actionList;
}

function getChilds($parentId)
{
    return  Menu::where('parent', $parentId)->orderBy('position')->get();
}

function getUrlFromName($name)
{
    return urldecode(route($name));
}

function  ckeckActive($name)
{
    if (Route::currentRouteName() == $name) {
        return 'active';
    }
    return '';
}


function getMenusUser()
{
    if (Auth::user()) {
        $role = Role::find(Auth::user()->role);
        if ($role) {
            //Recuperation des menus lies au role
            $menus = $role->menus;

            if ($menus instanceof Collection) {
                $menus = $menus->pluck('menu_id')->toArray();
            }
        }
    }
    return $menus;
}

function getActionsUser()
{
    if (Auth::user()) {
        $role = Role::find(Auth::user()->role);
        if ($role) {

            //Recuperation des menus lies au role
            $actions = $role->actions;
            if ($actions instanceof Collection) {
                $actions = $actions->pluck('acl')->toArray();
            }
        }
    }
    return $actions;
}


function buildUserAction($useraction)
{
    $out_arr = [];
    foreach ($useraction as $item) {

        if ($item->pageAction)
            $out_arr[] = trim($item->pageAction->identifiant);
    }
    return $out_arr;
}

function checkPermission($action)
{
    $userCanFlag = false;
    if (is_array($action)) {
        foreach ($action as $item) {
            $item = strtoupper($item);
            if (!in_array($item, session('userAction'))) {
                $userCanFlag = false;
                break;
            }
        }
        $userCanFlag = true;
    } else {
        $action = strtoupper($action);
        $userCanFlag = in_array($action, session('userAction'));
    }
    return $userCanFlag;
}
