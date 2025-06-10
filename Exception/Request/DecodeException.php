<?php

declare(strict_types=1);

namespace Czechiaa\Bundle\CommunicationBundle\Exception\Request;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DecodeException extends Exception
{
    public function __construct(string $message = '', int $code = Response::HTTP_BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function create(string $message, Throwable $previous): DecodeException
    {
        return new self($message, Response::HTTP_BAD_REQUEST, $previous);
    }
}
