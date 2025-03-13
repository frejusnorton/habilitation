<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'applications';
    protected $connection = 'objapp_test';



    public function roles()
    {
        return $this->hasMany(ApplicationRole::class, 'application_id');
    }
    public function champs()
    {
        return $this->hasMany(ApplicationField::class, 'application_id');
    }
    

    public static function filter($search = '', $statut = null)
    {
        $query = self::orderBy('libelle', 'asc');
        if ($search && !empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if (trim($item)) {
                        $query->where(DB::RAW('upper(libelle)'), 'LIKE', '%' . strtoupper(trim($item)) . '%');
                    }
                }
            });
        }
        return $query;
    }
}
