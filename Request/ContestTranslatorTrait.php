<?php

namespace Czechiaa\Bundle\CommunicationBundle\Request;

use Czechiaa\Bundle\CommunicationBundle\Exception\Request\DecodeException;
use JsonException;
use Symfony\Component\HttpFoundation\ParameterBag;
use function json_decode;

/**
 * Trait ContestTranslatorTrait
 * @package Czechiaa\Bundle\CommunicationBundle\Request
 */
trait ContestTranslatorTrait
{
    /**
     * @param mixed $contest
     * @return ParameterBag
     *
     * @throws DecodeException
     */
    protected function parameterBagFromContest($contest): ParameterBag
    {
        $bag = new ParameterBag();

        if (!$contest) {
            return $bag;
        }

        try {
            $content = json_decode($contest, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw DecodeException::create('Json decode exception', $e);
        }

        $bag->add($content);

        return $bag;
    }
}
