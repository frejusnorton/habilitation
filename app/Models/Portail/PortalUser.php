<?php

namespace App\Models\portail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalUser extends Model
{
    use HasFactory;

    protected $connection = 'objapp_test_2';
    protected $table = 'PORTAL_USERS';

    
}
