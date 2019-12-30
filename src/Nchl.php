<?php
namespace YubarajShrestha\NCHL;
use Exception;
use Carbon\Carbon;
use YubarajShrestha\NCHL\Exceptions\NchlException;

class Nchl {

    /** @var string */
    protected $merchant_id;
    
    /** @var string */
    protected $app_id;

    /** @var string */
    protected $app_name;

    /** @var string */
    protected $txn_id;

    /** @var string */
    protected $txn_date;

    /** @var string */
    protected $txn_currency;

    /** @var string */
    protected $txn_amount;

    /** @var string */
    protected $reference_id;

    /** @var string */
    protected $remarks;

    /** @var string */
    protected $particulars;

    protected $config;
    
    public function __construct(array $data = []) {
        $config = config('nchl');
        foreach($config as $key => $conf) {
            $this->$key = $conf;
        }
        
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function create(array $data = []) {
        return new static($data);
    }

    public function merchant_id(string $merchant_id) {
        $this->merchant_id = $merchant_id;
        return $this;
    }

    public function app_id(string $app_id) {
        $this->app_id = $app_id;
        return $this;
    }
    
    public function app_name(string $app_name) {
        $this->app_name = $app_name;
        return $this;
    }

    public function txn_id(string $txn_id) {
        $this->txn_id = $txn_id;
        return $this;
    }
    
    public function txn_amount(string $txn_amount) {
        $this->txn_amount = $txn_amount;
        return $this;
    }
    
    public function txn_date(Carbon $txn_date) {
        $this->txn_date = $txn_date;
        return $this;
    }
    
    public function txn_currency(Carbon $txn_currency) {
        $this->txn_currency = $txn_currency;
        return $this;
    }

    public function reference_id(string $reference_id) {
        $this->reference_id = $reference_id;
        return $this;
    }
    
    public function remarks(string $remarks) {
        $this->remarks = $remarks;
        return $this;
    }
    
    public function particulars(string $particulars) {
        $this->particulars = $particulars;
        return $this;
    }

    public function token() {
        $message = "MERCHANTID={$this->merchant_id},APPID={$this->app_id},APPNAME={$this->app_name},TXNID=8024,TXNDATE=08-10-
        2017,TXNCRNCY={$this->txn_currency},TXNAMT=1000,REFERENCEID=1.2.4,REMARKS=123455,PARTICULARS=12
        345,TOKEN=TOKEN";

        return $message;
    }
    
    public function validate() {
        $requiredFields = ['merchant_id', 'app_id', 'app_name', 'txn_currency', 'txn_id', 'txn_date', 'txn_amount', 'reference_id', 'remarks', 'particulars'];
        foreach ($requiredFields as $requiredField) {
            if (empty($this->$requiredField)) {
                throw NchlException::missingField($this, $requiredField);
            }
        }
    }

    public function __get($key) {
        if (! isset($this->$key)) {
            throw new Exception("Property `{$key}` doesn't exist");
        }
        return $this->$key;
    }
}