<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'seller_id','user_id','chat','active','user_active','seller_active'
    ];


}
