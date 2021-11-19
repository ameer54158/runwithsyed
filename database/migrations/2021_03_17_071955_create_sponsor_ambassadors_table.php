<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorAmbassadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_ambassadors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sponsor_user_id');
            $table->foreign('sponsor_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('ambassador_user_id');
            $table->foreign('ambassador_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('sponsor_ambassadors');
    }
}
