<?php
class XmlRequest
{
    public $transactionType;
    public $token;
    public $dtExpire;
    public $cvv;
    public $merchantReference;
    public $gateway_reference;
    public $value;
    public $tid;
    public $paresMessage;
    public $creditWithToken;
    public $queryWithTid;
    public function __set($property, $value)
    {
        $this->$property = $value;
    }
    public function __get($property)
    {
        return $this->$property;
    }
}
?>