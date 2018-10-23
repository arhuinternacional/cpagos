<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('year');
            $table->string('week');
            $table->double('total_fact');
            $table->double('total_pay');
            $table->timestamp('fecha_upload');
            $table->string('fact_type')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('fi_status')->default('por procesar');
            $table->integer('proveedor_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('proveedor_id')->references('id')->on('proveedors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura_incidents');
    }
}
