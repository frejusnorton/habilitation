<?php

namespace App\Models;

use App\Models\User;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogActivity extends Model
{
    use HasFactory;

    use HasFactory;

    protected $guarded = [];
    protected $table = 'user_activities';


    protected $casts = [
        'id' => 'string'
    ];

    public function userDetail(){
        return $this->hasOne(User::class,'id','user');
    }

    public static function filter($search,$debut,$fin,$user){
        $query = Self::orderBy('created_at', 'desc');
        if ($search && ! empty($search)) {
            $query->where(function ($query) use ($search){
                $explodeSearch = explode(' ',$search);
                foreach ($explodeSearch as  $item){
                    if (trim($item)){
                        $query->where('action','LIKE','%' .$item.'%')
                        ;
                    }
                }
            });
        }

        if ($user != null){
            $query->where('user',$user);
        }

        if ($debut != null && $fin != null ){
            $query->where('created_at','>=',$debut)->where('created_at','<=',$fin);
        }

        return $query;

    }
}
