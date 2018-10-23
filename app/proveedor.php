<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Proveedor extends Eloquent
{

	//use LogsActivity;

    protected $connection = 'mongodb';
	protected $collection = 'proveedors';

    protected $fillable = [
    	'company_id',
		'company_name',
		'company_phone',
		'company_email',
		'tax_code',
		'company_notes',
		'status',
		'bank_account_holder_name',
		'bank_tax_code_name',
		'bank_tax_code',
		'bank_account_number',
	];

	/*protected static $logFillable = true;

	 protected static $logOnlyDirty = true;*/

	public function drivers()
	{
		return $this->hasMany('App\Driver', 'proveedors_id');
	}

	public function costos()
	{
		return $this->hasMany('App\Costo', 'proveedores_id');
	}

	public function facturas()
	{
		return $this->hasMany('App\Factura', 'proveedors_id');
	}

	public function facturasIncidents()
	{
		return $this->hasMany('App\FacturaIncident');
	}

	public function pagos()
	{
		return $this->hasMany('App\Pago');
	}
}
