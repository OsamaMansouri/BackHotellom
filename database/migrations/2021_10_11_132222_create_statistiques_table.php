<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatistiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistiques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->float('activeClients')->default('0');
            $table->float('activeClientsWeek')->default('0');
            $table->float('activeClientsYear')->default('0');
            $table->float('commandsDay')->default('0');
            $table->float('commandsWeek')->default('0');
            $table->float('commandsMonth')->default('0');
            $table->float('commandsYear')->default('0');
            $table->float('salesDay')->default('0');
            $table->float('salesWeek')->default('0');
            $table->float('salesMonth')->default('0');
            $table->float('salesYear')->default('0');
            $table->float('avgDay')->default('0');
            $table->float('avgWeek')->default('0');
            $table->float('avgMonth')->default('0');
            $table->float('avgYear')->default('0');
            $table->float('conversionWeek')->default('0');
            $table->float('conversionMonth')->default('0');
            $table->float('conversionYear')->default('0');
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistiques');
    }
}
