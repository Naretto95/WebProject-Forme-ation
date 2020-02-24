<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
    	'lastname', 'firstname', 'birthday', 'email', 'address', 'deposit', 'training_id', 'verificated'
    ];
}
