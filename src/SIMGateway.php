<?php

namespace Omnipay\ExactTransactions;

use Omnipay\ExactTransactions\Message\SIMAuthorizeRequest;
use Omnipay\ExactTransactions\Message\SIMCompleteAuthorizeRequest;

/**
 * E-xact Transactions SIM Class
 */
class SIMGateway extends AIMGateway
{
    public function getName()
    {
        return 'E-xact Transactions SIM';
    }

    public function getDefaultParameters()
    {
        $parameters = parent::getDefaultParameters();
        $parameters['hashSecret'] = '';

        return $parameters;
    }

    public function getHashSecret()
    {
        return $this->getParameter('hashSecret');
    }

    public function setHashSecret($value)
    {
        return $this->setParameter('hashSecret', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ExactTransactions\Message\SIMAuthorizeRequest', $parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ExactTransactions\Message\SIMCompleteAuthorizeRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ExactTransactions\Message\SIMPurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->completeAuthorize($parameters);
    }
}
