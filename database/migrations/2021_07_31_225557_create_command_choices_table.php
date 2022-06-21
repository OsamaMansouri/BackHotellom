<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('command_choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('command_option_id');
            $table->unsignedBigInteger('choice_id');
            $table->timestamps();

            $table->foreign('command_option_id')->references('id')->on('command_options')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('choice_id')->references('id')->on('choices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('command_choices');
    }
}
