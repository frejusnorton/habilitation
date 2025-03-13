<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Agence extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'BKAGE';
    protected $connection = 'dbedi';
    public static function filter($search = '', $statut = null)
    {
        $query = self::orderBy('age', 'desc');

        if ($search && !empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if (trim($item)) {
                        $query->where(DB::RAW('upper(lib)'), 'LIKE', '%' . strtoupper(trim($item)) . '%')
                            ->orwhere(DB::RAW('upper(age)'), 'LIKE', '%' . strtoupper(trim($item)) . '%') ;
                    }
                }
            });
        }
        return $query;
    }

    public function demandeFields()
    {
        return $this->hasMany(DemandeField::class, 'value', 'rn');
    }

    
}
