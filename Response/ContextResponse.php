<?php

declare(strict_types=1);

namespace Czechiaa\Bundle\CommunicationBundle\Response;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use InvalidArgumentException;

use function is_string;
use function is_array;

class ContextResponse
{
    /**
     * @var string[]
     */
    private array $context;

    /**
     * @var string[]
     */
    private array $dateTimeContext = [];

    public function __construct(array $context = [])
    {
        if (empty($context)) {
            $context = static::getDefaultContext();
        }
        $this->context = $context;
    }

    /**
     * @param string[]|string $groups
     * @return $this
     */
    public function groups(string|array $groups): self
    {
        if (!is_array($groups)) {
            $groups = (array)$groups;
        }
        $this->context['groups'] = $groups;

        return $this;
    }

    /**
     * @param string|string[] $groups
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function dateTimeContext(string|array $groups): self
    {
        if (!is_string($groups) && !is_array($groups)) {
            throw new InvalidArgumentException('Invalid date time context (groups).');
        }

        $groups = (array)$groups;
        $this->dateTimeContext = $groups;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @return string[]
     */
    public function getDateTimeContext(): array
    {
        return $this->dateTimeContext;
    }

    /**
     * @return array
     */
    public static function getDefaultContext(): array
    {
        return [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($entity, $format, $context) {
                return $entity->getId();
            }
        ];
    }
}
