<?php

namespace Tests;

use App\User;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $name = "John Doe";
        $id = 1;

        $user = new User();
        $user->id = $id;
        $user->name = $name;

        $this->assertEquals($id, $user->id);
        $this->assertEquals($name, $user->name);
    }
}
