<?php

namespace Digkill\MediariseSberecomPayment;

class SberEcomService
{

    public function __construct(Config $config)
    {

    }

    public function getPayLink($orderId, $amount, $data = [], $returnUrl = null)
    {
        $resp = $this->client->request(
            'register',
            $data,
            __METHOD__
        );

        return [
            'orderId' => $orderId,
            'invoiceNum' => $order->invoice_num,
            'payLink' =>

                Arr::get($resp, 'formUrl'),
        ];
    }
}