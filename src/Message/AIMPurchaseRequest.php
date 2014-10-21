<?php

namespace Omnipay\ExactTransactions\Message;

/**
 * E-xact Transactions AIM Purchase Request
 */
class AIMPurchaseRequest extends AIMAuthorizeRequest
{
    protected $action = 'AUTH_CAPTURE';
}
