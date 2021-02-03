<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatDetail extends Model
{
    protected $fillable = [
        'id','chat','product_id','active','date','struktur'
    ];
}
