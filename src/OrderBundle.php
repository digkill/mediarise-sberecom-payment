<?php

namespace Digkill\MediariseSberecomPayment;

class OrderBundle
{
    private string $orderNumber = '';
    private int $amount = 0;
    private string $name = '';
    private int $quantityValue = 1;
    private string $quantityMeasure = 'шт';

    private string $measurementUnit = '';



    public function orderNumber(string $orderNumber): OrderBundle
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function orderAmount($amount): OrderBundle
    {
        $this->amount = $this->prepareSum($amount);
        return $this;
    }

    public function name(string $name): OrderBundle
    {
        $this->name = $name;
        return $this;
    }

    public function quantity(int $value, string $measure): OrderBundle
    {
        $this->quantityValue = $value;
        $this->quantityMeasure = $measure;
        return $this;
    }

    public function measurementUnit(string $measurementUnit): OrderBundle
    {
        $this->measurementUnit = $measurementUnit;
        return $this;
    }


    private function prepareSum($sum): int
    {
        return $sum * 100;
    }
}