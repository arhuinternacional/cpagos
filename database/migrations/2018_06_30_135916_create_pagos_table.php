<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doi')->nullable();
            $table->string('doi_num')->nullable();
            $table->string('tipo_abono')->nullable();
            $table->string('n_cuenta')->nullable();
            $table->string('nombre')->nullable();
            $table->string('importe')->nullable();
            $table->string('ref')->nullable();
            $table->string('pg_status')->nullable();
            $table->string('observacion')->nullable();
            $table->integer('id_proveedor')->unsigned()->nullable();
            $table->string('transaction_n')->nullable();
            $table->timestamp('transaction_emit');
            $table->string('transaction_payed')->nullable();
            $table->string('d_operation')->nullable();
            $table->integer('group')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('id_proveedor')->references('id')->on('proveedors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
