<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleMenu extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];


    protected $casts = [
        'id' => 'string'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public static function filter($search = '', $statut = null)
    {
        $query = self::orderBy('created_at', 'desc');
        if ($search && !empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if (trim($item)) {
                        $query->where(DB::RAW('upper(role_name)'), 'LIKE', '%' . strtoupper(trim($item)) . '%');
                    }
                }
            });
        }
        return $query;
    }
}
