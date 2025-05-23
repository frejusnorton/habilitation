<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'menus';
    protected $connection = 'objapp_test';

    public static function filter($search = '', $statut = null)
    {
        $query = self::where('statut', true)->orderBy('created_at', 'desc');
        if ($search && !empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if (trim($item)) {
                        $query->where(DB::RAW('upper(TITRE)'), 'LIKE', '%' . strtoupper(trim($item)) . '%')
                            ->orwhere(DB::RAW('upper(routename)'), 'LIKE', '%' . strtoupper(trim($item)) . '%')
                            ->orwhere(DB::RAW('upper(titresecondaire)'), 'LIKE', '%' . strtoupper(trim($item)) . '%')
                        ;
                    }
                }
            });
        }

        return $query;
    }
}
