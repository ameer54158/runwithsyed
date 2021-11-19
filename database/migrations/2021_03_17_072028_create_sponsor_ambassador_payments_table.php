<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorAmbassadorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_ambassador_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sponsor_ambassador_id');
            $table->foreign('sponsor_ambassador_id')->references('id')->on('sponsor_ambassadors')->onDelete('cascade');
            $table->unsignedBigInteger('ambassador_runs_id');
            $table->foreign('ambassador_runs_id')->references('id')->on('ambassador_runs')->onDelete('cascade');
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
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
        Schema::dropIfExists('sponsor_ambassador_payments');
    }
}
