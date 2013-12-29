<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
</head>

<body>
<?php
$codAnuncio = isset($_SESSION['id_anuncio']) ? $_SESSION['id_anuncio'] : 0;
$tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : 0;
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : 0;
$boleto = isset($_SESSION['boleto']) ? $_SESSION['boleto'] : 0;
$valorPlano = 0;
$codBoleto = 0;
unset($_SESSION['id_anuncio']);
if($boleto > 0 || $codCliente < 1 || ($tipoAnuncio != 1 && $tipoAnuncio != 2))
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
    printf("<script type='text/javascript'>
                document . location . replace('%s');
            </script>", $link);
    die();
}

if($boleto < 1)
{
    $conexao = conexao();
    $n = 0;
    if($tipoAnuncio == 1 && $codAnuncio > 0)
    {
        //echo $codAnuncio;
        $q = mysql_query("SELECT ca.cod,ca.planoValor FROM clientesAnuncios AS ca
                          INNER JOIN clientes AS c ON c.cod = ca.codCliente
                          WHERE ca.cod = '$codAnuncio' AND c.cod = '$codCliente' AND c.tipoAnuncio = '1'");
        //echo mysql_error();
        $n = mysql_num_rows($q);
    }
    else if($tipoAnuncio == 2)
    {
        $q = mysql_query("SELECT @cod:=0 AS cod,pr.valor AS planoValor FROM clientes AS c
                          INNER JOIN planosRevenda AS pr ON pr.cod = c.codPlanoRevenda
                          WHERE c.cod = '$codCliente' AND c.tipoAnuncio = '2' AND c.tipoRevenda = '1' GROUP BY c.cod");
        //echo mysql_error();
        $n = mysql_num_rows($q);
    }
        
    if($n > 0)
    {
        $tp = mysql_fetch_assoc($q);
        $valorPlano = $tp['planoValor'];
        if($valorPlano > 0)
        {
            $query = mysql_query("SHOW TABLE STATUS LIKE 'boletos'");
            $row = mysql_fetch_array($query);
            $cod = $row['Auto_increment'] ;
            $dataHoje = date("Y-m-d");
            $nDoc = str_pad($cod,15,0,STR_PAD_LEFT);
            
            if($tipoAnuncio == 2)
            { 
                $dias_para_pagamento = 40;
                $dataVencimento = date("Y-m-d", time()+($dias_para_pagamento*86400));
            }
            else
            {
                $dataVencimento = "0000-00-00";
            }
            
            $sBol = "INSERT INTO boletos (dataCadastro, codBoleto, codAnuncio, codCliente, nDoc, dataProcessamento, dataVencimento, valor)
                    VALUES('$dataHoje','$cod','$codAnuncio','$codCliente','$nDoc','$dataHoje','$dataVencimento','$valorPlano')";
            for($a=0;$a<5;$a++)
            {
                $qBol = mysql_query($sBol);
                if($qBol)
                {
                    $codBoleto = mysql_insert_id();
                    break;
                }    
            }
        }
        /*require_once PROJECT_FUNC_PATH.'cadastroEmail.php';
        $nomeRemetente = "Kicarrão";
        $assunto = "Cadastro - Kicarrão";
        $conteudoEmail = array
                         (
                            'nome'      => 'teste',
                            'email'     => 'teste@teste.teste',
                            'senha'     => 'teste321'
                         );
        
        $emailDestinatario = array('diego@monge.com.br');//array($email);
        $emailRemetente = $emailResposta  = 'noreply@kicarrao.com.br';
        $twitter = '';
        $facebook = 'kicarrao';
        
        for($a=0;$a<5;$a++)
        {
            $conf = confirmacaoAnuncio($emailRemetente, $emailDestinatario, $emailResposta, $assunto, $nomeRemetente, $conteudoEmail, $twitter, $facebook);		
            if($conf)
            {
                break;
            }
        }
            echo " <script> \n";
            echo " alert(\"Anúncio cadastrado com sucesso!\");\n";
        	echo " </script> \n";*/
    }
    mysql_close();
}
?>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
                <a href="http://<?=PROJECT_URL;?>/home.php">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Finalização</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="anunciewrap">
                    <div class="anunciedadosbloco">
                        <div class="anunciefinalbloco">
                            <p class="anunciefinaltitulo">Seus dados foram registrados com sucesso!</p>
                            <p>Para efetivar seu cadastro, efetue o <b>pagamento</b> através do boleto.</p>
                            <div class="pagamentobloco">
                                <p class="pagamentotexto">
                                    <span class="pagamentotitulo">Boleto Bancário</span>
                                </p>
                                <?php
                                $_SESSION['boleto'] = 1;
                                $conexao = conexao();
                                $qBoleto = mysql_query("SELECT cod FROM boletos WHERE cod = '$codBoleto' AND codCliente = '$codCliente' ORDER BY cod DESC LIMIT 1");
                                echo mysql_error();
                                $nBoleto = mysql_num_rows($qBoleto);
                                mysql_close();
                                if($nBoleto > 0)
                                {
                                    $link = sslRedir().PROJECT_URL."/boleto/visualizar.php?b=".base64_encode($codBoleto);
                                ?>
                                    <div class="imprimirboleto">
                                        <a target="_blank" href="<?=$link;?>">Imprimir Boleto</a>
                                
                                    </div>
                                <?php
                                }
                                ?>
                                <p class="anunciefinalrodape">Obrigado por anunciar no Kicarrão!</p>
                            </div>
                            
                            
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