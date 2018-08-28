<?php

namespace App\Exceptions;

use Exception;

class ExceptionBase extends Exception
{

    protected $code;
    protected $payload;

    public function __construct($code = 400, $message = null, $payload = [])
    {
        $exceptions    = config('exceptions');
        $exceptions    = $exceptions[get_called_class()] ?? [];
        $this->payload = $payload;

        parent::__construct($message, $this->code);
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}
