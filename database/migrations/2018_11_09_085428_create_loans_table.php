<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_user')->unsigned();
            $table->float('loan_amount')->unsigned();
            $table->integer('loan_duration')->unsigned();
            $table->float('loan_interest_rate')->unsigned();
            $table->enum('loan_repayment_frequency', [REPAYMENT_TYPE_MONTHLY,REPAYMENT_TYPE_WEEKLY,REPAYMENT_TYPE_DAILY,REPAYMENT_TYPE_ANNUALLY]);
            $table->float('loan_arrangement_fee')->unsigned();
            $table->float('loan_payment_amt')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('loan_user')->references('id')->on('loan_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
