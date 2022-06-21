<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('role_id');
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('experation_date')->nullable();
            $table->string('password')->nullable();
            $table->string('social_id')->nullable();
            $table->string('image')->nullable();
            $table->string('etat')->nullable();
            $table->date('dateNaissance')->nullable();
            $table->string('gender')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('function')->nullable();
            $table->string('deviceToken')->nullable();
            $table->string('del')->default(0);
            /*$table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();*/
            $table->rememberToken();
            $table->timestamps();

            //$table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        /*Schema::table('users', function (Blueprint $table){
            $table->dropForeign('role_id');
            $table->dropColumn("role_id");
        });*/

    }
}
