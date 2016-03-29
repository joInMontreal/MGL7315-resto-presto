<?php

namespace App\Helpers;

use App\Exceptions\RestoError;
use Illuminate\Http\Request;

class Validator
{
    const VALIDATOR_STRING = 'string';
    const VALIDATOR_EMAIL = 'email';
    const VALIDATOR_NUMBER = 'number';
    const VALIDATOR_PHONE = 'phone';
    const VALIDATOR_DATETIME = 'datetime';

    public function validateRequest(Request $request, array $rules, array $translations)
    {
        foreach ($rules as $fieldName => $validator) {
            $value = $request->json($fieldName);
            $field = $translations[$fieldName];
            switch ($validator) {
                case self::VALIDATOR_STRING:
                    if (!is_string($value)) {
                        throw new RestoError("{$field} n'est pas du texte");
                    }
                    break;
                case self::VALIDATOR_EMAIL:
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        throw new RestoError("{$field} n'est pas un courriel valide");
                    }
                    break;
                case self::VALIDATOR_NUMBER:
                    if (!is_numeric($value)) {
                        throw new RestoError("{$field} n'est pas un nombre");
                    }
                    break;
                case self::VALIDATOR_PHONE:
                    if (!$this->validPhone2($value)) {
                        throw new RestoError("{$field} ($value) n'est pas un numéro de téléphone valide : 123-123-1234");
                    }
                    break;
                case self::VALIDATOR_DATETIME:
                    $date = \DateTime::createFromFormat('Y-m-d H:i', $value);
                    if (!$date) {
                        throw new RestoError("{$field} n'est pas une date valide");
                    }
                    break;
                default:
                    throw new RestoError('Validator inconnu!');
            }
        }
    }

    protected function validPhone($phone)
    {
        return (
            !preg_match("/^([1]-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$/i", $phone) &&
            !preg_match("/^([1]-)?[0-9]{3}.[0-9]{3}.[0-9]{4}$/i", $phone) &&
            !preg_match("/^([1]-)?\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/i", $phone) &&
            !preg_match("/^[0-9]{10}$/i", $phone))
            ? false
            : true;
    }

}
