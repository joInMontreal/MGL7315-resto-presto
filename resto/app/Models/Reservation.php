<?php

namespace App\Models;

use App\Helpers\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

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

    public function sendRestoNotification()
    {
        $reservation = $this;
        Mail::send('emails.reservation_new', [
            'reservation' => $reservation,
            'reservedAt' => $reservation->getReservedAtObject()->format('d/m/Y H\hi'),
            'baseUrl' => env('BASE_URL'),
        ], function ($m) use ($reservation) {
            $m->from('no-reply@muschalle.com', 'RestoPresto');
            $m->subject('Nouvelle réservation');
            $m->to(env('ADMIN_EMAIL'), 'Resto admin');
        });
    }

    public function setStatus($status, $note)
    {
        if ($this->status != $status) {
            $this->status = $status;
            $this->note = $note;
            $this->sendCustomerNotification();
        }
    }

    public function getStatusText()
    {
        switch ($this->status) {
            case self::STATUS_ACCEPTED:
                return 'Accepté';
                break;
            case self::STATUS_REFUSED:
                return 'Refusé';
                break;
            case self::STATUS_NEW:
                return 'En attente';
                break;
            default:
                return 'En attente';
        }
    }

    public function sendCustomerNotification()
    {
        $reservation = $this;
        Mail::send('emails.reservation_status', [
            'reservation' => $reservation,
            'reservedAt' => $reservation->getReservedAtObject()->format('d/m/Y H\hi'),
            'baseUrl' => env('BASE_URL'),
        ], function ($m) use ($reservation) {
            $m->from('no-reply@muschalle.com', 'RestoPresto');
            $subject = 'Votre réservation est ' . strtolower($this->getStatusText());
            $m->subject($subject);
            $m->to(
                $this->customer->email,
                $this->customer->first_name . ' ' . $this->customer->last_name
            );
        });
    }

    public function getReservedAtObject()
    {
        if ($this->reserved_at instanceof \DateTime) {
            return $this->reserved_at;
        } else {
            return \DateTime::createFromFormat('Y-m-d H:i:s', $this->reserved_at);
        }
    }

    public function getCreatedAtObject()
    {
        if ($this->created_at instanceof \DateTime) {
            return $this->created_at;
        } else {
            return \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
        }
    }
    
    public function getPeriod()
    {
    	setlocale(LC_TIME, "fr_FR");
    	$reservDate = strtotime($this->reserved_at);
    	if( date('H', $reservDate) >16 )
    		$period = "souper";
    	else
    		$period = "diner";
    	return strftime("%A le %d %b.", $reservDate)." / ".$period;
    	//return $this->getReservedAtObject()->format('D/m/Y H\hi');
    }

    public function getTime()
    {
        $reservDate = strtotime($this->reserved_at);
        return strftime("%H:%m", $reservDate);
/*
        if ($this->reserved_at instanceof \DateTime) {
            return strftime("%H:%m", $this->reserved_at);
        } else {
            return strftime("%H:%m", \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at));
        }
        */
    }
    
}
