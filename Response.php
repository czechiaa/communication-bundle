<?php

namespace Czechiaa\Bundle\CommunicationBundle;

use Czechiaa\Bundle\CommunicationBundle\Response\ContextResponse;
use Czechiaa\Bundle\CommunicationBundle\Response\OutputResponse;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;
use function array_key_exists;
use function array_merge;
use function func_get_args;
use function is_array;

/**
 * Class Response
 * @package Czechiaa\Bundle\CommunicationBundle
 */
class Response
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var null|string|object|array
     */
    private $data = [];

    /**
     * @var null|string|object|array
     */
    private $bridge;

    /**
     * @var int
     */
    private $code = SymfonyResponse::HTTP_OK;

    /**
     * Flusher constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param mixed $value
     * @param mixed $data
     * @param ContextResponse[]|ContextResponse|null $context
     * @return $this
     */
    public function add($value, $data = null, $context = null): self
    {
        $args = func_get_args();

        $k = $value;
        $v = $data;
        $c = $context;

        if ($data instanceof ContextResponse) {
            if ($context === null) {
                $k = null;
                $v = $value;
                $c = $data;
            }
        } elseif ($context instanceof ContextResponse) {
            $k = $value;
            $v = $data;
            $c = $context;
        } elseif (array_key_exists(0, $args) && array_key_exists(1, $args)) {
            [$k, $v] = $args;
        } else {
            $k = null;
            $v = $value;
        }

        $this->store($k, $v, $c);

        return $this;
    }

    /**
     * @param string|int|null $key
     * @param mixed $value
     * @param ContextResponse|null $context
     * @return void
     */
    private function store($key, $value, ?ContextResponse $context): void
    {
        $output = new OutputResponse($key, $value, $context);
        $data = $this->serialize($output);

        if ($output->getKey() === null) {
            $this->bridge = $data;
            return;
        }

        if (!is_array($this->bridge)) {
            $this->bridge = [];
        }
        $this->bridge[$output->getKey()] = $data;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function code(int $code = SymfonyResponse::HTTP_OK): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param Exception|Throwable $e
     * @return $this
     */
    public function exception(Exception $e): self
    {
        $this->bridge = null;
        $code = null;
        $data = [
            'code' => SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage()
        ];

        $data['errorMessage'] = $e->getMessage();
        if (null !== $prev = $e->getPrevious()) {
            $data['previousMessage'] = $prev->getMessage();
        }

        switch (true) {
            case $e instanceof HttpExceptionInterface:
                $code = $this->resolveStatusCode($e->getStatusCode());
                break;
            case method_exists($e, 'getCode'):
                $code = $this->resolveStatusCode($e->getCode());
                break;
        }

        if ($code !== null) {
            $data['code'] = $code;
            $this->code = $data['code'];
        }
        $this->data = $data;

        return $this;
    }

    /**
     * @param int $code
     * @return int|null
     */
    final protected function resolveStatusCode(int $code): ?int
    {
        return isset(SymfonyResponse::$statusTexts[$code]) ? $code : null;
    }

    /**
     * @param array $headers
     * @return array
     */
    private function mergeHeaders(array $headers = []): array
    {
        return array_merge(static::getDefaultHeaders(), $headers);
    }

    /**
     * @param OutputResponse $output
     * @return array|bool|float|int|mixed|string|null
     */
    private function serialize(OutputResponse $output)
    {
        $instance = $output->getContext();

        if ($instance === null) {
            return $output->getValue();
        }

        return $this->serializer->normalize($output->getValue(), $output->getFormat(), $instance->getContext());
    }

    /**
     * @param array $headers
     * @return JsonResponse
     */
    public function send(array $headers = []): JsonResponse
    {
        $headers = $this->mergeHeaders($headers);

        if ($this->bridge !== null) {
            return (new JsonResponse('', $this->code, $headers))->setData($this->bridge);
        }

        $data = $this->data;

        return new JsonResponse($data, $this->code, $headers);
    }

    /**
     * @param array $context
     * @return ContextResponse
     */
    public function context(array $context = []): ContextResponse
    {
        return new ContextResponse($context);
    }

    /**
     * @return array|string[]
     */
    public static function getDefaultHeaders(): array
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Credentials' => '*',
            'Access-Control-Allow-Headers' => 'x-requested-with, Content-Type, origin, authorization, accept, Sec-Fetch-Mode, user-agent',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS'
        ];
    }

    /**
     * @param mixed $bridge
     * @return void
     */
    final protected function setBridge($bridge): void
    {
        $this->bridge = $bridge;
    }

    /**
     * @param int $code
     * @return void
     */
    final protected function setCode(int $code): void
    {
        $this->code = $code;
    }
}
