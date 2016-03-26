<?php

namespace Tests\App\Models;

use App\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function testBuild()
    {
        $firstName = 'John';
        $lastName = 'Doe';
        $email = 'john@doe.com';

        $customer = Customer::build($firstName,$lastName,$email);

        $this->assertEquals($firstName, $customer->first_name);
        $this->assertEquals($lastName, $customer->last_name);
        $this->assertEquals($email, $customer->email);
    }
}
