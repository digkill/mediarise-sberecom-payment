<?php

namespace Digkill\MediariseSberecomPayment;

class Basket
{

    /**
     * @var Basket
     */
    protected Basket $order;


  public function buildRequest($data): array
    {
        return [
            'orderNumber' => (string)$this->order->invoice_num,
            'amount' => (int)$this->prepareSum($this->invoice->pay_amount),
            'returnUrl' => (string)$this->order->success_url,
            'email' => (string)$this->invoice->user->email,
            'orderBundle' => [
                'ffdVersion' => '1.05',
                'receiptType' => 'sell',
                'ismOptional' => false,
                'company' => [
                    'email' => '',
                    'sno' => 'osn',
                    'inn' => '',
                    'paymentAddress' => 'h',
                ],
                'payments' => [
                    [
                    'type' => 1,
                    'sum' => (int)$this->prepareSum($this->invoice->pay_amount),
                    ]
                ],
                'total' => (int)$this->prepareSum($this->invoice->pay_amount),
                'cartItems' => [
                    'items' => $this->prepareItem(),
                ],

            ],
        ];
    }

    /**
     * @param Invoice $item
     * @return array
     */
    protected function prepareItem(): array
    {

        $basket = [];
        $priceItems = $this->prepareItemsPrice($invoice->pay_amount, $this->invoice->lesson_number);

        $itemCode = 1;
        for ($i = 0; $i < $this->invoice->lesson_number; $i++) {
            $basket[] = [
                'positionId' => (string)$itemCode,
                'itemCode' => (string)$itemCode,
                'name' => "",
                'quantity' => [
                    'value' => 1,
                    'measure' => '0',
                ],
                'measurementUnit' => "",
                'itemPrice' => (int)$priceItems[$i],
                'itemAmount' => (int)$priceItems[$i],
                "paymentMethod" => "full_payment",
                "paymentObject" => "service",
                'tax' => [
                    'taxType' => 0,
                ],
            ];
            $itemCode++;
        }

        return $basket;
    }


}
