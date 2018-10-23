<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostoincidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costoincidents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('proveedors_id');
            $table->string('drivers_id');
            $table->double('costo')->default(0);
            $table->string('bonus_cat')->nullable();
            $table->double('bonus_mount')->default(0);
            $table->string('penalty_cat')->nullable();
            $table->double('penalty_mount')->default(0);
            $table->string('payout_cat')->nullable();
            $table->double('payout_mount')->default(0);
            $table->double('total_factura')->default(0);
            $table->double('total_pay')->default(0);
            $table->string('observaciones')->nullable();
            $table->string('week');
            $table->string('year');
            $table->timestamp('fecha_upload');
            $table->string('ci_status')->default('por procesar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costoincidents');
    }
}
