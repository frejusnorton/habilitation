<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Derogation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'derogations';
    protected $connection = 'objapp_test';

}
