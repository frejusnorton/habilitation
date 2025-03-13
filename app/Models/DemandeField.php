<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeField extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'demande_fields';
    protected $connection = 'objapp_test';

    public function champDetails()
    {
        return $this->belongsTo(ChampsDetail::class, 'champ_details_id', 'id');
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'demande_id');
    }

    public function champ()
    {
        return $this->belongsTo(Champs::class, 'champs_id');
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class, 'value', 'rn');
    }

    public function application()
{
    return $this->belongsTo(Application::class, 'application_id', 'id');
}

}
