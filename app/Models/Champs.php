<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Champs extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'champs';
    protected $connection = 'objapp_test';
    
    public static function filter($search = '', $statut = null)
    {
        $query = self::orderBy('created_at', 'desc');
        if ($search && !empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if (trim($item)) {
                        $query->where(DB::RAW('upper(libelle)'), 'LIKE', '%' . strtoupper(trim($item)) . '%')
                            ->orwhere(DB::RAW('upper(code)'), 'LIKE', '%' . strtoupper(trim($item)) . '%') ;
                    }
                }
            });
        }
        return $query;
    }
     

   
}
