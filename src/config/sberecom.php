<?php

const VALIDITY_DAYS = 7;

return [
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
    'validityDay' => getenv('SBER_ECOM_VALIDITY', VALIDITY_DAYS),
    'isTest' => false,
];