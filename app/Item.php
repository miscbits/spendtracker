<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
    ];

    public function purchases() {
        return $this->belongsToMany('App\Purchase');
    }

    public function types() {
        return $this->belongsToMany('App\Type');
    }
}
