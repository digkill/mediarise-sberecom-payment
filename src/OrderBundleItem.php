<?php

namespace Digkill\MediariseSberecomPayment;

class OrderBundleItem
{
    private string $orderNumber = '';
    private int $amount = 0;
    private string $name = '';
    private int $quantityValue = 1;
    private string $quantityMeasure = 'шт';
    private string $measurementUnit = '';

    private int $itemPrice = 0;
    private int $itemAmount = 0;

    private string $paymentMethod = PaymentMethod::FULL_PAYMENT->value;

    private string $paymentObject = '';

    private int $taxType = 0;



    public function orderNumber(string $orderNumber): OrderBundleItem
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function orderAmount($amount): OrderBundleItem
    {
        $this->amount = $this->prepareSum($amount);
        return $this;
    }

    public function name(string $name): OrderBundleItem
    {
        $this->name = $name;
        return $this;
    }

    public function quantity(int $value, string $measure): OrderBundleItem
    {
        $this->quantityValue = $value;
        $this->quantityMeasure = $measure;
        return $this;
    }

    public function measurementUnit(string $measurementUnit): OrderBundleItem
    {
        $this->measurementUnit = $measurementUnit;
        return $this;
    }


    private function prepareSum($sum): int
    {
        return $sum * 100;
    }
}