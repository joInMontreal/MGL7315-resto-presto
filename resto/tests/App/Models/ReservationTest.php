<?php

namespace Tests\App\Models;

use App\Models\Customer;
use App\Models\Reservation;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    public function testBuild()
    {
        $date = new \DateTime();
        $nbInvites = 12;

        $customer = new Customer();
        $customer->id = 123;

        $reservation = Reservation::build($customer, $date, $nbInvites);

        $this->assertEquals($customer->id, $reservation->customer_id);
        $this->assertEquals($date, $reservation->reserved_at);
        $this->assertEquals($nbInvites, $reservation->nb_invites);
    }
}
