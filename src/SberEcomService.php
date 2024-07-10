<?php

namespace Digkill\MediariseSberecomPayment;

class SberEcomService
{
    protected Config $config;
    protected Client $client;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new Client($config);
    }

    public function getPayLink($orderId, $amount, $data = [], $returnUrl = null)
    {
        $data['orderNumber'] = $orderId;
        $data['amount'] = $amount;
        $data['returnUrl'] = $returnUrl ?? $this->config->getReturnUrl();


        $resp = $this->client->request(
            'register',
            $data,
            __METHOD__
        );

        return [
            'orderId' => $orderId,
            'payLink' => $resp['formUrl'],
        ];
    }
}