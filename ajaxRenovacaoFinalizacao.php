<?php
require_once 'configRoot.php';
///*
require_once PROJECT_PATH.'class/XmlRequest.php';
require_once PROJECT_PATH.'class/XmlResponse.php';
require_once PROJECT_PATH.'class/ETransaction.php';
//*/
/*
require_once PROJECT_PATH.'class-dev/XmlRequest.php';
require_once PROJECT_PATH.'class-dev/XmlResponse.php';
require_once PROJECT_PATH.'class-dev/ETransaction.php';
//*/
$acao = isset($_POST['acao']) ? $_POST['acao'] : '';
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : 0;
$codAnuncio = isset($_SESSION['id_anuncio']) ? $_SESSION['id_anuncio'] : 0;
$retorno = array();
$erros = array
        (
            1 => "Erro ao finalizar transação!\nVerifique se os dados do cartão estão corretos ou tente novamente mais tarde.",
            2 => "Sessão expirou!",
        );
$errosXml = array
        (
            80 => "Transação não autorizada. Contate o emissor. (Saldo Insuficiente)",
            162 => "Cartão não disponível no momento para transacionar online com segurança.",
        );

$erro = 1;
$retorno['erro'] = $erro;
$retorno['msg'] = $erros[$erro];
if($codCliente > 0)
{
    if($codAnuncio > 0)
    {
        if($acao != '')
        {
        	$numeroCartao = isset($_POST['numeroCartao']) ? $_POST['numeroCartao'] : '';//"5445400000000004";
        	$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';//"123";
        	$dataValidade = isset($_POST['dataValidade']) ? $_POST['dataValidade'] : '';//"04/14";
        	$valor = isset($_SESSION['planoValorRenovacao']) ? $_SESSION['planoValorRenovacao'] : 0;//4.50;
            $numPedido = date("YmdHis").$codCliente;
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
                        $xmlRequest->urlRetorno = "https://www.kicarrao.com.br/anuncio-renovacao-confirmacao.php";
                        $retorno['url'] = "https://www.kicarrao.com.br/anuncio-renovacao-confirmacao.php";
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
                                $erro = 0;
                                $retorno['erro'] = $erro;
                                $sIns = "INSERT pagamentos (dataCadastro, codCliente, xmlRetorno, tipoTransacao, codAnuncio, token, valorPlano)
                                         VALUES ('".date("Y-m-d")."','$codCliente','".json_encode($xmlResponse)."','$acao','$codAnuncio','$numPedido','$valor')";
                                for($a=0;$a<5;$a++)
                                {
                                    $qIns = mysql_query($sIns);
                                    //echo mysql_error();
                                    if($qIns)
                                    {
                                        break;
                                    }
                                }
                                
                                $hoje = date('Y-m-d');
                                $qAnuncio = mysql_query("SELECT nDias, codRenovacao FROM clientesAnuncios WHERE cod = '$codAnuncio'");
                                $tpAnuncio = mysql_fetch_assoc($qAnuncio);
                                $nDias = $tpAnuncio['nDias'];
                                
                                $qAnuncioAntigo = mysql_query("SELECT dataValidadeAnuncio FROM clientesAnuncios WHERE cod = '{$tpAnuncio['codRenovacao']}'");
                                $tpAnuncioAntigo = mysql_fetch_assoc($qAnuncioAntigo);
                                $dataValidade = $tpAnuncioAntigo['dataValidadeAnuncio'];
                                $timeValidade = strtotime($dataValidade);
                                $time = $timeValidade-time();
                                $diasTot = (int)floor($time/86400);
                                $diasTot = $diasTot > 0 ? $diasTot : 0;
                                $validadeAnuncio = date('Y-m-d', strtotime("+".($nDias+$diasTot)." days"));
                                
                                $sqlUpdateAntigo = "UPDATE clientesAnuncios SET
                                                status = '3'
                                                WHERE cod = {$tpAnuncio['codRenovacao']}";
                                for($a=0;$a<5;$a++)
                                {
                                    $qAnt = mysql_query($sqlUpdateAntigo);
                                    //echo mysql_error();
                                    if($qAnt)
                                    {
                                        break;
                                    }
                                }
                                
                                
                                $sqlAprov = "UPDATE clientesAnuncios SET 
                                            status = '1',
                                            aprovado = 1,
                                            dataValidadeAnuncio = '$validadeAnuncio',
                                            dataLiberacaoAnuncio = '$hoje'
                                            WHERE cod='$codAnuncio'";
                                for($a=0;$a<5;$a++)
                                {
                                    $qAprov = mysql_query($sqlAprov);
                                    //echo mysql_error();
                                    if($qAprov)
                                    {
                                        break;
                                    }
                                }
                                    
                				$retorno['msg'] = "Transação realizada com sucesso";
                                //die();
                			    break;
                			/*case 1:
                				$retorno['msg'] = "Transação realizada com sucesso";
                				break;*/
                			case 'debito':
                				$erro = 0;
                                $retorno['erro'] = $erro;
                                $retorno['msg'] = "Efetuar Autenticação 3DS - Segunda Etapa";
                                $_SESSION['reference'] = $xmlResponse->gateway_reference;
                                $_SESSION['numeroPedido'] = $numPedido;
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
                        $retorno['msg'] = array_key_exists($xmlResponse->status, $errosXml) ? $errosXml[$xmlResponse->status] : $erros[$erro];
                	}
            	}
            	else
            	{
            		$retorno['erro'] = "xmlErro";
                    $retorno['msg'] = array_key_exists($xmlResponse->status, $errosXml) ? $errosXml[$xmlResponse->status] : $erros[$erro];
            	}
            }
            else
            {
                $erro = 2;
                $retorno['erro'] = $erro;
                $retorno['msg'] = $erros[$erro];
            }
        }
    }
    else
    {
        $erro = 2;
        $retorno['erro'] = $erro;
        $retorno['msg'] = $erros[$erro];
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
                                