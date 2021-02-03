<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    protected $fillable = [
        'seller_id','buyer_id','transaction_id','active','date','product_id','struktur','bukti'
    ];

    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }

}
