<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAmbassadorRunsIdConstraintsInSponsorAmbassadorPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsor_ambassador_payments', function (Blueprint $table) {
            $table->dropForeign('sponsor_ambassador_payments_ambassador_runs_id_foreign');
            $table->dropColumn('ambassador_runs_id');
            $table->string('month_year')->nullable()->after('sponsor_ambassador_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsor_ambassador_payments', function (Blueprint $table) {
            //
        });
    }
}
