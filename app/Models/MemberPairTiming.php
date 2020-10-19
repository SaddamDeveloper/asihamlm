<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberPairTiming extends Model
{
    protected $table = 'member_pair_timings';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
