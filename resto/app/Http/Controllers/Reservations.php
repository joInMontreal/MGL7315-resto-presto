<?php

namespace App\Http\Controllers;

use App\Exceptions\RestoError;
use App\Helpers\Date;
use App\Helpers\Validator;
use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Http\Request;

class Reservations extends Controller
{
    const MINIMUM_SEC_BEFORE_RESERVATION = 3600;
    const MINIMUM_INVITE = 1;
    const MAXIMUM_INVITE = 16;
    const NB_HOURS_MIN = 0.5;
    const NB_HOURS_MAX = 5;

    protected $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function showForm()
    {
        return view('reservation_form', ['users' => []]);
    }

    protected function translation()
    {
        return [
            'first_name' => 'Prénom',
            'last_name' => 'Nom',
            'phone' => 'Téléphone',
            'email' => 'Email',
            'reserved_at' => 'Date de réservation',
            'nb_invites' => 'Nombre d\'invités',
            'occasion' => 'Ocassion',
            'nb_hours' => 'Durée',
            'status' => 'Statut',
            'note' => 'Note',
        ];
    }

    protected function validateReservedAt(\DateTime $reservedAt)
    {
        $now = Date::now();
        $diff = $reservedAt->getTimestamp() - $now->getTimestamp();
        if ($diff < 0) {
            throw new RestoError("La date de reéservation ne peut pas être dans le passé");
        }
        if ($diff < self::MINIMUM_SEC_BEFORE_RESERVATION) {
            throw new RestoError("Une réservation doit être faite au moins une heure avant");
        }
    }

    protected function validateNbInvites($nbInvites)
    {
        if ($nbInvites < self::MINIMUM_INVITE) {
            throw new RestoError("Une réservation doit avoir au moins " . self::MINIMUM_INVITE . " invités");
        }
        if ($nbInvites > self::MAXIMUM_INVITE) {
            throw new RestoError("Pour une réservation de plus de " . self::MAXIMUM_INVITE .
                " personnes, s'il vous plaît nous appeler au 514-555-1212.");
        }
    }

    public function reserve(Request $request)
    {
        try {
            $this->validator->validateRequest($request, [
                'first_name' => Validator::VALIDATOR_STRING,
                'last_name' => Validator::VALIDATOR_STRING,
                'phone' => Validator::VALIDATOR_PHONE,
                'email' => Validator::VALIDATOR_EMAIL,
                'reserved_at' => Validator::VALIDATOR_DATETIME,
                'nb_invites' => Validator::VALIDATOR_NUMBER,
                'occasion' => Validator::VALIDATOR_STRING,
            ], $this->translation());

            $reservedAt = \DateTime::createFromFormat(
                'Y-m-d H:i',
                $request->json('reserved_at'),
                Date::timeZone()
            );

            $this->validateReservedAt($reservedAt);

            $customer = Customer::build(
                $request->json('first_name'),
                $request->json('last_name'),
                $request->json('email')
            );
            $customer->phone = $request->json('phone', '');
            $customer->save();
            $this->validateNbInvites($request->json('nb_invites'));
            $reservation = Reservation::build(
                $customer,
                $reservedAt,
                $request->json('nb_invites')
            );
            $reservation->occasion = $request->json('occasion');
            $reservation->save();
            $reservation->sendRestoNotification();

            $data = $reservation->toArray();
            $data['customer'] = $customer->toArray();
            $response = [
                'status' => 1,
                'data' => $data,
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($response);
    }

    public function single($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        $response = $reservation->toArray();
        $response['customer'] = $reservation->customer->toArray();
        return response()->json($response);
    }

    public function confirmation($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        return view('reservation_confirmation', ['reservation' => $reservation]);
    }

    public function detail($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        return view('reservation_detail', [
            'reservation' => $reservation,
            'statusNew' => Reservation::STATUS_NEW,
            'statusAccepted' => Reservation::STATUS_ACCEPTED,
            'statusRefused' => Reservation::STATUS_REFUSED,
        ]);
    }

    protected function validateNdHours($nbHours)
    {
        if ($nbHours < self::NB_HOURS_MIN) {
            throw new RestoError("La durée doit être au moins " . self::NB_HOURS_MIN . "h");
        }
        if ($nbHours > self::NB_HOURS_MAX) {
            throw new RestoError("La durée doit être au maximum " . self::NB_HOURS_MAX . "h");
        }
    }

    public function confirm(Request $request)
    {
        try {
            $this->validator->validateRequest($request, [
                'nb_hours' => Validator::VALIDATOR_NUMBER,
                'note' => Validator::VALIDATOR_STRING,
                'status' => Validator::VALIDATOR_NUMBER,
            ], $this->translation());
            $reservationId = $request->json('reservation_id');
            $reservation = Reservation::find($reservationId);
            $this->validateNdHours($request->json('nb_hours'));

            $reservation->nb_hours = $request->json('nb_hours');
            $reservation->setStatus($request->json('status'), $request->json('note'));
            $reservation->save();
            $response = [
                'status' => 1,
                'data' => $reservation->toArray(),
            ];

        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($response);
    }
}
