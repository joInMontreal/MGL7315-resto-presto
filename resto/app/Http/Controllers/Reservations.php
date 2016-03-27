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
    const MINIMUM_INVITE = 2;

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
            'city' => 'Ville',
            'address' => 'Adresse',
            'phone' => 'Téléphone',
            'email' => 'Email',
            'reserved_at' => 'Date de réservation',
            'nb_invites' => 'Nombre d\'invités',
            'occasion' => 'Ocassion',
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
    }

    public function reserve(Request $request)
    {
        try {
            $this->validator->validateRequest($request, [
                'first_name' => Validator::VALIDATOR_STRING,
                'last_name' => Validator::VALIDATOR_STRING,
                'city' => Validator::VALIDATOR_STRING,
                'address' => Validator::VALIDATOR_STRING,
                'phone' => Validator::VALIDATOR_STRING,
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
            $customer->city = $request->json('city', '');
            $customer->address = $request->json('address', '');
            $customer->phone = $request->json('phone', '');
            $customer->save();
            $reservation = Reservation::build(
                $customer,
                $reservedAt,
                $request->json('nb_invites')
            );
            $reservation->occasion = $request->json('occasion');
            $reservation->save();
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
//        $data = $reservation->toArray();
//        $data['customer'] = $reservation->customer->toArray();
        return view('reservation_confirmation', ['reservation' => $reservation]);
    }
}
