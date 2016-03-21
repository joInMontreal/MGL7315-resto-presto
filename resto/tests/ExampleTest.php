<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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

        $user = new \App\User();
        $user->id = $id;
        $user->name = $name;

        $this->assertEquals($id, $user->id);
        $this->assertEquals($name, $user->name);
    }
}
