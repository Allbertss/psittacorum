<?php

namespace allbertss\psittacorum\Http\exception;

class HttpException extends \Exception
{
    private int $statusCode = 400;

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return HttpException
     */
    public function setStatusCode(int $statusCode): HttpException
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}