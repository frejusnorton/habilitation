<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table='user_history';

}
