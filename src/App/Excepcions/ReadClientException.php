<?php

namespace App\Excepcions;

class ReadClientException extends \Exception
{
    public function __construct(string $message = "No se ha encontrado el cliente en la base de datos", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}