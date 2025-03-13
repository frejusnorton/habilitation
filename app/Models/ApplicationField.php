<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationField extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'application_fields';
    protected $connection = 'objapp_test';

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }


    public function fields()
    {
        return $this->belongsTo(Champs::class, 'champs_id');
    }
    public function champ()
    {
        return $this->belongsTo(Champs::class, 'champs_id');
    }
}
