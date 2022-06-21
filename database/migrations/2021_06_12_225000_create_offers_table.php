<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->integer('Frequency')->nullable();
            $table->dateTime('startDate')->nullable();
            $table->time('startTime')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->text('description')->nullable();
            $table->float('prix')->default('0');
            $table->float('profit')->default('0');
            $table->float('discount')->default('0');
            $table->float('prixFinal')->default('0');
            $table->string('image')->nullable();
            $table->integer('status')->default('0');
            $table->integer('orders')->default('0');
            $table->timestamps();
            
            $table->foreignId('type_id')->constrained();
            $table->unsignedBigInteger('hotel_id');
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
        Schema::dropIfExists('offers');
    }
}
