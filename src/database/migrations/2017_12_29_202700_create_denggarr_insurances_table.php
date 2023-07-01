<?php

use CryptaTech\Seat\SeatSrp\Models\KillMail;
use CryptaTech\Seat\SeatSrp\Models\Sde\InvType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenggarrInsurancesTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('cryptatech_srp_insurances')){
            Schema::create('cryptatech_srp_insurances', function (Blueprint $table) {

                $table->bigInteger('type_id');
                $table->string('name');
                $table->decimal('cost', 30, 2)->default(0.0);
                $table->decimal('payout', 30, 2)->default(0.0);

                $table->primary(['type_id', 'name']);

            });
        }

        if (Schema::hasTable('cryptatech_seat_srp_srp') && ! Schema::hasColumn('cryptatech_seat_srp_srp', 'type_id')) {
            Schema::table('cryptatech_seat_srp_srp', function (Blueprint $table) {
                $table->bigInteger('type_id')->after('cost');

                $table->index('type_id');
            });

            $killmails = KillMail::whereNull('type_id')
                                ->orWhere('type_id', 0)
                                ->get();

            foreach ($killmails as $killmail) {

                $type = InvType::where('typeName', $killmail->ship_type)->first();

                if (is_null($type))
                    continue;

                $killmail->update([
                    'kill_id' => $killmail->kill_id,
                    'type_id' => $type->typeID,
                ]);

            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('cryptatech_srp_insurances'))
            Schema::drop('cryptatech_srp_insurances');
    }
}
