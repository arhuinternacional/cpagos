<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Driver extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'drivers';

    protected $fillable = [
    	'driver',
    ];

    public function companies(){
    	return $this->belongsTo('App\Proveedor', 'proveedors_id');
    }

    public function costos(){
    	return $this->hasMany('App\Costo');
    }
}
