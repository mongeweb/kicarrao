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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head.php';
    if(count($_POST) > 0)
    {
        $codAnuncio = isset($_SESSION['id_anuncio']) ? $_SESSION['id_anuncio'] : 0;
        $ref = isset($_SESSION['reference']) ? $_SESSION['reference'] : 0;
        $codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : 0;
        $numPedido = isset($_SESSION['numeroPedido']) ? $_SESSION['numeroPedido'] : '';
        $valor = isset($_SESSION['planoValorPagamento']) ? $_SESSION['planoValorPagamento'] : 0;
        $pares = isset($_POST['PaRes']) ? $_POST['PaRes'] : '';
        $md = isset($_POST['MD']) ? $_POST['MD'] : '';
        if($ref < 1 || $codAnuncio < 1 || $codCliente < 1)
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
            printf("<script type='text/javascript'>
                        alert('Sessão expirou!');
                        document . location . replace('%s');
                    </script>", $link);
            die();
        }
        /*
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        //*/
        $xmlRequest = new XmlRequest();
    	$xmlRequest->transactionType = ETransaction::DEBIT_STAGE2;
    	$xmlRequest->gateway_reference = $ref;
    	$xmlRequest->paresMessage = $pares;
    	$xmlResponse = ETransaction::Send($xmlRequest);
    	
        /*
        echo "<pre>";
        var_dump($xmlResponse);
        echo "</pre>";
        die();
        //*/
        if($xmlResponse->status == 1)
        {
            
            $sIns = "INSERT pagamentos (dataCadastro, codCliente, xmlRetorno, tipoTransacao, codAnuncio, token, valorPlano)
                     VALUES ('".date("Y-m-d")."','$codCliente','".json_encode($xmlResponse)."','debito','$codAnuncio','$numPedido','$valor')";
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
            unset($_SESSION['planoValorPagamento'], $_SESSION['reference'], $_SESSION['numeroPedido']);
        }
        else
        {
            unset($_SESSION['id_anuncio'], $_SESSION['planoValorPagamento'], $_SESSION['reference'], $_SESSION['numeroPedido']);
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
            echo "<script type='text/javascript'>
                        alert('Erro ao finalizar transação!\\nRepita a operação de pagamento no menu \"Meus anúncios\" ou tente novamente mais tarde.');
                        document . location . replace('$link');
                    </script>";
            die();
        }
    }
    unset($_SESSION['id_anuncio']);
    ?>
    <script>
    $(document).ready(function()
    {
        _int = setInterval(function()
        {
            _time = parseInt($(".contador span").text())-1;
            $(".contador span").html(_time);
            if(_time == 0)
            {
                clearInterval(_int);
            }
        },1000)
        setTimeout(function()
        {
            document.location.replace('<?=$MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';?>');
        },10000)
    });
    </script>
</head>

<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
                <a href="<?=sslRedir().PROJECT_URL;?>/home.php">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Finalização</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="anunciewrap">
                    <div class="anunciedadosbloco">
                        <div class="confirmatextopag">
                            <p class="formtitulopag">Seu anúncio foi renovado com sucesso!</p>
                            <p class="formtextopag">Aguarde enquanto seu anúncio é liberado. Após término do período<br /> contratado, o anúncio ficará inativo, podendo ser renovado.</p>
                            <p class="formtextopag">Em 10 segundos você será redirecionado para a página "Meus Anúncios".</p>
                            <p class="formtextopag contador"><span>10</span>s</p>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>