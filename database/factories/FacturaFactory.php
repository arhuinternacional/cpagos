<?php

use App\Proveedor;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Factura::class, function (Faker $faker) {
    $total = $faker->randomFloat(2,1,5000);

    return [
        'proveedors_id' => Proveedor::all()->random(1)->first(),
        'year' => $faker->numberBetween($min = 2017, $max = 2018),
        'week' => $faker->numberBetween($min = 1, $max = 52),
        'total_fact' => (double)$total,
        'total_pay' => (double)$total,
        'fact_day' => Carbon::now(),
        'status' => 'por pagar',
        'fact_type' => $faker->randomElement(array ('generada', 'manual'))
    ];
});
