<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromProlongationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prolongations', function (Blueprint $table) {
            $table->dropColumn(['startDate', 'endDate']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prolongations', function (Blueprint $table) {
            $table->dateTime('startDate')->after('hotel_id');
            $table->dateTime('endDate')->after('startDate');
        });
    }
}
