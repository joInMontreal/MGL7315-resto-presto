<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'email',
        'phone',
    ];

    public static function build($firstName, $lastName, $email)
    {
        return new self([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
        ]);
    }
}
