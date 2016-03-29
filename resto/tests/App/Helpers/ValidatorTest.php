<?php

namespace Tests\App\Helpers;

use App\Helpers\Validator;
use Illuminate\Http\Request;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    public function validPhoneNumbers()
    {
        return [
            ['5141214433'],
            ['514-222-1111'],
            ['3232221111'],
        ];
    }

    /**
     * @dataProvider validPhoneNumbers
     */
    public function testValidPhoneNumber($phoneNumber)
    {
        $validator = new Validator();

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->expects($this->any())
            ->method('json')
            ->willReturn($phoneNumber);

        $validator->validateRequest(
            $request,
            ['test' => Validator::VALIDATOR_PHONE],
            ['test' => 'Test']
        );
    }

    public function invalidPhoneNumbers()
    {
        return [
            ['test'],
            ['15141214433'],
            ['5142-2222-11211'],
            ['1113232221111'],
            ['(+1) 432 432 3222'],
        ];
    }

    /**
     * @dataProvider invalidPhoneNumbers
     * @expectedException \App\Exceptions\RestoError
     */
    public function testInvalidPhoneNumber($phoneNumber)
    {
        $validator = new Validator();

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->expects($this->any())
            ->method('json')
            ->willReturn($phoneNumber);

        $validator->validateRequest(
            $request,
            ['test' => Validator::VALIDATOR_PHONE],
            ['test' => 'Test']
        );
    }
}
