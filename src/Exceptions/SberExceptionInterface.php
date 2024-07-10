<?php

namespace Digkill\MediariseSberecomPayment\Exceptions;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Interface DriverExceptionInterface
 * @package App\Drivers\Exception
 */
interface SberExceptionInterface extends Throwable
{
    /**
     * @return int|null
     */
    public function serviceErrorCode() : ?int;

    /**
     * @return bool
     */
    public function isHttpException() : bool;

    /**
     * @return Throwable|null
     */
    public function getHttpException() : ?RequestException;

    /**
     * @return ResponseInterface|null
     */
    public function getErrorResponse() : ?ResponseInterface;
}
