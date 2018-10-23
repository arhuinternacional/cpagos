<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Costoincident extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'constoincidents';

    protected $fillable = [
		'proveedors_id',
		'drivers_id',
		'costo',
		'bonus_cat',
		'bonus_mount',
		'penalty_cat',
		'penalty_mount',
		'payout_cat',
		'payout_mount',
		'total_factura',
		'total_pay',
		'year',
		'week',
		'fecha_upload',
		'status',
		'observaciones',
    ];

    protected $attributes = array(
	   'status' => 'por procesar',
	);

	protected $dates = ['fecha_upload'];
}
