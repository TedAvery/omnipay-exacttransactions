<?php

namespace Omnipay\ExactTransactions\Message;

/**
 * E-xact Transactions AIM Void Request
 */
class AIMVoidRequest extends AbstractRequest
{
    protected $action = 'VOID';

    public function getData()
    {
        $this->validate('transactionReference');

        $data = $this->getBaseData();
        $data['x_trans_id'] = $this->getTransactionReference();

        return $data;
    }
}
