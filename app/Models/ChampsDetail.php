<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChampsDetail extends Model
{
    use HasFactory;

    protected $table = 'champs_details';

    public function demandeField()
    {
        return $this->hasOne(DemandeField::class, 'champ_details_id', 'id');
    }
}
