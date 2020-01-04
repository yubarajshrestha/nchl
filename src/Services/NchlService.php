<?php

namespace YubarajShrestha\NCHL\Services;

use \GuzzleHttp\Client;
use Illuminate\Http\Request;
use YubarajShrestha\NCHL\Nchl;

class NchlService {

    public $nchl;

    public function __init(array $config) {
        $this->nchl = new Nchl($config);
//        session()->flash('nchl', $this->nchl->__serialize());
        return $this;
    }

    public function token() {
        return $this->nchl->token();
        $client = new Client();
        $res = $client->request('GET', 'https://api.github.com/user', [
            'auth' => ['companion.krish@outlook.com', 'Axelingit9@4!']
        ]);

        echo $res->getStatusCode();
        echo $res->getHeader('content-type')[0];
        echo $res->getBody();
    }

    public function paymentValidate() {
        $string = "MERCHANTID={$this->nchl->getMerchantId()},APPID={$this->nchl->getAppId()},APPNAME={$this->nchl->getAppName()},TXNID={$this->nchl->getTxnId()},TXNAMT={$this->nchl->getTxnAmount()}";
        $token = $this->nchl->token($string);
        $client = new Client();
        $res = $client->request('POST', 'https://www.connectips.com/connectipswebws/api/creditor/validatetxn', [
            'auth' => [$this->nchl->getAppId(), $this->nchl->getPassword()],
            'json' => [
                'name' => 'Yubaraj Shrestha',
                'token' => $token
            ]
        ]);
        return $res->getBody();
    }

    public function paymentDetail() {
        $string = "MERCHANTID={$this->nchl->getMerchantId()},APPID={$this->nchl->getAppId()},APPNAME={$this->nchl->getAppName()},TXNID={$this->nchl->getTxnId()},TXNAMT={$this->nchl->getTxnAmount()}";
        $token = $this->nchl->token($string);
        $client = new Client();
        $res = $client->request('POST', 'https://www.connectips.com/connectipswebws/api/creditor/gettxndetail', [
            'auth' => [$this->nchl->getAppId(), $this->nchl->getPassword()],
            'json' => [
                'name' => 'Yubaraj Shrestha',
                'token' => $token
            ]
        ]);
        return $res->getBody();
    }

    public function set(Request $request) {}

}
