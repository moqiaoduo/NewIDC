<?php

namespace App\Exceptions;

use Exception;
use Lang;
use Throwable;

class ServiceCreateException extends Exception
{
    const NO_SERVER_AVAILABLE = 1;

    public function __construct($code = 0, $message = "", Throwable $previous = null)
    {
        if (Lang::has($code)) {
            $message = Lang::get($code);
        }
        parent::__construct($message, $code, $previous);
    }
}
