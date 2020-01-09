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
     * @param array $config
     *
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
        /*$client = new Client();
        $res = $client->request('GET', 'https://api.github.com/user', [
            'auth' => ['companion.krish@outlook.com', 'Axelingit9@4!']
        ]);
        echo $res->getStatusCode();
        echo $res->getHeader('content-type')[0];
        echo $res->getBody();*/
    }

    /**
     * @throws NchlException
     */
    public function paymentValidate()
    {
        $string = "MERCHANTID={$this->core->getMerchantId()},APPID={$this->core->getAppId()},APPNAME={$this->core->getAppName()},TXNID={$this->core->getTxnId()},TXNAMT={$this->core->getTxnAmount()}";
        $token = $this->core->token($string);
        $client = new Client();

        try {
            $response = $client->request('POST', $this->core->getValidationUrl(), [
                'auth' => [$this->core->getAppId(), $this->core->getPassword()],
                'json' => [
                    'merchantId'    => $this->core->getMerchantId(),
                    'appId'         => $this->core->getAppId(),
                    'referenceId'   => $this->core->getTxnId(),
                    'txnAmt'        => $this->core->getTxnAmount(),
                    'token'         => $token,
                ],
            ]);
            // TODO: Handle Payment Validation Response
        } catch (ClientException $e) {
            $message = $e->getResponse()->getReasonPhrase();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 404) {
                $message = 'The requested url not found!';
            }

            throw NchlException::clientError($this, $message);
        }
    }

    /**
     * @throws NchlException
     */
    public function paymentDetails()
    {
        $string = "MERCHANTID={$this->core->getMerchantId()},APPID={$this->core->getAppId()},APPNAME={$this->core->getAppName()},TXNID={$this->core->getTxnId()},TXNAMT={$this->core->getTxnAmount()}";
        $token = $this->core->token($string);
        $client = new Client();

        try {
            $response = $client->request('POST', $this->core->getTransactionDetailUrl(), [
                'auth' => [$this->core->getAppId(), $this->core->getPassword()],
                'json' => [
                    'merchantId'    => $this->core->getMerchantId(),
                    'appId'         => $this->core->getAppId(),
                    'referenceId'   => $this->core->getTxnId(),
                    'txnAmt'        => $this->core->getTxnAmount(),
                    'token'         => $token,
                ],
            ]);
            // TODO: Handle Transaction Detail Response
        } catch (ClientException $e) {
            $message = $e->getResponse()->getReasonPhrase();
            $code = $e->getResponse()->getStatusCode();
            if ($code == 404) {
                $message = 'The requested url not found!';
            }

            throw NchlException::clientError($this, $message);
        }
    }
}
