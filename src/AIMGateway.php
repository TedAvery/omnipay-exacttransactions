<?php

namespace Omnipay\ExactTransactions;

use Omnipay\ExactTransactions\Message\AIMAuthorizeRequest;
use Omnipay\ExactTransactions\Message\AIMPurchaseRequest;
use Omnipay\ExactTransactions\Message\CaptureRequest;
use Omnipay\Common\AbstractGateway;

/**
 * E-xact Transactions AIM Class
 */
class AIMGateway extends AbstractGateway
{
    public function getName()
    {
        return 'E-xact Transactions AIM';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiLoginId' => '',
            'transactionKey' => '',
            'testMode' => false,
            'developerMode' => false,
        );
    }

    public function getApiLoginId()
    {
        return $this->getParameter('apiLoginId');
    }

    public function setApiLoginId($value)
    {
        return $this->setParameter('apiLoginId', $value);
    }

    public function getTransactionKey()
    {
        return $this->getParameter('transactionKey');
    }

    public function setTransactionKey($value)
    {
        return $this->setParameter('transactionKey', $value);
    }

    public function getDeveloperMode()
    {
        return $this->getParameter('developerMode');
    }

    public function setDeveloperMode($value)
    {
        return $this->setParameter('developerMode', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ExactTransactions\Message\AIMAuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ExactTransactions\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ExactTransactions\Message\AIMPurchaseRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ExactTransactions\Message\AIMVoidRequest', $parameters);
    }
}
