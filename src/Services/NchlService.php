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
        $token = $this->core->token($string);
        $client = new Client(['auth' => [$this->core->getAppId(), $this->core->getPassword()]]);

        try {
            $response = $client->post($this->core->validationUrl(), [
                'json' => [
                    'appId' => $this->core->getAppId(),
                    'txnAmt' => $this->core->getTxnAmount(),
                    'referenceId' => $this->core->getTxnId(),
                    'merchantId' => $this->core->getMerchantId(),
                    'token' => $token,
                ],
            ]);
            $body = $response->getBody();
            if ($body) {
                $body = json_decode($body);
            }

            return (object) [
                'message' => $body->statusDesc,
                'status' => $body->status === 'SUCCESS',
            ];
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
        $client = new Client(['auth' => [$this->core->getAppId(), $this->core->getPassword()]]);

        try {
            $response = $client->post($this->core->transactionDetailUrl(), [
                'json' => [
                    'appId' => $this->core->getAppId(),
                    'txnAmt' => $this->core->getTxnAmount(),
                    'referenceId' => $this->core->getTxnId(),
                    'merchantId' => $this->core->getMerchantId(),
                    'token' => $token,
                ],
            ]);
            $body = $response->getBody();
            if ($body) {
                $body = json_decode($body);
            }

            return (object) [
                'txnAmt' => $body->txnAmt,
                'txnId' => $body->txnId,
                'referenceId' => $body->referenceId,
                'txnDate' => $body->txnDate,
                'refId' => $body->refId,
                'chargeAmt' => $body->chargeAmt,
                'chargeLiability' => $body->chargeLiability,
                'creditStatus' => $body->creditStatus,
                'remarks' => $body->remarks,
                'message' => $body->statusDesc,
                'status' => $body->status === 'SUCCESS',
            ];
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
