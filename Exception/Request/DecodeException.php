<?php

namespace Czechiaa\Bundle\CommunicationBundle\Exception\Request;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class DecodeException
 * @package Czechiaa\Bundle\CommunicationBundle\Exception\Request
 */
class DecodeException extends Exception
{
    /**
     * DecodeException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', $code = Response::HTTP_BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $message
     * @param Throwable $previous
     * @return DecodeException
     */
    public static function create(string $message, Throwable $previous): DecodeException
    {
        return new self($message, Response::HTTP_BAD_REQUEST, $previous);
    }
}
