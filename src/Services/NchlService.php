<?php

namespace YubarajShrestha\NCHL\Services;

use \GuzzleHttp\Client;
use Illuminate\Http\Request;
use YubarajShrestha\NCHL\Nchl;

class NchlService {

    private $nchl;

    public function __init(array $config) {
        $this->nchl = new Nchl($config);
        session()->flash('nchl', $this->nchl->__serialize());
        return $this;
    }

    public function dump() {
        dd('dumping something...');
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

    public function set(Request $request) {}

}
