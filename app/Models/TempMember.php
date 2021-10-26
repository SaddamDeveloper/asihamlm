<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempMember extends Model
{
    protected $table = 'temp_members';
    protected $fillable = [
        'login_id',	'sponsor_id', 'leg', 'name', 'email', 'password', 'mobile', 'gender', 'dob', 'state', 'city', 'pin', 'status'];
    protected $primaryKey = 'id';
}
