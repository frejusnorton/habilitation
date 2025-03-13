<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menus()
    {
        return $this->hasMany(RoleMenu::class, 'role_id');
    }

    public function actions()
    {
        return $this->hasMany(RolePageAction::class, 'role_id');
    }

    public function selectedMenu()
    {
        return $this->menus->pluck('menu_id')->toArray();
    }

    public function selectedAction()
    {
        return $this->actions->pluck('acl')->toArray();
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
