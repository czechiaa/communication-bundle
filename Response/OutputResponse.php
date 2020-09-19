<?php

namespace Czechiaa\Bundle\CommunicationBundle\Response;

/**
 * Class OutputResponse
 * @package Czechiaa\Bundle\CommunicationBundle\Response
 */
class OutputResponse
{
    /**
     * @var int|string|null
     */
    private $key;

    /**
     * @var string
     */
    private $format = '';

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var ContextResponse|null
     */
    private $context;

    /**
     * OutputResponse constructor.
     * @param int|string|null $key
     * @param mixed $value
     * @param ContextResponse|null $context
     */
    public function __construct($key, $value, ?ContextResponse $context)
    {
        $this->key = $key;
        $this->value = $value;
        $this->context = $context;
    }

    /**
     * @return int|string|null
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return ContextResponse|null
     */
    public function getContext(): ?ContextResponse
    {
        return $this->context;
    }
}
