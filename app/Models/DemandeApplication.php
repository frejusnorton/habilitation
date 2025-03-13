<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeApplication extends Model
{
 
    protected $guarded = [];
    protected $table = 'demande_applications';
    protected $connection = 'objapp_test';

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function profil()
    {
        return $this->belongsTo(ApplicationRole::class, 'application_id', 'application_id');
    }

    public function fields()
{
    return $this->hasMany(DemandeField::class, 'application_id', 'id');
}
    
}
