<?php

namespace Digkill\MediariseSberecomPayment;

use Digkill\MediariseSberecomPayment\Exceptions\SberException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Client
{
    private array $auth;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function request(string $endpoint, array $data, string $context = null): array
    {
        if (!key_exists($endpoint, $this->endpoints)) {
            throw new SberException("Эндпоинт: \'{$endpoint}\' не найден", ResponseAlias::HTTP_NOT_FOUND);
        }

        try {
           // Log::info($context ?? __METHOD__ . ' request to ' . $this->endpoints[$endpoint], $data);

            $resp = (new \GuzzleHttp\Client())
                ->request(
                    'POST',
                    $this->endpoints[$endpoint],
                    [
                        RequestOptions::JSON => array_merge($this->auth, $data),

                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'verify' => false,
                    ]
                );
            // dd($resp);

            $this->checkResponse($resp);
        } catch (Throwable $e) {



            $this->handleException($e, $context ?? __METHOD__);
        } finally {
            if (isset($resp)) {
                Log::info($context ?? __METHOD__ . ' response: ', [(string)$resp->getBody()]);
            }
        }


        return json_decode($resp->getBody(), true, 128, JSON_THROW_ON_ERROR | JSON_OBJECT_AS_ARRAY);
    }

    protected function checkResponse($response): void
    {
        if ($this->isEmptyResponse($response)) {
            $this->handleEmptyResponse($response);
        }
        if ($this->isErrorResponse($response)) {
            $this->handleErrorResponse($response);
        }
    }


    protected function handleErrorResponse($response): void
    {
        $e = json_decode($response->getBody(), JSON_OBJECT_AS_ARRAY, 512, JSON_THROW_ON_ERROR);
        throw (new SberException(
            sprintf(
                'Error response from remote sber api, errorMessage: \'%s\' code: \'%s\'',
                $e['errorMessage'],
                $e['errorCode']
            ),
            (int)$e['errorCode']
        ))->setResponse($response);
    }


    protected function handleEmptyResponse(ResponseInterface $response): void
    {
        throw (new SberException('Empty response from remote sber api'))
            ->setResponse($response);
    }


    protected function handleException(Throwable $e, string $method): void
    {
        if ($e instanceof SberException) {
            throw $e;
        }
        if ($e instanceof RequestException && $e->hasResponse()) {
            throw (new SberException(
                sprintf(
                    'SberDriver class: %s, method: %s, error: %s, code: %s',
                    __CLASS__,
                    $method,
                    $e->getMessage(),
                    $e->getCode()
                ),
                $e->getCode(),
                $e,
                $e->getResponse()
            ))->setResponse($e->getResponse());
        }
        throw new SberException(
            sprintf(
                'SberDriver class: %s, method: %s, error: %s, code: %s',
                __CLASS__,
                $method,
                $e->getMessage(),
                $e->getCode()
            ),
            $e->getCode(),
            $e
        );
    }

    private function isEmptyResponse(ResponseInterface $response): bool
    {
        return !$response->getBody()->getSize();
    }


    /**
     * @throws \JsonException
     */
    private function isErrorResponse($response): bool
    {
        $body = json_decode($response->getBody(), JSON_OBJECT_AS_ARRAY, 512, JSON_THROW_ON_ERROR);
        return key_exists(
                'errorCode',
                $body
            ) && (int)$body['errorCode'] > 0;
    }
}