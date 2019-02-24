<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->double('sallary');
            $table->double('insurance');
            $table->double('pos_allowance');
            $table->double('meal');
            $table->double('service_charge');
            $table->double('sallary_plus_insurance');
            $table->double('y_sallary');
            $table->double('ho_allowance');
            $table->double('y_sallary_plus_ho_allowance');
            $table->double('pos_cost');
            $table->double('ptkp');
            $table->double('pkp');
            $table->double('fixed_pkp');
            $table->double('anual_pph21');
            $table->double('sanksi')->comment('Filled if npwp not available ');
            $table->double('anual_pph21_plus_sanksi');
            $table->double('monthly_pph21');
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
        Schema::dropIfExists('taxes');
    }
}
