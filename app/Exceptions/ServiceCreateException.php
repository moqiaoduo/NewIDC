<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ServiceCreateException extends Exception
{
    const NO_SERVER_AVAILABLE = 1;
    const UNSUPPORTED_PERIOD = 2;

    public function __construct($code = 0, $message = "", Throwable $previous = null)
    {
        \Lang::has($code);
        parent::__construct($message, $code, $previous);
    }
}
