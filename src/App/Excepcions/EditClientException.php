<?php

namespace App\Excepcions;

class EditClientException extends \Exception
{
    public function __construct(string $message = "Error al editar el cliente", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}