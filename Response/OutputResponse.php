<?php

declare(strict_types=1);

namespace Czechiaa\Bundle\CommunicationBundle\Response;

readonly class OutputResponse
{
    public function __construct(
        private int|string|null  $key,
        private mixed            $value,
        private ?ContextResponse $context,
        private string           $format = ''
    ) {
    }

    public function getKey(): int|string|null
    {
        return $this->key;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getContext(): ?ContextResponse
    {
        return $this->context;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
