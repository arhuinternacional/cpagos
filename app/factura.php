<?php

namespace App;

use App\Proveedor;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Factura extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'facturas';

    protected $fillable = [
    	'year',	
    	'week',
    	'proveedors_id',
    	'base_imponible',
    	'iva',
    	'total_fact',
    	'payout_1',
    	'payout_2',	
    	'payout_3',	
    	'payout_4',	
    	'payout_5',	
    	'payout_6',	
    	'payout_7',	
    	'payout_8',	
    	'payout_9',	
    	'payout_10',	
    	'total_pay',
    	'voucher_type',
        'status',
        'fact_type',
        'fact_day',
        'nro_fact',
        'verify'
    ];

    public function proveedors()
    {
    	return $this->belongsTo('App\Proveedor');
    }

    protected $attributes = array(
       'status' => 'por pagar',
       'verify' => 'verificada'
    );

    protected $dates = [
        'fact_day'
    ];

}
