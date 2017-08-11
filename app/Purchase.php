<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'name', 'cost',
    ];

	public function items() {
		return $this->belongsToMany('App\Item');
	}
}
