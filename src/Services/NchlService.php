<?php

namespace YubarajShrestha\NCHL\Services;

use \GuzzleHttp\Client;
use Illuminate\Http\Request;
use YubarajShrestha\NCHL\Nchl;

class NchlService {

    public function dump() {
        dd('dumping something...');
    }

    private function generateHash(array $params = []) {
        // $validatedData = request()->validate([
        //     'txn_id' => 'required',
        //     'txn_currency' => 'required',
        //     'txn_amount' => 'required',
        //     'reference_id' => 'required',
        //     'remarks' => 'required',
        //     'particulars' => 'required',
        //     'token' => 'required'
        // ]);

        $nchl = new Nchl([
            'txn_id' => 'required',
            'txn_date' => 'required',
            'txn_amount' => 'required',
            'reference_id' => 'required',
            'remarks' => 'required',
            // 'particulars' => 'required',
            'token' => 'required'
        ]);

        $nchl->validate();

        dd($nchl->token());

        // $message = "MERCHANTID={$nchl['merchant']},APPID={$nchl['app-id']},APPNAME={$nchl['app-name']},TXNID=8024,TXNDATE=08-10-
        // 2017,TXNCRNCY={$nchl['currency']},TXNAMT=1000,REFERENCEID=1.2.4,REMARKS=123455,PARTICULARS=12
        // 345,TOKEN=TOKEN";
        // $token = hash("md5", $message);
        // dd($token);
    }

    public function get() {
        return $this->generateHash();
        $client = new Client();
        $res = $client->request('GET', 'https://api.github.com/user', [
            'auth' => ['companion.krish@outlook.com', 'Axelingit9@4!']
        ]);

        echo $res->getStatusCode();
        echo $res->getHeader('content-type')[0];
        echo $res->getBody();
    }

    public function set(Request $request) {}

}