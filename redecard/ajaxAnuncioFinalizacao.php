<?php
require_once '../configRoot.php';
require_once 'class/XmlRequest.php';
require_once 'class/XmlResponse.php';
require_once 'class/ETransaction.php';

$acao = isset($_POST['acao']) ? $_POST['acao'] : '';
$retorno = array();
$erros = array
        (
            1 => "Erro ao finalizar transação!\nVerifique se os dados do cartão estão corretos ou tente novamente mais tarde.",
            2 => "Sessão expirou!",
        );

$erro = 1;
$retorno['erro'] = $erro;
$retorno['msg'] = $erros[$erro];
        	$numeroCartao = isset($_POST['numeroCartao']) ? $_POST['numeroCartao'] : '';//"5445400000000004";
        	$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';//"123";
        	$dataValidade = isset($_POST['dataValidade']) ? $_POST['dataValidade'] : '';//"04/14";
        	$valor = 10;
            $numPedido = date("YmdHis");
        	if($valor > 0)
            {
            	$xmlRequest = new XmlRequest();
            	switch($acao)
            	{
            		///*
                    case 'credito':
            			$xmlRequest->transactionType = ETransaction::CREDIT;
            			$xmlRequest->creditWithToken = false;
            			break;
            		//*/
                    /*
                    case 'credito':
            			$xmlRequest->transactionType = ETransaction::CREDIT;
            			$xmlRequest->creditWithToken = true;
            			break;
                    //*/
            		case 'debito':
            			$xmlRequest->transactionType = ETransaction::DEBIT_STAGE1;
                        $xmlRequest->urlRetorno = "https://www.kicarrao.com.br/redecard/anuncio-confirmacao.php";
                        $xmlRequest->descricao = "Kicarrao - Anúncio";
            			break;
            		case 'debito-finalizar':
            			$xmlRequest->transactionType = ETransaction::DEBIT_STAGE2;
            			break;
            		case 'estorno':
            			$xmlRequest->transactionType = ETransaction::REVERSAL;
            			break;
            		case 'consultaTID':
            			$xmlRequest->transactionType = ETransaction::QUERY;
            			$xmlRequest->queryWithTid = true;
            			break;
            		case 'consulta':
            			$xmlRequest->transactionType = ETransaction::QUERY;
            			$xmlRequest->queryWithTid = false;
            			break;
            	}
            	$xmlRequest->value = $valor;
            	$xmlRequest->pan = $numeroCartao;
            	$xmlRequest->cvv = $codigo;
            	$xmlRequest->dtExpire = $dataValidade;
            	$xmlRequest->merchantReference = $numPedido;
            	$xmlRequest->tid = "";
            	$xmlRequest->token = "";
            	$xmlRequest->paresMessage = "";
            	$xmlResponse = ETransaction::Send($xmlRequest);
            	
                /*
                echo "<pre>";
                var_dump($xmlResponse);
                echo "</pre>";
                //*/
                $retorno['xml'] = $xmlResponse;
            	
            	if(is_null($xmlResponse->error))
            	{
            		if ($xmlResponse->status == '1' || $xmlResponse->status == '150')
            		{
            			switch ($acao)
                		{
                			case 'credito':
                                $retorno['msg'] = "Transação realizada com sucesso";
                                //die();
                			    break;
                			/*case 1:
                				$retorno['msg'] = "Transação realizada com sucesso";
                				break;*/
                			case 'debito':
                				$retorno['msg'] = "Efetuar Autenticação 3DS - Segunda Etapa";
                                $_SESSION['reference'] = $xmlResponse->gateway_reference;
                                $erro = 0;
                                $retorno['erro'] = $erro;
                                
                				break;
                			case 'debito-finalizar':
                				$retorno['msg'] = "Transação realizada com sucesso";
                				break;
                			case 'estorno':
                				$retorno['msg'] = "Transação realizada com sucesso";
                				break;
                		}
                    }
                    else
                	{
                	    $erro = 1;
                		$retorno['erro'] = $erro;
                        $retorno['msg'] = $erros[$erro];
                	}
            	}
            	else
            	{
            		$retorno['erro'] = "xmlErro";
                    $retorno['msg'] = $xmlResponse->error;
            	}
            }
            else
            {
                $erro = 2;
                $retorno['erro'] = $erro;
                $retorno['msg'] = $erros[$erro];
            }
    

die(json_encode($retorno));
?>
                                