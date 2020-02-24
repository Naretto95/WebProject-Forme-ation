<?php

namespace App\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait DateScopable{
	public function scopeExpired(Builder $query){
    	$query->where('date', '<=', now());
    }
}