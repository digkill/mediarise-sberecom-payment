<?php

namespace Digkill\MediariseSberecomPayment\Exceptions;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Exception;

/**
 * Class SberDriverException
 * @package App\Drivers\Exception
 */
class SberException extends Exception implements SberExceptionInterface
{
    /**
     * @var RequestException|null
     */
    private $httpException = null;

    /**
     * @var ResponseInterface|null
     */
    private $response = null;

    /**
     * SberDriverException constructor.
     * @param string $message
     * @param int $code
     * @param ResponseInterface|null $response
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, ResponseInterface $response = null)
    {
        parent::__construct($message, $code, $previous);
        if ($previous instanceof RequestException) {
            $this->httpException = $previous;
        }
        if (null !== $response && $response instanceof ResponseInterface) {
            $this->response = $response;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'Sber has error, message \'%s\', code: %s',
            $this->getMessage(),
            $this->getCode()
        );
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'message' => $this->getMessage(),
            'response' => [
                'body' => is_null($this->response) ? null : $this->response->getBody(),
                'headers' => is_null($this->response) ? null : $this->response->getHeaders(),
            ],
            'trace' => $this->getTrace(),
        ];
    }

    /**
     * @param ResponseInterface $response
     * @return $this
     */
    public function setResponse(ResponseInterface $response): self
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return int|null
     */
    public function serviceErrorCode(): ?int
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isHttpException(): bool
    {
        return null !== $this->httpException;
    }

    /**
     * @return Throwable|null
     */
    public function getHttpException(): ?RequestException
    {
        return $this->httpException;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getErrorResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
