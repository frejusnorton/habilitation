<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function filter($search = '', $role = null, $statut = null)
    {
        $query = Self::with(['agence', 'service', 'departement', 'direction'])->orderBy('created_at', 'desc');

        if ($search && ! empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as  $item) {
                    if (trim($item)) {
                        $query->where(DB::RAW('upper(USERNAME)'), 'LIKE', '%' . strtoupper(trim($item)) . '%')
                            ->orwhere(DB::RAW('upper(EMAIL)'), 'LIKE', '%' . strtoupper(trim($item)) . '%')
                        ;
                    }
                }
            });
        }

        if ($statut != null) {
            $query->whereHas('user', function ($query) use ($statut) {
                $query->where('statut', '=', $statut);
            });
        }

        if ($role != null) {
            $query->whereHas('user', function ($query) use ($role) {
                $query->where('role', '=', $role);
            });
        }

        return $query->paginate(10);
    }

    
    public function scopeFilter($query, $search = '', $role = null, $statut = null)
    {
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $explodeSearch = explode(' ', $search);
                foreach ($explodeSearch as $item) {
                    if (trim($item)) {
                        $query->whereRaw('UPPER(USERNAME) LIKE ?', ['%' . strtoupper(trim($item)) . '%'])
                            ->orWhereRaw('UPPER(EMAIL) LIKE ?', ['%' . strtoupper(trim($item)) . '%']);
                    }
                }
            });
        }

        if ($statut !== null) {
            $query->where('statut', '=', $statut);
        }

        if ($role !== null) {
            $query->where('role', '=', $role);
        }

        return $query;
    }

    public function userRole()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    public function initiateur()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function validateur()
    {
        return $this->belongsTo(User::class, 'autorized_by');
    }


    public static function findByUsernameOrEmail($usernameOrEmail)
    {
        return static::where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();
    }


    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
    public function agence()
    {
        return $this->belongsTo(Agence::class, 'agence_id', "age");
    }
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function validateur1()
    {
        return $this->belongsTo(User::class, 'validateur_1');
    }

    public function validateur2()
    {
        return $this->belongsTo(User::class, 'validateur_2');
    }

    public function validateur3()
    {
        return $this->belongsTo(User::class, 'validateur_3');
    }

    public function superieur()
    {
        return $this->belongsTo(User::class, 'superieur_id');
    }
}
