<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class ApplicationRole extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'applications_role';
    protected $connection = 'objapp_test';

  
    public function type()
    {
        return $this->belongsTo(ApplicationType::class, 'application_type_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function roles()
    {
        return $this->hasMany(ApplicationRole::class, 'application_role_id');
    }

    public function demandeApplications()
    {
        return $this->hasMany(DemandeApplication::class, 'profil_id');
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
                           ;
                    }
                }
            });
        }
        return $query;
    }
}
