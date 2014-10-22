<?php

namespace Omnipay\ExactTransactions\Message;

/**
 * E-xact Transactions Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://checkout.e­-xact.com/payment';
    protected $developerEndpoint = 'https://rpm.demo.e-xact.com/payment';

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

    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }

    public function getHashSecret()
    {
        return $this->getParameter('hashSecret');
    }

    public function setHashSecret($value)
    {
        return $this->setParameter('hashSecret', $value);
    }

    public function getTax()
    {
        $tax = $this->getParameter('tax');
        if ($tax) {
            if (!is_float($tax) &&
                $this->getCurrencyDecimalPlaces() > 0 &&
                false === strpos((string) $tax, '.')) {
                throw new InvalidRequestException(
                    'Please specify tax as a string or float, ' .
                    'with decimal places (e.g. \'10.00\' to represent $10.00).'
                );
            }

            return $this->formatCurrency($tax);
        }
    }

    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
    }

    public function getTaxInteger()
    {
        return (int) round($this->getTax() * $this->getCurrencyDecimalFactor());
    }

    public function getSubtotal()
    {
        $subtotal = $this->getParameter('subtotal');
        if ($subtotal) {
            if (!is_float($subtotal) &&
                $this->getCurrencyDecimalPlaces() > 0 &&
                false === strpos((string) $subtotal, '.')) {
                throw new InvalidRequestException(
                    'Please specify subtotal as a string or float, ' .
                    'with decimal places (e.g. \'10.00\' to represent $10.00).'
                );
            }

            return $this->formatCurrency($subtotal);
        }
    }

    public function setSubtotal($value)
    {
        return $this->setParameter('subtotal', $value);
    }

    public function getSubtotalInteger()
    {
        return (int) round($this->getSubtotal() * $this->getCurrencyDecimalFactor());
    }

    protected function getBaseData()
    {
        $data = array();
        $data['x_login'] = $this->getApiLoginId();
        $data['x_tran_key'] = $this->getTransactionKey();
        $data['x_type'] = $this->action;
        $data['x_version'] = '3.1';
        $data['x_delim_data'] = 'TRUE';
        $data['x_delim_char'] = ',';
        $data['x_encap_char'] = '|';
        $data['x_relay_response'] = 'FALSE';

        return $data;
    }

    protected function getBillingData()
    {
        $data = array();
        $data['x_amount'] = $this->getAmount();
        $data['x_tax'] = $this->getTax();
        $data['x_invoice_num'] = $this->getTransactionId();
        $data['x_description'] = $this->getDescription();
        $data['x_line_item'] = implode('<|>', array(
          '1',
          $this->getDescription(),
          $this->getDescription(),
          '1',
          $this->getSubtotal(),
          'YES',
          )
        );

        if ($card = $this->getCard()) {
            // customer billing details
            $data['x_first_name'] = $card->getBillingFirstName();
            $data['x_last_name'] = $card->getBillingLastName();
            $data['x_company'] = $card->getBillingCompany();
            $data['x_address'] = trim(
                $card->getBillingAddress1()." \n".
                $card->getBillingAddress2()
            );
            $data['x_city'] = $card->getBillingCity();
            $data['x_state'] = $card->getBillingState();
            $data['x_zip'] = $card->getBillingPostcode();
            $data['x_country'] = $card->getBillingCountry();
            $data['x_phone'] = $card->getBillingPhone();
            $data['x_email'] = $card->getEmail();

            // customer shipping details
            $data['x_ship_to_first_name'] = $card->getShippingFirstName();
            $data['x_ship_to_last_name'] = $card->getShippingLastName();
            $data['x_ship_to_company'] = $card->getShippingCompany();
            $data['x_ship_to_address'] = trim(
                $card->getShippingAddress1()." \n".
                $card->getShippingAddress2()
            );
            $data['x_ship_to_city'] = $card->getShippingCity();
            $data['x_ship_to_state'] = $card->getShippingState();
            $data['x_ship_to_zip'] = $card->getShippingPostcode();
            $data['x_ship_to_country'] = $card->getShippingCountry();
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, $data)->send();

        return $this->response = new AIMResponse($this, $httpResponse->getBody());
    }

    public function getEndpoint()
    {
        return $this->getDeveloperMode() ? $this->developerEndpoint : $this->liveEndpoint;
    }
}
