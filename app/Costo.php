<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Costo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'costos';

    protected $fillable = [
		'costo',
		'bonus_cat',
		'bonus_mount',
		'penalty_cat',
		'penalty_mount',
		'payout_cat',
		'payout_mount',
		'total_factura',
		'total_pay',
		'fecha_upload',
		'week',
		'year', 
		'status',
		'observaciones',
		'nro_fact',
		'proveedores_id'
    ];

    protected $attributes = array(
	   'status' => 'por procesar',
	   'nro_fact' => ''
	);

    public function proveedores()
    {
    	return $this->belongsTo('App\Proveedor', 'proveedores_id');
    }

    public function drivers()
    {
    	return $this->belongsTo('App\Driver');
    }


    protected $casts = [
    	'fecha_upload' => 'datetime:Y-m-d',
	];

	protected $dates = [
        'fecha_upload'
    ];
}
