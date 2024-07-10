<?php

namespace Digkill\MediariseSberecomPayment;

use Throwable;

class Config
{
    const VALIDITY_DAYS = 7;

    private array $config;

    public function __construct()
    {
        $this->config = [
            'authInfo' => [
                'userName' => getenv('SBER_ECOM_API_USERNAME', ''),
                'password' => getenv('SBER_ECOM_API_PASSWORD', ''),
            ],
            'endpoints' => [
                'restUrl' => rtrim(getenv('SBER_ECOM_URL', 'https://ecommerce.sberbank.ru/ecomm/gw/partner/api/v1'), '/'),
                'register' => rtrim(getenv('SBER_ECOM_URL', 'https://ecommerce.sberbank.ru/ecomm/gw/partner/api/v1'), '/') . '/register.do',
                'status' => rtrim(getenv('SBER_ECOM_URL', 'https://ecommerce.sberbank.ru/ecomm/gw/partner/api/v1'), '/') . '/getOrderStatusExtended.do',
                'cancel' => rtrim(getenv('SBER_ECOM_URL', 'https://ecommerce.sberbank.ru/ecomm/gw/partner/api/v1'), '/') . '/reverse.do',
                'refund' => rtrim(getenv('SBER_ECOM_URL', 'https://ecommerce.sberbank.ru/ecomm/gw/partner/api/v1'), '/') . '/refund.do',
                'getReceiptStatus' => rtrim(getenv('REST_SBER_ECOM_OFD_URL', 'https://ecommerce.sberbank.ru/ecomm/gw/partner/api/ofd/v1'), '/') . '/getReceiptStatus',
            ],
            'successUrl' => getenv('SUCCESS_URL', ''),
            'failUrl' => getenv('FAIL_URL', ''),
            'returnUrl' => getenv('RETURN_URL', ''),
            'validityDay' => getenv('SBER_ECOM_VALIDITY', self::VALIDITY_DAYS),
            'isTest' => false,
        ];
    }

    public function getAuthInfo()
    {

        $authInfo = $this->config['authInfo'] ?? null;

        if ($authInfo === null) {
            throw new \Exception('AuthInfo not set');
        }

        return $authInfo;
    }

    /**
     * @throws Throwable
     */
    public function getRegister(): string
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
    public function getStatus(): string
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
    public function getCancel(): string
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
    public function getRefund(): string
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
    public function getReceiptStatus(): string
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