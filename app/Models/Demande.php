<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'demandes';
    protected $connection = 'objapp_test';

    public function scopeFilter($query, $search = '', $statut = null)
    {
        if ($search && !empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if ($search && !empty($search)) {
                        $query->where(function ($query) use ($search) {
                            $explodeSearch = explode(' ', $search);
                            foreach ($explodeSearch as $item) {
                                if (trim($item)) {
                                    $query->whereRaw('UPPER(reference) LIKE ?', ['%' . strtoupper(trim($item)) . '%'])
                                        ->orWhere('id', 'LIKE', '%' . trim($item) . '%');

                                    $query->orWhereHas('user', function ($query) use ($item) {
                                        $query->whereRaw('UPPER(username) LIKE ?', ['%' . strtoupper(trim($item)) . '%']);
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }

        if ($statut !== null) {
            $query->where('statut', '=', $statut);
        }

        return $query;
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->reference = 'REF-' . strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function field()
    {
        return $this->hasMany(DemandeField::class, 'demande_id', 'id');
    }
    public function application()
    {
        return $this->hasMany(DemandeApplication::class, 'demande_id', 'id')
            ->with('application');
    }

    public function fluxHistoriques()
    {
        return $this->hasMany(FluxHistorique::class);
    }
}
