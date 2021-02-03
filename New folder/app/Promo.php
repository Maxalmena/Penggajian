<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'name', 'code', 'promo_discount', 'start_date', 'end_date','type'
    ];

    public function transaction() {
        return $this->hasOne('App\Transaction');
    }
}
