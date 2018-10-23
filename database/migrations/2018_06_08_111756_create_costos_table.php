<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedors_id')->unsigned();
            $table->integer('drivers_id')->unsigned();
            $table->double('costo')->default(0);
            $table->string('bonus_cat')->nullable();
            $table->double('bonus_mount')->default(0);
            $table->string('penalty_cat')->nullable();
            $table->double('penalty_mount')->default(0);
            $table->string('payout_cat')->nullable();
            $table->double('payout_mount')->default(0);
            $table->double('total_factura')->default(0);
            $table->double('total_pay')->default(0);
            $table->timestamp('fecha_upload');
            $table->string('week');
            $table->string('year');
            $table->timestamps();
            $table->foreign('proveedors_id')->references('id')->on('proveedors');
            $table->foreign('drivers_id')->references('id')->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costos');
    }
}
