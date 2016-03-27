<?php

namespace App\Exceptions;

class RestoError extends \Exception
{
    public function __construct($message, $code = 400)
    {
        parent::__construct($message, $code);
    }
}
