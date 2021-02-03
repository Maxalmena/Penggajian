<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'promo_id', 'transaction_date', 'total_amount_before_discount', 'total_amount_after_discount'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function detailTransactions() {
        return $this->hasMany('App\DetailTransaction');
    }

    public function promo() {
        return $this->belongsTo('App\Promo');
    }
}
