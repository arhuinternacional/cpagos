<?php

use App\Proveedor;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Costoincident::class, function (Faker $faker) {

	$categories = array('performance', 'acquisition', 'journey_adjustment', 'insurance', 'medical exam', 'fuel', 'other');

	$prov = $faker->lexify('????????????????????????????????');

	$penalties = array('deduccion', 'mantenimiento');
	$payoutes = array('CASH', 'INDEPENDENCIA', 'LEASE CAPITAL', 'ANTICIPO');

	$costo = $faker->randomFloat(2,1,5000);
	$bonus_mount = $faker->randomFloat(2,1,1000);
	$penalty_mount = $faker->randomFloat(2,-50,0);
	$payout = $faker->randomFloat(2,-60,0);
	$total_fac = round($costo+$bonus_mount+$penalty_mount, 2);
	$total_pay = round($costo+$bonus_mount+$penalty_mount+$payout, 2);
	
    return [
        'proveedors_id' => $prov,
		'drivers_id' => $faker->bothify('##??##??##??##??##??##??##??##??##??##??##?'),
		'costo' => $costo,
		'bonus_cat' => $faker->randomElement($categories),
		'bonus_mount' => $bonus_mount,
		'penalty_cat' => $faker->randomElement($penalties),
		'penalty_mount' => $penalty_mount,
		'payout_cat' => $faker->randomElement($payoutes),
		'payout_mount' => $payout,
		'total_factura' => $total_fac,
		'total_pay'=> $total_pay,
		'fecha_upload'=> Carbon::createFromTimeStamp($faker->dateTimeBetween('-2 months', 'now')->getTimestamp()),
		'week' => $faker->numberBetween($min = 1, $max = 52),
		'year' => $faker->numberBetween($min = 2017, $max = 2018)
    ];
});
