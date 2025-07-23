<?php

namespace Triya\YandexPaySdk\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function __construct(public $message = "", public int $statusCode = 0, public string $response = "")
    {
        
    }
}
