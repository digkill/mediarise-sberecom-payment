<?php

namespace Digkill\MediariseSberecomPayment;

enum PaymentMethod: string
{
    case FULL_PREPAYMENT = 'full_prepayment';
    case PREPAYMENT = 'prepayment';
    case ADVANCE = 'advance';
    case FULL_PAYMENT = 'full_payment';
    case PARTIAL_PAYMENT = 'partial_payment';
    case CREDIT = 'credit';
    case CREDIT_PAYMENT = 'credit_payment';

}