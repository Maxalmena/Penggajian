<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'category_gender', 'category_age'
    ];

    public function product() {
        return $this->hasOne('App\Product');
    }
}
