<?php

require __DIR__ . '/vendor/autoload.php';

use Digkill\MediariseSberecomPayment\Config;
use Digkill\MediariseSberecomPayment\SberEcomService;

$repository = Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()
    ->addAdapter(Dotenv\Repository\Adapter\EnvConstAdapter::class)
    ->addWriter(Dotenv\Repository\Adapter\PutenvAdapter::class)
    ->immutable()
    ->make();

$dotenv = Dotenv\Dotenv::create($repository, __DIR__);
$dotenv->load();

$config = new Config();
$sberService = new SberEcomService($config);

$payLink = $sberService->getPayLink('432432432432234342423', 100, [
    'email' => 'dsds@dsds.ru',
    'phone' => '+79224323543',
]);

var_dump($payLink);