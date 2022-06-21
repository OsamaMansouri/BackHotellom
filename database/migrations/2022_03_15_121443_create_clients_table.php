<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('fullName')->nullable();
            $table->string('poste')->nullable();
            $table->string('etablissement')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('datePre')->nullable();
            $table->string('type')->nullable();
            $table->text('demmands')->nullable();
            $table->string('ville')->nullable();
            $table->string('priorite')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
