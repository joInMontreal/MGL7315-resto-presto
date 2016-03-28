<?php

namespace App\Models;

use App\Helpers\Date;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REFUSED = 2;
    const DEFAULT_NB_HOURS_LUNCH = 1;
    const DEFAULT_NB_HOURS_DINER = 2;

    protected $fillable = [
        'reserved_at',
        'nb_invites',
        'customer_id',
        'status',
        'note',
        'nb_hours',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function build(
        Customer $customer,
        \DateTime $reservedAt,
        $nbInvite
    ) {
        $nbHours = self::DEFAULT_NB_HOURS_LUNCH;
        if ((int)$reservedAt->format('H') > 14) {
            $nbHours = self::DEFAULT_NB_HOURS_DINER;
        }

        return new static([
            'customer_id' => $customer->id,
            'nb_invites' => $nbInvite,
            'reserved_at' => $reservedAt,
            'status' => self::STATUS_NEW,
            'nb_hours' => $nbHours,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
