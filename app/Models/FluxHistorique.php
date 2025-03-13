<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FluxHistorique extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'flux_historiques';
    protected $connection = 'objapp_test';
    public static function filter($search = '', $statut = null)
    {
        $query = self::orderBy('created_at', 'desc');
        if ($search && !empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if (trim($item)) {
                        $query->where(DB::RAW('upper(validatedBy)'), 'LIKE', '%' . strtoupper(trim($item)) . '%');
                    }
                }
            });
        }
        return $query;
    }
    public function validateur()
    {
        return $this->belongsTo(User::class, 'validatedby', 'id');
    }
}
