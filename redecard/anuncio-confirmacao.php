<?php
require_once '../configRoot.php';
require_once 'class/XmlRequest.php';
require_once 'class/XmlResponse.php';
require_once 'class/ETransaction.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head.php';
    if(count($_POST) > 0)
    {
        $pares = isset($_POST['PaRes']) ? $_POST['PaRes'] : '';
        $md = isset($_POST['MD']) ? $_POST['MD'] : '';
        $ref = isset($_SESSION['reference']) ? $_SESSION['reference'] : '';
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
    	
        ///*
        echo "<pre>";
        var_dump($xmlResponse);
        echo "</pre>";
        //*/
    }
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
            //document.location.replace('<?=$MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';?>');
        },10000)
    })
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
                            <p class="formtitulopag">Seu anúncio foi cadastrado com sucesso!</p>
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