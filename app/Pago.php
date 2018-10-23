<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Pago extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'pagos';

    protected $fillable = [
    	'doi',
    	'doi_num',
    	'tipo_abono',
    	'n_cuenta',
    	'nombre',
    	'importe',
    	'ref',
    	'status',
    	'observacion',
    	'proveedors_id',
        'transaction_n',
        'transaction_emit',
        'transaction_payed',
        'group',
        'd_operation'
    ];

    public function proveedors()
    {
    	return $this->belongsTo('App\Proveedor');
    }

    protected $attributes = array(
       'transaction_emit' => null,
       'transaction_payed' => null,
       'transaction_n' => null
    );

    protected $dates = [
        'transaction_emit',
        'transaction_payed'
    ];
}
