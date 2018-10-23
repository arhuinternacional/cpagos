<?php

use Faker\Generator as Faker;

$factory->define(App\Proveedor::class, function (Faker $faker) {
    
    $name = $faker->firstName.' '.$faker->firstName.' '.$faker->lastName.' '. $faker->lastName;

    $document = array('RUC', 'PASAPORTE', 'DNI', 'C.E');

    $tax_code = $faker->randomNumber(9,true).$faker->randomNumber(2,true);

    $bank_tax_code = substr($tax_code, 2, -1);

    return [
        'company_id' => $faker->lexify('????????????????????????????????'),
		'company_name' => $name,
		'company_phone' => $faker->e164PhoneNumber,
		'company_email' => $faker->email,
		'tax_code' => $tax_code,
		'company_notes' => true,
		'status' => true,
		'bank_account_holder_name' => $name,
		'bank_tax_code_name' => $faker->randomElement($document),
		'bank_tax_code' => $bank_tax_code,
		'bank_account_number' => $faker->randomNumber(9,true).$faker->randomNumber(9,true).$faker->randomNumber(2,true) 
    ];
});
