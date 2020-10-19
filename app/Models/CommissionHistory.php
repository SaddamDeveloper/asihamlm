<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionHistory extends Model
{
    protected $table = 'commission_histories';
    protected $fillable = ['user_id', 'pair_number', 'amount', 'comment', 'status'];
    protected $primaryKey = 'id';
}
