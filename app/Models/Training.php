<?php

namespace App\Models;

use App\Scopes\DateScopable;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
	use DateScopable;
	
    protected $fillable = [
        'email', 'name', 'domain', 'diploma', 'cost', 'date', 'start', 'end', 'location', 'Ncoord', 'Ecoord', 'region', 'department', 'description', 'funding', 'prospect', 'verificated',
    ];
}
