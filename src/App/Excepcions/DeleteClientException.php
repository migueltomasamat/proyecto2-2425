<?php

namespace App\Excepcions;

class DeleteClientException extends \Exception
{
    public function __construct(string $message = "Error al borrar el cliente", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}