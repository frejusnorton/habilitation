<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class ApplicationType extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'applications_type';
    protected $connection = 'objapp_test';

    public function applications()
    {
        return $this->hasMany(Application::class, 'application_type_id');
    }

    public static function filter($search = '', $statut = null)
    {
        $query = self::orderBy('created_at', 'asc');
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
