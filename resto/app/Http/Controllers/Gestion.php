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

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }
    
    public function upcoming()
    {
    	$lastHour = (new \DateTime('today'))->modify('- 1 hour');
    	$list = Reservation::where('reserved_at', '>', $lastHour)->get();
        return view('gestion_reservList', ['reservations' => $list]);
    }
    public function requests()
    {
    	$list = Reservation::all();
        return view('gestion_requests', ['reservations' => $list]);
    }

    public function getdata()
    {
    	$list = Reservation::where('status', '=', 0)->get();
        return $list->toJson();
    }

}
