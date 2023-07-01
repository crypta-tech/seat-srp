<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixSrpPrimaryKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cryptatech_seat_srp_srp', function (Blueprint $table) {

            $table->dropPrimary(['user_id', 'kill_id']);
            $table->primary('kill_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cryptatech_seat_srp_srp', function (Blueprint $table) {

        });
    }
}
