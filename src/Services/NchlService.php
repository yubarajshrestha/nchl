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
    public $nchl;

    /**
     * NchlService constructor.
     */
    public function __construct()
    {
        $this->nchl = new Nchl();
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    public function __init(array $config)
    {
        $this->nchl = new Nchl($config);
//        session()->flash('nchl', $this->nchl->__serialize());
        return $this;
    }

    /**
     * @throws NchlException
     *
     * @return string
     */
    public function token()
    {
        return $this->nchl->token();
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
        $string = "MERCHANTID={$this->nchl->getMerchantId()},APPID={$this->nchl->getAppId()},APPNAME={$this->nchl->getAppName()},TXNID={$this->nchl->getTxnId()},TXNAMT={$this->nchl->getTxnAmount()}";
        $token = $this->nchl->token($string);
        $client = new Client();

        try {
            $response = $client->request('POST', $this->nchl->getValidationUrl(), [
                'auth' => [$this->nchl->getAppId(), $this->nchl->getPassword()],
                'json' => [
                    'merchantId'    => $this->nchl->getMerchantId(),
                    'appId'         => $this->nchl->getAppId(),
                    'referenceId'   => $this->nchl->getTxnId(),
                    'txnAmt'        => $this->nchl->getTxnAmount(),
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
        $string = "MERCHANTID={$this->nchl->getMerchantId()},APPID={$this->nchl->getAppId()},APPNAME={$this->nchl->getAppName()},TXNID={$this->nchl->getTxnId()},TXNAMT={$this->nchl->getTxnAmount()}";
        $token = $this->nchl->token($string);
        $client = new Client();

        try {
            $response = $client->request('POST', $this->nchl->getTransactionDetailUrl(), [
                'auth' => [$this->nchl->getAppId(), $this->nchl->getPassword()],
                'json' => [
                    'merchantId'    => $this->nchl->getMerchantId(),
                    'appId'         => $this->nchl->getAppId(),
                    'referenceId'   => $this->nchl->getTxnId(),
                    'txnAmt'        => $this->nchl->getTxnAmount(),
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
