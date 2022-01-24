<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InfraException extends Exception
{
    public function __construct(string $message = "Infra Exception",
                                int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
                                ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
