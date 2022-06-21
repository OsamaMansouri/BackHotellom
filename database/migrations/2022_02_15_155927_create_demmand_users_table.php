<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemmandUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demmand_users', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('demmand_id')->constrained()->nullable();
            $table->foreignId('demmand_option_id')->constrained()->nullable();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->integer('done_by')->nullable();
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
        Schema::dropIfExists('demmand_users');
    }
}
