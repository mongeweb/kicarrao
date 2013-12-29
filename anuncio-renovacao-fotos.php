<?php
require_once 'configRoot.php';
$enviar = isset($_POST['enviarRenovacao']) ? $_POST['enviarRenovacao'] : '';
$codAnuncio = isset($_SESSION['renovacao']['codAnuncioAntigo']) ? $_SESSION['renovacao']['codAnuncioAntigo'] : '';
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : '';
$msg = '';
if($codAnuncio == '' || $codCliente == '') 
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
    echo " <script>";
	echo "     location.replace('".$link."'); \n";
	echo " </script>";
    die();   
}
$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
$qAnunc = mysql_query("SELECT cod FROM clientesAnuncios WHERE codRenovacao = '$codAnuncio'");
$nAnunc = mysql_num_rows($qAnunc);
if($nAnunc > 0)
{
    printf("<script type='text/javascript'>
				alert('Anúncio já renovado!');
                document.location.replace('".$link."');
			</script>");
    die();
}
if($enviar != '')
{
    $conexao = conexao();
    require_once ADMIN_FUNC_PATH.'fotos.php';
    
    $sqlNumeroDeFotos = mysql_query("SELECT nFotos FROM clientesAnuncios WHERE cod ='$codAnuncio'");
    
    $tpNumeroDeFotos = mysql_fetch_assoc($sqlNumeroDeFotos);
    $numfotos = (int)$tpNumeroDeFotos['nFotos'];
    for ($x = 0;$x < $numfotos; $x++)
    {
        $foto = isset($_FILES['foto']['name'][$x]) ? $_FILES['foto']['name'][$x] : '';
        if($foto != '')
        {
            ##Inicio Valida Extensão e Tamanho
            $formato = $foto;
            $formato = strrev($formato);
            $formato = explode('.',$formato);
            $formato = $formato[0];
            $formato = strrev($formato);
        	$formato = strtolower($formato);
            $extensoesvalidas = array("jpg","jpeg","png");
            if(!in_array($formato,$extensoesvalidas))
        	{
        		$msg .= 'Formato da imagem '.($x+1).' inválido!';
            }
            ##Fim Valida Extensão e Tamanho
        }
    }
    if($msg == '')
    {        
        $dataHoje = date("Y-m-d");
        $sqlNew = "INSERT INTO clientesAnuncios 
                (dataCadastro, codCliente, tipoVeiculo, marca, modelo, versao, placa, anoFabricacao, anoModelo, cor, combustivel,
                km, nPortas, valor, nParcelas, valorParcela, valorEntrada, caractVeiculo , plano,
                nFotos, planoValor, nDias, dataLiberacaoAnuncio, codPlanoParticular, codRenovacao)
                VALUES
                ('{$dataHoje}', '{$codCliente}', '{$_SESSION['renovacao']['tipoVeiculo']}', '{$_SESSION['renovacao']['marca']}', '{$_SESSION['renovacao']['modelo']}', '{$_SESSION['renovacao']['versao']}', '{$_SESSION['renovacao']['placa']}', '{$_SESSION['renovacao']['anoFabricacao']}', '{$_SESSION['renovacao']['anoModelo']}', '{$_SESSION['renovacao']['cor']}', '{$_SESSION['renovacao']['combustivel']}',
                '{$_SESSION['renovacao']['km']}', '{$_SESSION['renovacao']['nPortas']}', '{$_SESSION['renovacao']['valor']}', '{$_SESSION['renovacao']['nParcelas']}', '{$_SESSION['renovacao']['valorParcela']}', '{$_SESSION['renovacao']['valorEntrada']}', '{$_SESSION['renovacao']['caractVeiculo']}', '{$_SESSION['renovacao']['plano']}',
                '{$_SESSION['renovacao']['nFotos']}', '{$_SESSION['renovacao']['planoValor']}', '{$_SESSION['renovacao']['nDias']}', '{$dataHoje}', '{$_SESSION['renovacao']['codPlano']}', '{$codAnuncio}');";
        for($a=0;$a<5;$a++)
        {
            $qNew = mysql_query($sqlNew);
            if($qNew)
            {
                break;
            }
        }
        if($qNew)
        {
            $codAnuncioNovo = mysql_insert_id();
            $acessorios = $_SESSION['renovacao']['acessorios'];
            foreach($acessorios as $k => $v)
            {
                $sqlAcessorioIns = "INSERT INTO acessoriosAnuncios (codAnuncio, codAcessorio) VALUES ('$codAnuncioNovo','$v')";
                for($a=0;$a<5;$a++)
                {
                    $qAcessoriosIns = mysql_query($sqlAcessorioIns);
                    if($qAcessoriosIns)
                    {
                        break;
                    } 
                }
            }
            $nFotosTipo = isset($_SESSION['renovacao']['fotos']) ? count($_SESSION['renovacao']['fotos']) : 0;
            if($nFotosTipo > 0)
            {
                $FotosTipo = isset($_SESSION['renovacao']['fotos']) ? $_SESSION['renovacao']['fotos'] : array();
                foreach($FotosTipo as $pos => $val)
                {
                    $valFotosTipo = $pos;
                    $qFotos = mysql_query("SELECT * FROM arquivos WHERE codigo = '{$valFotosTipo}' AND codReferencia = '{$codAnuncio}' ORDER BY capa DESC");
                    $nFotos = mysql_num_rows($qFotos);
                    $token = date('dmYHis').rand(1,99999);
                    for($c=0;$c<$nFotos;$c++)
                    {
                        $tpFotos = mysql_fetch_assoc($qFotos);
                        $copy = false;
                        $ext = pathinfo($tpFotos['arquivo'], PATHINFO_EXTENSION);
                        
                        $arquivo = "foto_".date("Ymdhis")."_".rand(0,99999).".$ext";
                        
                        for($d=0;$d<5;$d++)
                        {
                            $copy = copy(PROJECT_PATH."/arquivos/clientesAnuncios/".$tpFotos['arquivo'], PROJECT_PATH."/arquivos/clientesAnuncios/".$arquivo);
                            if($copy)
                            {
                                $sqlIns = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                                        VALUES ('clientesAnuncios', '{$codAnuncioNovo}','{$tpFotos['tipo']}', '{$arquivo}','$token', '{$tpFotos['capa']}')";
                        		for($e=0;$e<5;$e++)
                                {
                                    $qIns = mysql_query($sqlIns);
                                    if($qIns)
                                    {
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                    }
                }
            }
            for ($x = 0;$x < $numfotos; $x++)
            {
                $foto = isset($_FILES['foto']['name'][$x]) ? $_FILES['foto']['name'][$x] : '';
                if($foto != '')
                {
                    $foto_temp = isset($_FILES['foto']['tmp_name'][$x]) ? $_FILES['foto']['tmp_name'][$x] : '';
                    $sqlVerificaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncioNovo' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '1'");
                    $numVerificaCapa = mysql_num_rows($sqlVerificaCapa);
                    $capa = $x == 0 && $numVerificaCapa == 0 ? 1 : 0;
                    
                    $token = date('dmYHis').rand(1,99999);
                    $pasta = PROJECT_PATH."arquivos/clientesAnuncios";
                    
                    $fileG = insere_foto($foto, $foto_temp, $pasta,'800','600');
            		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                            VALUES ('clientesAnuncios', '{$codAnuncioNovo}','3', '{$fileG}','$token', '$capa')";
            		$resultadoG = mysql_query($sqlG);
                    
                    $fileM = insere_foto($foto, $foto_temp, $pasta,'465','349');
            		$sqlM = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                            VALUES ('clientesAnuncios', '{$codAnuncioNovo}','2', '{$fileM}','$token', '$capa')";
            		$resultadoM = mysql_query($sqlM);
                    
                    $fileP = insere_foto($foto, $foto_temp, $pasta,'158','116');
            		$sqlP = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                            VALUES ('clientesAnuncios', '{$codAnuncioNovo}','1', '{$fileP}','$token', '$capa')";
            		$resultadoP = mysql_query($sqlP);
                }
            }
        
            $sqlSelectCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncioNovo' AND referencia = 'clientesAnuncios' AND capa = '1'");
        	$linhasSelectCapa = mysql_num_rows($sqlSelectCapa);
        	
        	if($linhasSelectCapa == 0)
        	{
        		$sqlMarcaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncioNovo' AND referencia = 'clientesAnuncios' AND capa = '0' LIMIT 1");
        		$tpMarcaCapa = mysql_fetch_assoc($sqlMarcaCapa);
        		$sqlUpCapa = "UPDATE arquivos SET
                        capa = '1'
                        WHERE codReferencia = '$codAnuncioNovo' AND codigo = '{$tpMarcaCapa['codigo']}' AND referencia = 'clientesAnuncios'";
            	$resultadoUpCapa = mysql_query($sqlUpCapa);
        	}
            if($_SESSION['renovacao']['planoValor'] == 0)
            {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-renovacao-confirmacao' : sslRedir().PROJECT_URL.'/anuncio-renovacao-confirmacao.php';
                    printf("<script type='text/javascript'>
                				document.location.replace('".$link."');
                			</script>");
                    die();
            }
            unset($_SESSION['renovacao']);
            $_SESSION['id_anuncio'] = $codAnuncioNovo;
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-renovacao-finalizacao' : sslRedir().PROJECT_URL.'/anuncio-renovacao-finalizacao.php';		  
    		echo "<script type='text/javascript'>
                   document.location.replace('".$link."');
    			 </script> \n";
                 die();
        }
        else
        {
            printf("<script type='text/javascript'>
        				alert('Erro! Tente novamente mais tarde.');
                        document.location.replace('".$link."');
        			</script>");
            die();
        }
    }
    mysql_close();
}
$cogigoApaga = isset($_POST['codigoApaga']) ? $_POST['codigoApaga'] : '';
if($cogigoApaga != '')
{            
    unset($_SESSION['renovacao']['fotos'][$cogigoApaga]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
    require_once PROJECT_INC_PATH.'head.php';
    $conexao = conexao();
    $sqlVerificaCliente = mysql_query("SELECT codCliente, nFotos FROM clientesAnuncios WHERE cod = $codAnuncio AND codCliente = $codCliente");
    $numVerificaCliente = mysql_num_rows($sqlVerificaCliente);
    mysql_close();
    if($numVerificaCliente < 1)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        exit();
    }
    $tpVerificaCliente = mysql_fetch_assoc($sqlVerificaCliente);
    $nFotos = isset($_SESSION['renovacao']['nFotos']) ? (int)$_SESSION['renovacao']['nFotos'] : 0;
    $nomeCliente = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $nFotosAnterior = $tpVerificaCliente['nFotos'];
    ?>
    <script type="text/javascript">
    $(document).ready(function()
    {
        $(".apagarFoto").click(function()
        {
            _val = $(this).attr('rel');
            $('#codigoApaga').val(_val);
            $('#formApaga').submit();
        })
        $("#enviarRenovacao").click(function(){
            _numFotos = $(".fotoimg").length;
            if(_numFotos > <?=$nFotos;?>)
            {
                alert("Prezado <?=$nomeCliente;?>, seu anuncio anterior possibilitava o cadastro de <?=$nFotosAnterior;?> foto<?=$nFotosAnterior > 1 ? 's' : '';?>, o novo plano escolhido possibilita apenas <?=$nFotos;?> foto<?=$nFotos > 1 ? 's' : '';?>. É necessário que você selecione apenas <?=$nFotos;?> foto<?=$nFotos > 1 ? 's' : '';?> para dar continuidade à renovação.");
                return false;
            }
        })
        
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
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Fotos</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="anunciewrap">
                    <div class="anunciedadosbloco">
                        <form name="formApaga" id="formApaga" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" value="" name="codigoApaga" id="codigoApaga" />
                        </form>
                        <form name="fotosAnuncio" id="fotosAnuncio" method="post" action="" enctype="multipart/form-data">
                            <div class="fotoanunciobloco">
                                <p class="fototitulo">Agora você precisa fazer o Upload das fotos para seu Anúncio. Utilize os formulários abaixo:</p>
                                <?=$msg;?>
                                <div class="fotolistabloco">
                                    <div class="fotolistacoluna">
                                        <?
                                        $conexao = conexao();
                                        
                                        $capaAux = 0;
                                        $xAux = 0;
                                        $nFotosTipo = isset($_SESSION['renovacao']['fotos']) ? count($_SESSION['renovacao']['fotos']) : 0;
                                        if($nFotosTipo > 0)
                                        {
                                            $FotosTipo = isset($_SESSION['renovacao']['fotos']) ? $_SESSION['renovacao']['fotos'] : array();
                                            foreach($FotosTipo as $pos => $val)
                                            {
                                                $xAux++;
                                                $valFotosTipo = $pos;
                                                $sqlFotosInseridas = mysql_query("SELECT * FROM arquivos WHERE codigo = '$valFotosTipo' AND codReferencia = '$codAnuncio' AND tipo = '1' AND referencia = 'clientesAnuncios'");
                                                $tpFotosInseridas = mysql_fetch_assoc($sqlFotosInseridas);
                                                //$_SESSION['renovacao']['fotos'][$tpFotosInseridas['codigo']] = $tpFotosInseridas['arquivo'];
                                                if($tpFotosInseridas['capa'] == '1')
                                                    $capaAux = 1;
                                        ?>
                                                <div class="fotobloco">
                                                    <div class="fototopo">
                                                        Capa <input type="radio" name="capa[]" id="capa<?=($xAux);?>" value="<?=$tpFotosInseridas['codigo'];?>" <?=$tpFotosInseridas['capa'] == '1' ? 'checked="checked"' : '';?> />
                                                        <b>
                                                            Foto <?=($xAux);?>
                                                        </b>
                                                        <a class="apagarFoto" rel="<?=$tpFotosInseridas['codigo'];?>">
                                                            <img class="anuncioexcluir" src="<?=ssl().PROJECT_URL;?>/img/excluirfotoanuncio.png" alt="Excluir foto" />
                                                        </a>
                                                    </div>
                                                    <div class="fotoimg">
                                                        <img style="max-height: 160px; max-width: 345;" src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosInseridas['arquivo'];?>" alt="Anúncio" />
                                                    </div>
                                                </div>
                                        <?
                                            }
                                        }
                                        $nFotos = ($nFotos-$nFotosTipo);
                                        
                                        $posicaoDaFoto = $nFotosTipo;
                                        for($x = 0;$x < $nFotos;$x++)
                                        {
                                        ?>
                                            <div class="fotobloco">
                                                <div class="fototopo">Faça o Upload da <b>Foto <?=$x == 0 && $capaAux == 0 ? 'de Capa' : ($posicaoDaFoto+1);?></b></div>
                                                <div class="fotoinput"><input type="file" name="foto[]" id="foto<?=$x;?>" title="Foto <?=($posicaoDaFoto+1);?>" /></div>
                                            </div>
                                        <?
                                            $posicaoDaFoto++;
                                        }
                                        mysql_close();
                                        ?>
                                        
                                    </div>
                                </div>
                                <div class="anunciofotoenviar">
                                    <input type="submit" name="enviarRenovacao" id="enviarRenovacao" title="Avançar" value="Avançar" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>