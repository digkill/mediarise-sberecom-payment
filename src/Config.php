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

    /**
     * @throws Throwable
     */
    public function getCancelUrl(): string
    {
        $cancelUrl = $this->config['endpoints']['cancel'] ?? null;

        if ($cancelUrl === null) {
            throw new \Exception('Url cancel not set');
        }

        return $cancelUrl;
    }

    /**
     * @throws Throwable
     */
    public function getRefundUrl(): string
    {
        $refundUrl = $this->config['endpoints']['refund'] ?? null;

        if ($refundUrl === null) {
            throw new \Exception('Url refund not set');
        }

        return $refundUrl;
    }

    /**
     * @throws Throwable
     */
    public function getReceiptStatusUrl(): string
    {
        $receiptStatusUrl = $this->config['endpoints']['getReceiptStatus'] ?? null;

        if ($receiptStatusUrl === null) {
            throw new \Exception('Url receipt status not set');
        }

        return $receiptStatusUrl;
    }

    /**
     * @throws Throwable
     */
    public function getSuccessUrl(): string
    {
        $successUrl = $this->config['successUrl'] ?? null;

        if ($successUrl === null) {
            throw new \Exception('Url successUrl not set');
        }

        return $successUrl;
    }

    /**
     * @throws Throwable
     */
    public function getFailUrl(): string
    {
        $failUrl = $this->config['failUrl'] ?? null;

        if ($failUrl === null) {
            throw new \Exception('Url failUrl not set');
        }

        return $failUrl;
    }

    /**
     * @throws Throwable
     */
    public function getReturnUrl(): string
    {
        $returnUrl = $this->config['returnUrl'] ?? null;

        if ($returnUrl === null) {
            throw new \Exception('Url returnUrl not set');
        }

        return $returnUrl;
    }

    /**
     * @throws Throwable
     */
    public function getValidityDay(): string
    {
        $validityDay = $this->config['validityDay'] ?? null;

        if ($validityDay === null) {
            throw new \Exception('Url validityDay not set');
        }

        return $validityDay;
    }

    /**
     * @throws Throwable
     */
    public function isTest(): bool
    {
        return $this->config['endpoints']['isTest'] ?? false;
    }
}