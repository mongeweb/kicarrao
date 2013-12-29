<?php
class XmlResponse
{       
    public $error;
    public $authCode;
    public $brand;
    public $token;
    public $tid;
    public $merchantReference;
    public $reason;
    public $status;
    public $dtTransaction;
    public $pareq_message;
    public $acs_url;
    public $xmlOut;
    public function __set($property, $value)
    {
        $this->$property = $value;
    }             
    public function __get($property)
    {
        return $this->$property;
    }             
    public function setXmlOut($xml)
    {
        //echo htmlentities($xml);
        $this->xmlOut = new DOMDocument();
        $this->xmlOut->loadXML($xml);
        $authCode = $this->xmlOut->getElementsByTagName("authcode");
        //var_dump($authCode);
        $this->authCode = $authCode->length > 0 ? $authCode->item(0)->nodeValue : '';                
        $brand = $this->xmlOut->getElementsByTagName("card_scheme");
        //var_dump($brand);
        $this->brand = $brand->length > 0 ? $brand->item(0)->nodeValue : '';            
        if (is_null($this->brand) || $this->brand == '')
        {
            $brand = $this->xmlOut->getElementsByTagName("scheme");
            $this->brand = $brand->length > 0 ? $brand->item(0)->nodeValue : '';                                
        }
        $token = $this->xmlOut->getElementsByTagName("token");
        //var_dump($token);
        $this->token = $token->length > 0 ? $token->item(0)->nodeValue : '';     
        $tid = $this->xmlOut->getElementsByTagName("datacash_reference");
        //var_dump($tid);
        $this->tid = $tid->length > 0 ? $tid->item(0)->nodeValue : ''; 
        $gateway_reference = $this->xmlOut->getElementsByTagName("gateway_reference");
        $this->gateway_reference = $gateway_reference->length > 0 ? $gateway_reference->item(0)->nodeValue : '';            
        $merchantReference = $this->xmlOut->getElementsByTagName("merchantreference");
        $this->merchantReference = $merchantReference->item(0)->nodeValue;     
        if (is_null($this->merchantReference) || $this->merchantReference == '')
        {
            $merchantReference = $this->xmlOut->getElementsByTagName("merchantreference");
            $this->merchantReference = $merchantReference->item(0)->nodeValue;                                                     
        }                             
        $reason = $this->xmlOut->getElementsByTagName("reason");
        $this->reason = $reason->item(0)->nodeValue;            
        $status = $this->xmlOut->getElementsByTagName("status");
        $this->status = $status->item(0)->nodeValue;
        $time = $this->xmlOut->getElementsByTagName("time");
        if (!is_null($time->item(0)->nodeValue) || $time->item(0)->nodeValue <> '')
            $this->dtTransaction = date("Y-m-d H:i:s", $time->item(0)->nodeValue);
        else
            $this->dtTransaction = date("Y-m-d H:i:s");
        $acs_url = $this->xmlOut->getElementsByTagName("acs_url");
        $this->acs_url = $acs_url->length > 0 ? $acs_url->item(0)->nodeValue : '';     
        $pareq_message = $this->xmlOut->getElementsByTagName("pareq_message");
        $this->pareq_message = $pareq_message->length > 0 ? $pareq_message->item(0)->nodeValue : '';
        $this->spareq_message = $status->item(0)->nodeValue;         
    }
}
?>