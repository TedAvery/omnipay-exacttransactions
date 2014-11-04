<?php

namespace Omnipay\ExactTransactions\Message;

/**
 * E-xact Transactions SIM Purchase Request
 */
class SIMPurchaseRequest extends SIMAuthorizeRequest
{
    protected $action = 'PURCHASE_TOKEN';
}
