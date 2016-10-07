<?php

namespace Nerd\Framework\Services;


use Nerd\Framework\Http\Response\JsonResponse;
use Nerd\Framework\Http\Response\PlainResponse;
use Nerd\Framework\Http\ResponseServiceContract;

class ResponseService implements ResponseServiceContract
{
    private $converters = [];

    public function on($type, callable $converter)
    {
        $this->converters[$type] = $converter;
    }

    public function convert($response)
    {
        if (is_scalar($response)) {
            return $this->convertScalar($response);
        }

        $converter = $this->findAppropriateConverter($response);

        return $converter($response);
    }

    private function convertScalar($scalar)
    {
        return new JsonResponse($scalar);
    }

    /**
     * @param $response
     * @return callable
     */
    private function findAppropriateConverter($response)
    {
        $class = get_class($response);
    }
}
