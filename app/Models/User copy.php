<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasUuid;
use App\Models\Approbateur;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


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

    public function employe (){
        return $this->hasOne(Employe::class,'login','username');
    }

    public function approbateurs (){
        return $this->hasMany(Approbateur::class,'users_id','id');
    }


}
