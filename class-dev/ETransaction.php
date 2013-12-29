<?php
class ETransaction
{
    const CREDIT       = 0;
    const DEBIT_STAGE1 = 1;
    const DEBIT_STAGE2 = 2;
    const REVERSAL     = 3;
    const QUERY = 4;
    const USUARIO = '046157069';
    const SENHA = 'VeBP2dsf'; #PRODUCAO
    //const SENHA = 'p5SmcXA8u'; #TESTE
    public static function Send($xmlRequest)
    {
        $resp = new XmlResponse();
        $xmlIn = '';
        $url   = 'https://ecommerce.userede.com.br/transaction/wstransaction'; #PRODUÇÃO
        //$url   = 'https://scommerce.redecard.com.br/Beta/wsTransaction'; #TESTES
        switch ($xmlRequest->transactionType)
        {
            case self::CREDIT:
                $xmlIn = self::Credit_GenerateXML($xmlRequest);
                break;
            case self::DEBIT_STAGE1:
                //$url  = 'https://accreditation.datacash.com/Transaction/';
                $xmlIn = self::DebitStage1_GenerateXML($xmlRequest);
                break;
            case self::DEBIT_STAGE2:
                //$url  = 'https://accreditation.datacash.com/Transaction/';
                $xmlIn = self::DebitStage2_GenerateXML($xmlRequest);
                break;
            case self::REVERSAL:
                $xmlIn = self::Reversal_GenerateXML($xmlRequest);
                break;
            case self::QUERY:
                $xmlIn = self::Query_GenerateXML($xmlRequest);
                break;
        }
        try
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml; charset=utf-8"));
            curl_setopt($ch, CURLOPT_TIMEOUT, 60000);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlIn);
            $resp->setXmlOut(curl_exec($ch));
            curl_close($ch);
        }
        catch (Exception $e)
        {
            $resp->error = $e->getMessage();
        }
        return $resp;
    }



    private static function Credit_GenerateXML($xmlRequest)
    {
        $strXML = '';
        $strXML = "<Request version='2'>";
        $strXML .= "<Authentication>";
        $strXML .= "<AcquirerCode>
                        <rdcd_pv>".self::USUARIO."</rdcd_pv>
                    </AcquirerCode>
                    <password>".self::SENHA."</password>";
        $strXML .= "</Authentication>";
        $strXML .= "<Transaction>";
        $strXML .= "<CardTxn>";
        $strXML .= "<Card>";
        if ($xmlRequest->creditWithToken)
        {
            $strXML .= "<pan type=\"token\">";
            $strXML .= $xmlRequest->token;
        }
        else
        {
            $strXML .= "<pan>";
            $strXML .= $xmlRequest->pan;
        }
        $strXML .= "</pan>";
        $strXML .= "<expirydate>";
        $strXML .= $xmlRequest->dtExpire;
        $strXML .= "</expirydate>";
        $strXML .= "<Cv2Avs>";
        $strXML .= "<cv2>";
        $strXML .= $xmlRequest->cvv;
        $strXML .= "</cv2>";
        $strXML .= "</Cv2Avs>";
        $strXML .= "</Card>";
        $strXML .= "<method>auth</method>";
        $strXML .= "</CardTxn>";
        $strXML .= "<TxnDetails>";
        $strXML .= "<merchantreference >";
        $strXML .= $xmlRequest->merchantReference;
        $strXML .= "</merchantreference>";
        $strXML .= "<capturemethod>ecomm</capturemethod>";
        $strXML .= "<amount currency=\"BRL\">";
        $strXML .= $xmlRequest->value;
        $strXML .= "</amount>";
        $strXML .= "</TxnDetails>";
        $strXML .= "</Transaction>";
        $strXML .= "</Request>";
        $sbXML = new SimpleXMLElement($strXML);
        return $sbXML->asXML();
    }
    
    private static function DebitStage1_GenerateXML($xmlRequest)
    {
        $strXML = '';
        $strXML = "<Request version='2'>";
        $strXML .= "<Authentication>";
        $strXML .= "<AcquirerCode>
                        <rdcd_pv>".self::USUARIO."</rdcd_pv>
                    </AcquirerCode>
                    <password>".self::SENHA."</password>";
        $strXML .= "</Authentication>";
        $strXML .= "<Transaction>";
        $strXML .= "<TxnDetails>";
        $strXML .= "<merchantreference >";
        $strXML .= $xmlRequest->merchantReference;
        $strXML .= "</merchantreference>";
        $strXML .= "<amount currency=\"BRL\">";
        $strXML .= $xmlRequest->value;
        $strXML .= "</amount>";
        $strXML .= "<capturemethod>ecomm</capturemethod>";
        $strXML .= "<ThreeDSecure>";
        $strXML .= "<verify>yes</verify>";
        $strXML .= "<merchant_url>".$xmlRequest->urlRetorno."</merchant_url>";
        $strXML .= "<purchase_desc>".$xmlRequest->descricao."</purchase_desc>";
        $strXML .= "<purchase_datetime>";
        $strXML .= date("Ymd H:m:s");
        $strXML .= "</purchase_datetime>";
        $strXML .= "<Browser>";
        $strXML .= "<device_category>0</device_category>";
        $strXML .= "<accept_headers>*/*</accept_headers>";
        $strXML .= "<user_agent>IE/6.0</user_agent>";
        $strXML .= "</Browser>";
        $strXML .= "</ThreeDSecure>";
        $strXML .= "</TxnDetails>";
        $strXML .= "<CardTxn>";
        $strXML .= "<Card>";
        $strXML .= "<pan>";
        $strXML .= $xmlRequest->pan;
        $strXML .= "</pan>";
        $strXML .= "<expirydate>";
        $strXML .= $xmlRequest->dtExpire;
        $strXML .= "</expirydate>";
        if($xmlRequest->cvv != '')
        {
            $strXML .= "<Cv2Avs>";
            $strXML .= "<cv2>";
            $strXML .= $xmlRequest->cvv;
            $strXML .= "</cv2>";
            $strXML .= "</Cv2Avs>";
        }
        $strXML .= "</Card>";
        $strXML .= "<method>auth</method>";
        $strXML .= "</CardTxn>";
        $strXML .= "</Transaction>";
        $strXML .= "</Request>";
        $sbXML = new SimpleXMLElement($strXML);
        return $sbXML->asXML();
    }

    private static function DebitStage2_GenerateXML($xmlRequest)
    {
        $strXML = '';
        $strXML = "<Request version='2'>";
        $strXML .= "<Authentication>";
        $strXML .= "<AcquirerCode>
                        <rdcd_pv>".self::USUARIO."</rdcd_pv>
                    </AcquirerCode>
                    <password>".self::SENHA."</password>";
        $strXML .= "</Authentication>";
        $strXML .= "<Transaction>";
        $strXML .= "<HistoricTxn>";
        $strXML .= "<reference>";
        $strXML .= $xmlRequest->gateway_reference;
        $strXML .= "</reference>";
        $strXML .= "<method tx_status_u=\"accept\">threedsecure_authorization_request</method>";
        $strXML .= "<pares_message>";
        $strXML .= $xmlRequest->paresMessage;
        $strXML .= "</pares_message>";
        $strXML .= "</HistoricTxn>";
        $strXML .= "</Transaction>";
        $strXML .= "</Request>";
        $sbXML = new SimpleXMLElement($strXML);
        return $sbXML->asXML();       
    }
    private static function Reversal_GenerateXML($xmlRequest)
    {
        $strXML = '';
        $strXML = "<Request version='2'>";
        $strXML .= "<Authentication>";
        $strXML .= "<AcquirerCode>
                        <rdcd_pv>".self::USUARIO."</rdcd_pv>
                    </AcquirerCode>
                    <password>".self::SENHA."</password>";
        $strXML .= "</Authentication>";
        $strXML .= "<Transaction>";
        $strXML .= "<HistoricTxn>";
        $strXML .= "<reference>";
        $strXML .= $xmlRequest->tid;
        $strXML .= "</reference>";
        $strXML .= "<method>cancel</method>";
        $strXML .= "</HistoricTxn>";
        $strXML .= "</Transaction>";
        $strXML .= "</Request>";
        $sbXML = new SimpleXMLElement($strXML);
        return $sbXML->asXML();       
    }

    private static function Query_GenerateXML($xmlRequest)
    {
        $strXML = '';
        $strXML = "<Request version='2'>";
        $strXML .= "<Authentication>";
        $strXML .= "<AcquirerCode>
                        <rdcd_pv>".self::USUARIO."</rdcd_pv>
                    </AcquirerCode>
                    <password>".self::SENHA."</password>";
        $strXML .= "</Authentication>";
        $strXML .= "<Transaction>";
        $strXML .= "<HistoricTxn>";
        $strXML .= "<method>query</method>";
        if ($xmlRequest->queryWithTid)
        {
            $strXML .= "<reference>";
            $strXML .= $xmlRequest->tid;
            $strXML .= "</reference>";
        }
        else
        {
            $strXML .= "<reference  type=\"merchant\">";
            $strXML .= $xmlRequest->merchantReference;
            $strXML .= "</reference>";
        }
        $strXML .= "</HistoricTxn>";
        $strXML .= "</Transaction>";
        $strXML .= "</Request>";
        $sbXML = new SimpleXMLElement($strXML);
        return $sbXML->asXML();       
    }
}

?>