<?php

namespace App\Http\Controllers;

use App\Exceptions\RestoError;
use App\Helpers\Date;
use App\Helpers\Validator;
use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Gestion extends Controller
{
    protected $validator;
    public $currStatus = -1;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function upcoming(Request $request)
    {
        $lastHour = (new \DateTime('today'))->modify('- 1 hour');
        $list = Reservation::where('reserved_at', '>', $lastHour)->get();
        return view('gestion_reservList', ['reservations' => $list]);
    }

    public function requests(Request $request)
    {
        $order_criteria = $request->input('sort');
        $lastOrder = $request->session()->get('sortorder', '');
        if (starts_with($lastOrder, '-')) {
            $order = 'desc';
            $lastOrder = substr($lastOrder, 1);
        } else {
            $order = 'asc';
        }

        if ($order_criteria != null) {
            if ($lastOrder == $order_criteria) {
                if ($order == 'asc') {
                    $lastOrder = '-' . $order_criteria;
                    $order = 'desc';
                } else {
                    $order = 'asc';
                }
            } else {
                $order = 'asc';
                $lastOrder = $order_criteria;
            }

            $request->session()->put('sortorder', $lastOrder);
        }

        $status = $request->input('status');
        if ($status == null) {
            $status = -1;
        }
        if ($status == -1) {
            $ds = Reservation::whereNotNull('status');
        } else {
            $ds = Reservation::where('status', '=', $status);
        }

        if ($order_criteria == null || $order_criteria == 'Periode' || $order_criteria == 'Time') {
            $list = $ds->orderBy('reserved_at', $order)->get();
        } else {
            if ($order_criteria == 'Nb places') {
                $list = $ds->orderBy('nb_invites', $order)->get();
            } else {
                $list = $ds->orderBy('reserved_at', $order)->get();
            }
        }

        $currStatus = $status;


        return view('gestion_requests', [
            'reservations' => $list,
            'currStatus' => $currStatus,
            'orderCriteria' => $order_criteria,
            'order' => $order
        ]);
    }
}
