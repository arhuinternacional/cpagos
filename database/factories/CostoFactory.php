<?php

use App\Proveedor;
use App\Driver;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Costo::class, function (Faker $faker) {

	$categories = array('performance', 'acquisition', 'journey_adjustment', 'insurance', 'medical exam', 'fuel', 'other');

	$penalties = array('deduccion', 'mantenimiento');
	$payoutes = array('CASH', 'INDEPENDENCIA', 'LEASE CAPITAL', 'ANTICIPO');

	$costo = $faker->randomFloat(2,1,5000);
	$bonus_mount = $faker->randomFloat(2,1,1000);
	$penalty_mount = $faker->randomFloat(2,-50,0);
	$payout = $faker->randomFloat(2,-60,0);
	$total_fac = round($costo+$bonus_mount+$penalty_mount, 2);
	$total_pay = round($costo+$bonus_mount+$penalty_mount+$payout, 2);
	//$status = array('por procesar', 'procesado');
	$startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('-5 months', 'now')->getTimestamp());
    $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDate);
	$prov = Proveedor::with('drivers')->has('drivers')->get()->random(1)->first();

    $driver = $prov->drivers->random()->id;

    if ($costo > 2000) {
    	$status = 'observacion';
    }
	
	
    return [
		'costo' => (double)$costo,
		'bonus_cat' => $faker->randomElement($categories),
		'bonus_mount' => (double)$bonus_mount,
		'penalty_cat' => $faker->randomElement($penalties),
		'penalty_mount' => (double)$penalty_mount,
		'payout_cat' => $faker->randomElement($payoutes),
		'payout_mount' => (double)$payout,
		'total_factura' => (double)$total_fac,
		'status' => isset($status) ? $status : 'por procesar',
		'observaciones' => isset($status) ? 'Costo mayor a 2000' : null,
		'total_pay'=> (double)$total_pay,
		'fecha_upload'=> $endDate->toDateString(),
		'week' => $faker->numberBetween($min = 1, $max = 52),
		'year' => $faker->numberBetween($min = 2017, $max = 2018)
    ];
});
