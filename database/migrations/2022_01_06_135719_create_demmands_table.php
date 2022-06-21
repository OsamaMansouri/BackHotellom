<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemmandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demmands', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('option');
            $table->string('message');
            $table->integer('isEmpthy')->default(0);
            $table->foreignId('client_id')->constrained();
            $table->foreignId('hotel_id')->constrained();
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
        Schema::dropIfExists('demmands');
    }
}
