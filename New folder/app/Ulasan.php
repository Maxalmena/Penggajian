<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $fillable = ['user_id','product_id','ulasan','rating','date','updated_at','created_at'];
}
