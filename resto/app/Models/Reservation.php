<?php

namespace App\Models;

use App\Helpers\Date;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reserved_at',
        'nb_invites',
        'customer_id',
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
        return new static([
            'customer_id' => $customer->id,
            'nb_invites' => $nbInvite,
            'reserved_at' => $reservedAt,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
