<?php require_once 'configRoot.php';
$enviar = isset($_POST['enviarDadosAnuncio']) ? $_POST['enviarDadosAnuncio'] : '';
$cod = isset($cod) ? $cod : '';
$cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
$codAnuncio = isset($_SESSION['id_anuncio']) ? $_SESSION['id_anuncio'] : $cod;
$msg = '';
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : '';
$tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : '1';
if($enviar != '')
{
    $conexao = conexao();
    require_once ADMIN_FUNC_PATH.'fotos.php';
    $qFotosBanco = mysql_query("SELECT * FROM arquivos WHERE codReferencia='$codAnuncio' AND referencia = 'clientesAnuncios' AND tipo = '1'");
    $nFotosBanco = mysql_num_rows($qFotosBanco);
    if($nFotosBanco > 0)
    {
        $sqlcapa = "UPDATE arquivos SET
                    capa = '0'
                    WHERE codReferencia = '$codAnuncio' AND referencia = 'clientesAnuncios'";
        $resultadocapa = mysql_query($sqlcapa);
        for ($e = 0; $e < $nFotosBanco; $e++)
        {
            $capa = isset($_POST['capa'][$e]) ? $_POST['capa'][$e] : '' ;
    
            $sqlcapa = "UPDATE arquivos SET
                        capa = '1'
                        WHERE codReferencia = '$codAnuncio' AND codigo = '$capa' AND referencia = 'clientesAnuncios'";
            $resultadocapa = mysql_query($sqlcapa);
        }
    }
    if($tipoAnuncio == '1')
    {
        $sqlNumeroDeFotos = mysql_query("SELECT nFotos FROM clientesAnuncios WHERE cod ='$codAnuncio'");
    }
    else
    {
        $sqlNumeroDeFotos = mysql_query("SELECT pr.nFotos FROM clientes AS c
                   INNER JOIN planosRevenda AS pr ON c.codPlanoRevenda = pr.cod
                   WHERE c.cod = '$codCliente'
                   GROUP BY pr.cod");
    }
    $tpNumeroDeFotos = mysql_fetch_assoc($sqlNumeroDeFotos);
    $numfotos = (int)$tpNumeroDeFotos['nFotos'];
    for ($x = 0;$x < $numfotos; $x++)
    {
        $foto = isset($_FILES['foto']['name'][$x]) ? $_FILES['foto']['name'][$x] : '';
        if($foto != '')
        {
            $foto_temp = isset($_FILES['foto']['tmp_name'][$x]) ? $_FILES['foto']['tmp_name'][$x] : '';
            $sqlVerificaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncio' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '1'");
            $numVerificaCapa = mysql_num_rows($sqlVerificaCapa);
            $capa = $x == 0 && $numVerificaCapa == 0 ? 1 : 0;
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
            
            if($msg == '')
            {
                $token = date('dmYHis').rand(1,99999);
                $pasta = PROJECT_PATH."arquivos/clientesAnuncios";
                
                $pastaMarcaDagua = PROJECT_PATH."img/logo-fotos.png";
                
                $fileG = insere_foto_com_marca_dagua($foto, $foto_temp, $pasta,'800','600', $pastaMarcaDagua,3);
        		$sqlG = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                        VALUES ('clientesAnuncios', '{$codAnuncio}','3', '{$fileG}','$token', '$capa')";
        		$resultadoG = mysql_query($sqlG);
                
                $fileM = insere_foto_com_marca_dagua($foto, $foto_temp, $pasta,'465','349', $pastaMarcaDagua,3);
        		$sqlM = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                        VALUES ('clientesAnuncios', '{$codAnuncio}','2', '{$fileM}','$token', '$capa')";
        		$resultadoM = mysql_query($sqlM);
                
                $fileP = insere_foto_com_marca_dagua($foto, $foto_temp, $pasta,'158','116', $pastaMarcaDagua,3);
        		$sqlP = "INSERT INTO arquivos (referencia, codReferencia,tipo, arquivo, codigo, capa)
                        VALUES ('clientesAnuncios', '{$codAnuncio}','1', '{$fileP}','$token', '$capa')";
        		$resultadoP = mysql_query($sqlP);
        	}
        }
    }
    if($msg == '')
    {
        
        $sqlSelectCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncio' AND referencia = 'clientesAnuncios' AND capa = '1'");
    	$linhasSelectCapa = mysql_num_rows($sqlSelectCapa);
    	
    	if($linhasSelectCapa == 0)
    	{
    		$sqlMarcaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncio' AND referencia = 'clientesAnuncios' AND capa = '0' LIMIT 1");
    		$tpMarcaCapa = mysql_fetch_assoc($sqlMarcaCapa);
    		$sqlUpCapa = "UPDATE arquivos SET
                    capa = '1'
                    WHERE codReferencia = '$codAnuncio' AND codigo = '{$tpMarcaCapa['codigo']}' AND referencia = 'clientesAnuncios'";
        	$resultadoUpCapa = mysql_query($sqlUpCapa);
    	}
        
        if(isset($_SESSION['id_anuncio']))
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-finalizacao' : sslRedir().PROJECT_URL.'/anuncio-finalizacao.php';		  
    		echo "<script type='text/javascript'>
                   location.replace('".$link."');
    			 </script> \n";
                 die();
        }
        else
        {
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';		  
    		echo "<script type='text/javascript'>
                   location.replace('".$link."');
    			 </script> \n";
                 die();
        }
    }
    mysql_close();
}
$cogigoApaga = isset($_POST['codigoApaga']) ? $_POST['codigoApaga'] : '';
if($cogigoApaga != '')
{            
    $conexao = conexao();
    $objsArquivo = mysql_query("SELECT * FROM arquivos WHERE codigo='$cogigoApaga' AND referencia = 'clientesAnuncios'");
    $qtdObjsArquivo = mysql_num_rows($objsArquivo) ;
    if($qtdObjsArquivo > 0)
    {
        $pasta = PROJECT_PATH."arquivos/clientesAnuncios";
        for ($j = 0; $j < $qtdObjsArquivo; $j++)
        {
            $exc = mysql_fetch_assoc($objsArquivo);
            unlink($pasta.DIRECTORY_SEPARATOR.$exc['arquivo']);
        }
        $sql_apaga = "DELETE FROM arquivos WHERE codigo = '$cogigoApaga' AND referencia = 'clientesAnuncios'";
        $resultadoapaga = mysql_query($sql_apaga);
    	
    	$sqlSelectCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncio' AND referencia = 'clientesAnuncios' AND capa = '1'");
    	$linhasSelectCapa = mysql_num_rows($sqlSelectCapa);
    	
    	if($linhasSelectCapa == 0)
    	{
    		$sqlMarcaCapa = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncio' AND referencia = 'clientesAnuncios' AND capa = '0' LIMIT 1");
    		$tpMarcaCapa = mysql_fetch_assoc($sqlMarcaCapa);
    		$sqlUpCapa = "UPDATE arquivos SET
                    capa = '1'
                    WHERE codReferencia = '$codAnuncio' AND codigo = '{$tpMarcaCapa['codigo']}' AND referencia = 'clientesAnuncios'";
        	$resultadoUpCapa = mysql_query($sqlUpCapa);
    	}
    }
    mysql_close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
    require_once PROJECT_INC_PATH.'head.php';
    $conexao = conexao();
    $sqlVerificaCliente = mysql_query("SELECT codCliente FROM clientesAnuncios WHERE cod = $codAnuncio AND codCliente = $codCliente");
    $numVerificaCliente = mysql_num_rows($sqlVerificaCliente);
    mysql_close();
    if($codAnuncio == '' || $restrita != 1 || $numVerificaCliente == 0)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        exit();
    }
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
        $(".apagarFoto").click(function(){
            _val = $(this).attr('rel');
            $('#codigoApaga').val(_val);
            $('#formApaga').submit();
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
                <?
                if($cod == '')
                {
                ?>
                    <div class="anunciemenu">
                        <div class="anunciemenuitem" id="dados">
                            <a href="#">Dados do Anúncio</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="identificacao">
                            <a href="#">Identificação</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight separarighthover"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem anunciemenuhover" id="fotos">
                            <a href="#">Fotos</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft separalefthover"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="finalizacao">
                            <a href="#">Finalização</a>
                        </div>
                    </div>
                <?
                }
                else
                {
                ?>
                    <div class="anunciemenu">
                        <div class="anunciemenuitem" id="editardados">
                        <?
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados/'.$cod : sslRedir().PROJECT_URL.'/anuncio-dado.php?cod='.$cod;
                        ?>
                            <a href="<?=$link;?>">Dados do Veículo</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight separarighthover"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem anunciemenuhover" id="editarfotos">
                        <?
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-fotos/'.$cod : sslRedir().PROJECT_URL.'/anuncio-fotos.php?cod='.$cod;
                        ?>
                            <a href="<?=$link;?>">Fotos</a>
                        </div>
                    </div>
                <?
                }                
                ?>
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
                                        <!--<div class="fotobloco">
                                            
                                                <div class="fototopo">Faça o Upload da <b>Foto de Capa</b></div>
                                                <div class="fotoinput"><input type="file" name="fotocapa" id="fotocapa" title="Foto de Capa" /></div>
                                                <div class="fotoimg"><img style="max-height: 160px; max-width: 345;" src="" alt="Anúncio" /></div>
                                                <input type="hidden" name="acao" value="acao" id="acao" />
                                                
                                            
                                            <iframe style="display: none;" name="iframeUploadCapa"></iframe>
                                        </div>-->
                                        
                                        <?
                                        $conexao = conexao();
                                        $qNfotos = mysql_query("SELECT pr.nFotos FROM clientes AS c
                                                               INNER JOIN planosRevenda AS pr ON c.codPlanoRevenda = pr.cod
                                                               WHERE c.cod = '$codCliente'
                                                               GROUP BY pr.cod");
                                        $nNfotos  = mysql_num_rows($qNfotos );
                                        if($nNfotos  > 0)
                                        {
                                            $tpNfotos  = mysql_fetch_assoc($qNfotos );
                                            $nFotos = (int)$tpNfotos['nFotos'];
                                        }
                                        
                                        
                                        if($msg == '' && $cod == '')
                                        {
                                            if($tipoAnuncio == 1)
                                            {
                                                $sqlPlanos = mysql_query("SELECT nFotos FROM clientesAnuncios WHERE cod = '$codAnuncio'");
                                                $tpPlano = mysql_fetch_assoc($sqlPlanos);
                                                $nFotos = $tpPlano['nFotos'];
                                            }
                                            for($x = 0;$x < $nFotos;$x++)
                                            {
                                            ?>
                                                <div class="fotobloco">
                                                    <div class="fototopo">Faça o Upload da <b>Foto <?=$x == 0 ? 'de Capa' : ($x+1);?></b></div>
                                                    <div class="fotoinput"><input type="file" name="foto[]" id="foto<?=$x;?>" title="Foto <?=($x+1);?>" /></div>
                                                    <!--<div class="fotoimg"><img style="max-height: 160px; max-width: 345;" src="" alt="Anúncio" /></div>
                                                    <input type="hidden" name="acao" value="acao" id="acao" />
                                                    <input type="hidden" name="position[]" value="<?=($x);?>" id="position" />-->
                                                </div>
                                        <?
                                            }
                                        }
                                        else
                                        {
                                            $capaAux = 0;
                                            $sqlFotosInseridas = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$codAnuncio' AND tipo = '1' AND referencia = 'clientesAnuncios'");
                                            $numFotosInseridas = mysql_num_rows($sqlFotosInseridas);
                                            for($x = 0;$x < $numFotosInseridas;$x++)
                                            {
                                                $tpFotosInseridas = mysql_fetch_assoc($sqlFotosInseridas);
                                                if($tpFotosInseridas['capa'] == '1')
                                                    $capaAux = 1;
                                        ?>
                                                <div class="fotobloco">
                                                    <div class="fototopo">Capa <input type="radio" name="capa[]" id="capa<?=($x+1);?>" value="<?=$tpFotosInseridas['codigo'];?>" <?=$tpFotosInseridas['capa'] == '1' ? 'checked="checked"' : '';?> /><b>Foto <?=($x+1);?></b><a class="apagarFoto" rel="<?=$tpFotosInseridas['codigo'];?>"><img class="anuncioexcluir" src="<?=ssl().PROJECT_URL;?>/img/excluirfotoanuncio.png" alt="Excluir foto" /></a></div>
                                                    <div class="fotoimg"><img style="max-height: 160px; max-width: 345;" src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosInseridas['arquivo'];?>" alt="Anúncio" /></div>
                                                    <!--<input type="hidden" name="acao" value="acao" id="acao" />
                                                    <input type="hidden" name="position[]" value="<?=($x);?>" id="position" />-->
                                                </div>
                                        <?
                                            }
                                            if($tipoAnuncio == 1)
                                            {
                                                $sqlPlanos = mysql_query("SELECT nFotos FROM clientesAnuncios WHERE cod = '$codAnuncio'");
                                                $tpPlano = mysql_fetch_assoc($sqlPlanos);
                                                $nFotos = ($tpPlano['nFotos']-$numFotosInseridas);
                                            }
                                            else
                                            {
                                                $nFotos = ($nFotos-$numFotosInseridas);
                                            }
                                            $posicaoDaFoto = $numFotosInseridas;
                                            for($x = 0;$x < $nFotos;$x++)
                                            {
                                        ?>
                                                <div class="fotobloco">
                                                    <div class="fototopo">Faça o Upload da <b>Foto <?=$x == 0 && $capaAux == 0 ? 'de Capa' : ($posicaoDaFoto+1);?></b></div>
                                                    <div class="fotoinput"><input type="file" name="foto[]" id="foto<?=$x;?>" title="Foto <?=($posicaoDaFoto+1);?>" /></div>
                                                    <!--<div class="fotoimg"><img style="max-height: 160px; max-width: 345;" src="" alt="Anúncio" /></div>
                                                    <input type="hidden" name="acao" value="acao" id="acao" />
                                                    <input type="hidden" name="position[]" value="<?=($x);?>" id="position" />-->
                                                </div>
                                        <?
                                                $posicaoDaFoto++;
                                            }
                                        }
                                        mysql_close();
                                        ?>
                                        <!--<div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 2</b></div>
                                            <div class="fotoinput"><input type="file" name="foto2" id="foto2" title="Foto 2" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>
                                        <div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 3</b></div>
                                            <div class="fotoinput"><input type="file" name="foto3" id="foto3" title="Foto 3" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>
                                        <div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 4</b></div>
                                            <div class="fotoinput"><input type="file" name="foto4" id="foto4" title="Foto 4" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>
                                        <div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 5</b></div>
                                            <div class="fotoinput"><input type="file" name="foto5" id="foto5" title="Foto 5" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>
                                        <div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 6</b></div>
                                            <div class="fotoinput"><input type="file" name="foto6" id="foto6" title="Foto 6" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>
                                        <div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 7</b></div>
                                            <div class="fotoinput"><input type="file" name="foto7" id="foto7" title="Foto 7" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>
                                        <div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 8</b></div>
                                            <div class="fotoinput"><input type="file" name="foto8" id="foto8" title="Foto 8" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>
                                        <div class="fotobloco">
                                            <div class="fototopo">Faça o Upload da <b>Foto 9</b></div>
                                            <div class="fotoinput"><input type="file" name="foto9" id="foto9" title="Foto 9" /></div>
                                            <div class="fotoimg"><img src="http://<?=PROJECT_URL;?>/img/fotoanuncio.jpg" alt="Anúncio" /></div>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="anunciofotoenviar">
                                    <input type="submit" name="enviarDadosAnuncio" id="enviarDadosAnuncio" title="<?=$cod != '' ? 'Salvar' : 'Avançar';?>" value="<?=$cod != '' ? 'Salvar' : 'Avançar';?>" />
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