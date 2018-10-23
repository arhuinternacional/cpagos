<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedors_id')->unsigned();
            $table->string('year');
            $table->string('week');
            $table->string('base_imponible')->nullable();
            $table->string('iva')->nullable();
            $table->double('total_fact');
            $table->string('payout_1')->nullable();
            $table->string('payout_2')->nullable();
            $table->string('payout_3')->nullable();
            $table->string('payout_4')->nullable();
            $table->string('payout_5')->nullable();
            $table->string('payout_6')->nullable();
            $table->string('payout_7')->nullable();
            $table->string('payout_8')->nullable();
            $table->string('payout_9')->nullable();
            $table->string('payout_10')->nullable();
            $table->double('total_pay');
            $table->string('voucher_type')->nullable();
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
        Schema::dropIfExists('facturas');
    }
}
