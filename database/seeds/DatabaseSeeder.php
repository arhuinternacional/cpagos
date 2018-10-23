<?php

use App\User;
use App\Proveedor;
use App\Driver;
use App\Costo;
use App\Costoincident;
use App\Factura;
use App\Pago;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Proveedor::truncate();
        Driver::truncate();
        Costo::truncate();
        Factura::truncate();
        Pago::truncate();
        Costoincident::truncate();
        User::truncate();

        $user = new User();
        $user->dni = '12345678';
        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->username = 'administrador';
        $user->estado = true;
        $user->perfil = 'administrador';
        $user->password = bcrypt('secret');
        $user->save();

        /*$cantidadProveedores = 10;
        $cantidadDrivers = 10;
        $cantidadCostos = 10;
        $cantidadIncidentesCosto = 10;
        $cantidadFacturas = 10;

        factory(Proveedor::class, $cantidadProveedores)->create();
        factory(Driver::class, $cantidadDrivers)->create()->each(function($item){
            $prov = Proveedor::all()->random(1)->first();

            $item->companies()->associate($prov);

            $item->save();
        });
        factory(Costo::class, $cantidadCostos)->create()->each(function($item){
            $prov = Proveedor::with('drivers')->has('drivers')->get()->random(1)->first();

            $driver = $prov->drivers()->get()->random(1)->first();

            $item->drivers()->associate($driver);
            $item->proveedores()->associate($prov);

            $item->save();
        });
        factory(Costoincident::class, $cantidadIncidentesCosto)->create();
        factory(Factura::class, $cantidadFacturas)->create();*/
    }
}
