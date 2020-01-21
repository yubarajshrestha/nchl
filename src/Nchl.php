<?php

namespace YubarajShrestha\NCHL;

use Illuminate\Support\Facades\Storage;
use YubarajShrestha\NCHL\Exceptions\NchlException;

class Nchl
{
    /** @var string */
    protected $merchant_id;

    /** @var string */
    protected $app_id;

    /** @var string */
    protected $app_name;

    /** @var string */
    protected $password;

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

    protected $certificate;

    public function __construct(array $data = [])
    {
        $this->update($data);
    }

    public function __serialize(): array
    {
        $array = get_object_vars($this);
        $array['token'] = $this->token();
        session(['nchl' => $array]);
        unset($array['certificate']);

        return $array;
    }

    /**
     * @param $key
     *
     * @throws NchlException
     */
    public function __get($key)
    {
        throw NchlException::propertyMissing($this, "Unable to access property: `{$key}`");
    }

    /**
     * Get NCHL merchant id.
     */
    public function getMerchantId(): string
    {
        return $this->merchant_id;
    }

    public function setMerchantId(string $merchant_id): void
    {
        $this->merchant_id = $merchant_id;
    }

    public function getAppId(): string
    {
        return $this->app_id;
    }

    public function setAppId(string $app_id): void
    {
        $this->app_id = $app_id;
    }

    public function getAppName(): string
    {
        return $this->app_name;
    }

    public function setAppName(string $app_name): void
    {
        $this->app_name = $app_name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getTxnId(): string
    {
        return $this->txn_id;
    }

    public function setTxnId(string $txn_id): void
    {
        $this->txn_id = $txn_id;
    }

    public function getTxnDate(): string
    {
        return $this->txn_date;
    }

    public function setTxnDate(string $txn_date): void
    {
        $this->txn_date = $txn_date;
    }

    public function getCurrency(): string
    {
        return $this->txn_currency;
    }

    public function setCurrency(string $txn_currency): void
    {
        $this->txn_currency = $txn_currency;
    }

    public function getTxnAmount(): string
    {
        return $this->txn_amount;
    }

    public function setTxnAmount(string $txn_amount): void
    {
        $this->txn_amount = $txn_amount;
    }

    public function getReferenceId(): string
    {
        return $this->reference_id;
    }

    public function setReferenceId(string $reference_id): void
    {
        $this->reference_id = $reference_id;
    }

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function setRemarks(string $remarks): void
    {
        $this->remarks = $remarks;
    }

    public function getParticulars(): string
    {
        return $this->particulars;
    }

    public function setParticulars(string $particulars): void
    {
        $this->particulars = $particulars;
    }

    public function getCertificate(): string
    {
        return $this->certificate;
    }

    public function setCertificate(string $certificate): void
    {
        $this->certificate = $certificate;
    }

    public function gatewayUrl(): string
    {
        try {
            return config('nchl')['gateway'];
        } catch (\Exception $e) {
            return 'https://www.connectips.com/connectipswebws/api/creditor/validatetxn';
        }
    }

    public function validationUrl(): string
    {
        try {
            return config('nchl')['validation_url'];
        } catch (\Exception $e) {
            return 'https://www.connectips.com/connectipswebws/api/creditor/validatetxn';
        }
    }

    public function transactionDetailUrl(): string
    {
        try {
            return config('nchl')['transaction_detail_url'];
        } catch (\Exception $e) {
            return 'https://www.connectips.com/connectipswebws/api/creditor/gettxndetail';
        }
    }

    /**
     * @param string $string
     *
     * @throws NchlException
     */
    public function token(string $string = null): string
    {
        $this->validate();
        // if (!$string) {
        //     $string = "MERCHANTID={$this->merchant_id},APPID={$this->app_id},APPNAME={$this->app_name},TXNID={$this->txn_id},TXNAMT={$this->txn_amount}";
        // }
        // if(!$string) $string = "MERCHANTID={$this->merchant_id},APPID={$this->app_id},APPNAME={$this->app_name},TXNID={$this->txn_id},TXNDATE={$this->txn_date},TXNCRNCY={$this->txn_currency},TXNAMT={$this->txn_amount},REFERENCEID={$this->reference_id},REMARKS={$this->remarks},PARTICULARS={$this->particulars},TOKEN=TOKEN";
        if (!$string) {
            $string = "MERCHANTID={$this->merchant_id},APPID={$this->app_id},APPNAME={$this->app_name},TXNID={$this->txn_id},TXNDATE={$this->txn_date},TXNCRNCY={$this->txn_currency},TXNAMT={$this->txn_amount},REFERENCEID={$this->reference_id},REMARKS={$this->remarks},PARTICULARS={$this->particulars},TOKEN=TOKEN";
        }

        $private_key = null;

        if (openssl_pkcs12_read($this->certificate, $cert_info, '123')) {
            $private_key = openssl_pkey_get_private($cert_info['pkey']);
        // $array = openssl_pkey_get_details($private_key);
            // print_r($array);
        } else {
            throw NchlException::certificateError($this, 'Unable to read certificate.');
        }

        if (openssl_sign($string, $signature, $private_key, 'sha256WithRSAEncryption')) {
            $hash = base64_encode($signature);
            openssl_free_key($private_key);
        } else {
            throw NchlException::certificateError($this, 'Unable to sign certificate.');
        }

        return $hash;
    }

    /**
     * @throws NchlException
     */
    public function validate()
    {
        $requiredFields = ['merchant_id', 'app_id', 'app_name', 'password', 'txn_currency', 'txn_id', 'txn_date', 'txn_amount', 'reference_id', 'remarks', 'particulars'];
        foreach ($requiredFields as $requiredField) {
            if (empty($this->{$requiredField})) {
                throw NchlException::missingField($this, $requiredField);
            }
        }
    }

    protected function update(array $data = [])
    {
        $config = config('nchl');
        if(gettype($config) == 'array') {
            foreach ($config as $key => $conf) {
                $this->{$key} = $conf;
            }
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
            $this->certificate = Storage::get('/public/certs/nchl.pfx');
        }
    }
}
