<?php

namespace App\Helper;

use App\Models\Error;

use Exception;
use Request;

class CustomException
{

    public static function onError(Exception $e)
    {

        $data = [
            'path' => $e->getFile(),
            'line' => $e->getLine(),
            'error' => $e->getMessage(),
        ];

        Error::create($data);

    }

}