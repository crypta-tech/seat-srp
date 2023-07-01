<?php
/**
 * User: Warlof Tutsimo <loic.leuilliot@gmail.com>
 * Date: 01/12/2017
 * Time: 20:42.
 */

namespace CryptaTech\Seat\SeatSrp\Models;

use Illuminate\Database\Eloquent\Model;
use Seat\Eveapi\Models\Killmails\Killmail;
use Seat\Web\Models\User;

class Quote extends Model
{

    // $table->bigIncrements('id');
    // $table->bigInteger('killmail_id')->unique();
    // $table->integer('user')->unsigned();
    // $table->float('value');
    // $table->timestamps();

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $table = 'cryptatech_seat_srp_quote';

    protected $fillable = [
        'killmail_id', 'user', 'value',
    ];

    public function killmail()
    {
        return $this->hasOne(Killmail::class, 'killmail_id', 'killmail_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'groupID', 'group_id');
    }
}
