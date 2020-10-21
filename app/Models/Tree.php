<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $table = 'tree';
    protected $fillable = [
        'user_id',
        'left_id',
        'right_id',
        'parent_id',
        'registered_by',
        'left_count',
        'right_count',
        'total_left_count',
        'total_right_count',
        'total_pair',
        'parent_leg'
    ];

    protected $primaryKey = 'id';

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'user_id', 'id');
    }
}
