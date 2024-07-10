<?php

namespace Digkill\MediariseSberecomPayment;

use App\Services\Sber\Exceptions\SberException;
use App\Services\Sber\RequestSberInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class RequestSber implements RequestSberInterface
{


    public function __construct(private readonly array $auth, private readonly array $endpoints)
    {
    }

    public function request(string $endpoint, array $data, string $context = null): array
    {
        if (!key_exists($endpoint, $this->endpoints)) {
            throw new SberException("Эндпоинт: \'{$endpoint}\' не найден", ResponseAlias::HTTP_NOT_FOUND);
        }

        try {
            Log::info($context ?? __METHOD__ . ' request to ' . $this->endpoints[$endpoint], $data);
            $resp = (new Client())
                ->post(
                    $this->endpoints[$endpoint],
                    ['form_params' => array_merge($this->auth, $data),
                        'verify' => false,
                    ]
                );
            if ($endpoint !== 'status') {
                $this->checkResponse($resp);
            }


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


    private function isErrorResponse($response): bool
    {
        $body = json_decode($response->getBody(), JSON_OBJECT_AS_ARRAY, 512, JSON_THROW_ON_ERROR);
        return key_exists(
                'errorCode',
                $body
            ) && (int)$body['errorCode'] > 0;
    }


}
