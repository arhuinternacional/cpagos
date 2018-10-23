<?php

namespace App;

use App\Proveedor;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FacturaIncident extends Eloquent
{

	protected $connection = 'mongodb';
	protected $collection = 'Facturaincidents';

    protected $fillable = [
    	'company_id',
    	'company_name',
		'year',
		'week',
		'total_fact',
		'total_pay',
		'fecha_upload',
		'fact_type',
		'status',
		'proveedors_id',
		'observaciones'
    ];

    public function proveedors()
    {
    	return $this->belongsTo('App\Proveedor');
    }
}
