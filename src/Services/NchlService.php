<?php

namespace YubarajShrestha\NCHL\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use YubarajShrestha\NCHL\Exceptions\NchlException;
use YubarajShrestha\NCHL\Nchl;

class NchlService
{
    /**
     * @var Nchl
     */
    public $core;

    /**
     * NchlService constructor.
     */
    public function __construct()
    {
        $this->core = new Nchl();
    }

    /**
     * @return $this
     */
    public function __init(array $config)
    {
        $this->core = new Nchl($config);

        return $this;
    }

    /**
     * @throws NchlException
     *
     * @return string
     */
    public function token()
    {
        return $this->core->token();
    }

    /**
     * @throws NchlException
     */
    public function paymentValidate()
    {
        $string = "MERCHANTID={$this->core->getMerchantId()},APPID={$this->core->getAppId()},REFERENCEID={$this->core->getTxnId()},TXNAMT={$this->core->getTxnAmount()}";
        // $string = "MERCHANTID={$this->core->getMerchantId()},APPID={$this->core->getAppId()},REFERENCEID={$this->core->getTxnId()},TXNAMT={$this->core->getTxnAmount()},TOKEN=TOKEN";
        $token = $this->core->token($string);
        $client = new Client();

        try {
            $response = $client->request('POST', $this->core->validationUrl(), [
                'auth' => [$this->core->getAppId(), $this->core->getPassword()],
                'form_params' => [
                    'merchantId' => $this->core->getMerchantId(),
                    'appId' => $this->core->getAppId(),
                    'referenceId' => $this->core->getTxnId(),
                    'txnAmt' => $this->core->getTxnAmount(),
                    'token' => $token,
                ],
            ]);

            return $response->getBody();
            // TODO: Handle Payment Validation Response
        } catch (ClientException $e) {
            $message = $e->getResponse()->getReasonPhrase();
            $code = $e->getResponse()->getStatusCode();
            if (404 === $code) {
                $message = 'The requested url not found!';
            } elseif (401 === $code) {
                $message = 'Session expired!';
            }

            throw NchlException::clientError($this, $message);
        }
    }

    /**
     * @throws NchlException
     */
    public function paymentDetails()
    {
        $string = "MERCHANTID={$this->core->getMerchantId()},APPID={$this->core->getAppId()},REFERENCEID={$this->core->getTxnId()},TXNAMT={$this->core->getTxnAmount()}";
        $token = $this->core->token($string);
        $client = new Client();

        try {
            $response = $client->request('POST', $this->core->getTransactionDetailUrl(), [
                'auth' => [$this->core->getAppId(), $this->core->getPassword()],
                'form_params' => [
                    'merchantId' => $this->core->getMerchantId(),
                    'appId' => $this->core->getAppId(),
                    'referenceId' => $this->core->getTxnId(),
                    'txnAmt' => $this->core->getTxnAmount(),
                    'token' => $token,
                ],
            ]);

            return $response->getBody();
            // TODO: Handle Transaction Detail Response
        } catch (ClientException $e) {
            $message = $e->getResponse()->getReasonPhrase();
            $code = $e->getResponse()->getStatusCode();
            if (404 === $code) {
                $message = 'The requested url not found!';
            } elseif (401 === $code) {
                $message = 'Session expired!';
            }

            throw NchlException::clientError($this, $message);
        }
    }
}
