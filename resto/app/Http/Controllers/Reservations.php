<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Http\Request;

class Reservations extends Controller
{
    public function showForm()
    {
        return view('reservation_form', ['users' => []]);
    }

    public function reserve(Request $request)
    {
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
            \DateTime::createFromFormat('Y-m-d H:i', $request->json('reserved_at')),
            $request->json('nb_invites')
        );
        $reservation->save();
        $response = $reservation->toArray();
        $response['customer'] = $customer->toArray();
        return response()->json($response);
    }

    public function single($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        $response = $reservation->toArray();
        $response['customer'] = $reservation->customer->toArray();
        return response()->json($response);
    }
}
