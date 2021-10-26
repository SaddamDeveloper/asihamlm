<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $table = 'wallet_histories';
    protected $fillable = [
        'wallet_id',
        'user_id',
        'transaction_type',
        'amount',
        'total_amount',
        'comment'];

    protected $primaryKey = 'id';

    public function wallet()
    {
        return $this->belongsTo('App\Models\Wallet', 'wallet_id', $primaryKey);
    }
}
