<?php

namespace Digkill\MediariseSberecomPayment;

use Throwable;

class Config
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws Throwable
     */
    public function getRegisterUrl(): string
    {
        $registerUrl = $this->config['endpoints']['register'] ?? null;

        if ($registerUrl === null) {
            throw new \Exception('Url register not set');
        }

        return $registerUrl;
    }

    /**
     * @throws Throwable
     */
    public function getStatusUrl(): string
    {
        $statusUrl = $this->config['endpoints']['status'] ?? null;

        if ($statusUrl === null) {
            throw new \Exception('Url status not set');
        }

        return $statusUrl;
    }

}