<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PairTiming extends Model
{
    protected $table = 'pair_timings';
    protected $fillable = ['name', 'from', 'to'];
    protected $primaryKey = 'id';
}
