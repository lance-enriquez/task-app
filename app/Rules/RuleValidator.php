<?php

namespace App\Rules;

use App\Libraries\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 *
 *
 *
 */
class RuleValidator
{

    public static function validation(Request $request, array $data = []): array
    {
        $validation = Validator::make($data, $request->rules(), $request->messages());
        $errorMessages = array_merge(...array_values($validation->errors()->messages()));
        $status = !(count($errorMessages) > 0);
        $message = (!$status) ? $errorMessages[0] : null;
        return Utility::getResponse($status, $message);
    }
}
