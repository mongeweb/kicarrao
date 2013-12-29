<?php require_once 'configRoot.php';
unset($_SESSION['id_anuncio']);
$tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : '1';
$tipoRevendaSes = isset($_SESSION['tipoRevenda']) ? $_SESSION['tipoRevenda'] : '1';
$codCliente = isset($_SESSION['codCliente']) ? $_SESSION['codCliente'] : '';

if($restrita != 1)
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    printf("<script type='text/javascript'>
                document . location . replace('%s');
            </script>", $link);
    exit();
}
$cogigoApaga = isset($_POST['codigoApaga']) ? $_POST['codigoApaga'] : '';
if($cogigoApaga != '')
{            
    $conexao = conexao();
    $objsArquivo = mysql_query("SELECT * FROM arquivos WHERE codReferencia='$cogigoApaga' AND referencia = 'clientesAnuncios'");
    $qtdObjsArquivo = mysql_num_rows($objsArquivo) ;
    if($qtdObjsArquivo > 0)
    {
        $pasta = PROJECT_PATH."arquivos/clientesAnuncios";
        for ($j = 0; $j < $qtdObjsArquivo; $j++)
        {
            $exc = mysql_fetch_assoc($objsArquivo);
            unlink($pasta.DIRECTORY_SEPARATOR.$exc['arquivo']);
        }
        $sqlApagaFoto = "DELETE FROM arquivos WHERE codReferencia = '$cogigoApaga' AND referencia = 'clientesAnuncios'";
        $resultadoapaga = mysql_query($sqlApagaFoto);
    }
    $sqlApaga = mysql_query("DELETE FROM clientesAnuncios WHERE cod = '$cogigoApaga'");
    $sqlApagaAcessorios = mysql_query("DELETE FROM acessoriosAnuncios WHERE codAnuncio = '$cogigoApaga'");
    mysql_close();
    if($sqlApaga)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        exit();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("div.buscamarca").each(function()
            {
                _marcaheight = $(this).height();
                _anoheight = $(this).siblings("div.buscaano").height();
                _kmheight = $(this).siblings("div.buscakm").height();
                _anoheight = _kmheight = _marcaheight;
                $(this).siblings("div.buscaano").css({'height':_anoheight});
                $(this).siblings("div.buscakm").css({'height':_kmheight});
            })
            
            
            $("div.buscafavorito").click(function()
            {
                _src = $(this).find("img").attr("src");
                if(_src == "<?=ssl().PROJECT_URL;?>/img/favorito.png")
                { 
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/favoritohover.png");
                }
                if(_src == "<?=ssl().PROJECT_URL;?>/img/favoritohover.png")
                {
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/favorito.png");
                }
            })
            /*
            $("input#enviarCsv").click(function(){
                console.log($("input#file").val());
                if($("input#file").val() != ''){
                    alert("Arquivo enviado com sucesso!");
                    location.replace("<?=ssl().PROJECT_URL;?>/meus-anuncios.php");
                }else{
                    alert("Nenhum arquivo encontrado!");
                }
            })  
            //*/
            
            $(".buscaexcluir").click(function(){
                _codAnuncio = $(this).attr('rel');
                _confirmacao = confirm("Tem certeza que deseja apagar esse registro ?");
                if(_confirmacao == true)
                {
                    $('#codigoApaga').val(_codAnuncio);
                    $('#formApaga').submit();
                }
            })
            
            $("div.paginaAnterior").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaoesqhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaoesq.png");    
                })
            })
            $("div.paginaSeguinte").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaodirhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaodir.png");    
                })
            })  
        })
    </script>
</head>
<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';
          require_once ADMIN_FUNC_PATH."formatting.php";
    ?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Meus Anúncios</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral" style="position: relative;">
                <?
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/planos' : sslRedir().PROJECT_URL.'/anuncio-planos.php';
                ?>
                <a class="inserirAnuncio" href="<?=$link;?>">Inserir Anúncio</a>
                <div class="meusanunciosbloco" id="anuncioparticular">
                    <?
                    if($tipoAnuncio == '2' && $tipoRevendaSes == '1')
                    {
                        $submitCsv = isset($_POST['enviarCsv']) ? $_POST['enviarCsv'] : '';
                        if($submitCsv != '')
                        {
                            $nOfertas = 0;
                            $conexao = conexao();
                            $qNofertas = mysql_query("SELECT pr.nOfertas FROM clientes AS c
                                                   INNER JOIN planosRevenda AS pr ON c.codPlanoRevenda = pr.cod
                                                   WHERE c.cod = '$codCliente'
                                                   GROUP BY pr.cod");
                            $nNofertas = mysql_num_rows($qNofertas);
                            if($nNofertas > 0)
                            {
                                $tpNofertas = mysql_fetch_assoc($qNofertas);
                                $nOfertas = (int)$tpNofertas['nOfertas'];
                            }
                            
                            $msg = array(
                                            0 => "Importação realizada com sucesso!",
                                            1 => "Erro ao realizar importação. Erro desconhecido!",
                                            2 => "Erro ao realizar importação. Número de colunas incorreto!",
                                            3 => "Erro ao realizar importação. Ordem das colunas incorreta ou nome da coluna incorreta!",
                                            4 => "Importação realizada com sucesso. O limite de anúncios foi atingido e alguns registros não puderam ser inseridos.",
                                            5 => "Importação realizada com sucesso. Existem códigos duplicados e estes não puderam ser inseridos.",
                                        );
                            $name = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $nome = PROJECT_PATH."csv/".$codCliente.time().".".$ext;
                            $tmp = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : '';
                            $move = move_uploaded_file($tmp,$nome);
                            $codigos = array();
                            $regs = array();
                            $linha = 0;
                            $erro = 0;
                            $cont = 0;
                            if($move)
                            {
                                $rows = file($nome);
                                foreach($rows as $kRow => $row)
                                {
                                    $cols = explode(";",$row);
                                    if($kRow==0)
                                    {
                                        if(count($cols) != 14)
                                        {
                                            $erro = 2;
                                            break;
                                        }
                                        else
                                        {
                                            foreach($cols as $kCol => $col)
                                            {
                                                $col = trim($col);
                                                //echo $kCol.": ".$col."<br />";
                                                if($kCol == 0 && $col != 'CODIGO')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 1 && $col != 'TIPO-DE-VEICULO')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 2 && $col != 'PLACA')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 3 && $col != 'ANO-FABRICACAO')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 4 && $col != 'ANO-MODELO')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 5 && $col != 'COR')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 6 && $col != 'COMBUSTIVEL')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 7 && $col != 'KM')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 8 && $col != 'NUMERO-DE-PORTAS')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 9 && $col != 'VALOR')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 10 && $col != 'NUMERO-DE-PARCELAS')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 11 && $col != 'VALOR-DA-PARCELA')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 12 && $col != 'VALOR-DA-ENTRADA')
                                                {
                                                    $erro = 3;
                                                }
                                                else if($kCol == 13 && $col != 'CARACTERISTICAS')
                                                {
                                                    $erro = 3;
                                                }
                                                
                                                if($erro == 3)
                                                {
                                                    break 2;
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        //echo "Linha: ".$linha."<br />";
                                        $size = 16;
                                        
                                        foreach($cols as $kCol => $col)
                                        {
                                            //echo "Coluna: $kCol val: ".$col."<br />";
                                            $codigoRow = (int)$cols[0];
                                            if($codigoRow != 0)
                                            {
                                                if($kCol == 0 && in_array($codigoRow,$codigos))
                                                {
                                                    $erro = 5;
                                                    break;
                                                }
                                                else
                                                {
                                                    $campo = '';
                                                    $col = trim($col);
                                                    if($kCol == 0 || $kCol == 1 || $kCol == 3 || $kCol == 4 || $kCol == 6 || $kCol == 7 || $kCol == 8 || $kCol == 10)
                                                    {
                                                        $col  = (int)$col;
                                                        if($kCol == 1)
                                                        {
                                                            $col = $col == 1 || $col == 2 || $col == 3 || $col == 4 ? $col : 1;  
                                                        }
                                                        if($kCol == 6)
                                                        {
                                                            $col = $col == 1 || $col == 2 || $col == 3 || $col == 4 || $col == 5 || $col == 6 || $col == 7 ? $col : 1;  
                                                        }
                                                    }
                                                    else if($kCol == 2)
                                                    {
                                                        $col = str_replace(array(" ","-"),"",$col);
                                                        $col = strlen($col) > 7 ? substr($col,0,7) : $col;
                                                    }
                                                    else if($kCol == 9 || $kCol == 11 || $kCol == 12)
                                                    {
                                                        $col = str_replace(",",".",$col);
                                                        $col = str_replace("R$","",$col);
                                                        $col = (float)trim($col);
                                                    }
                                                    $col = htmlspecialchars(utf8_encode($col));
                                                    switch($kCol)
                                                    {
                                                        case 0:
                                                        {
                                                            $campo = "codigo";
                                                            break;
                                                        }
                                                        case 1:
                                                        {
                                                            $campo = "tipoVeiculo";
                                                            break;
                                                        }
                                                        case 2:
                                                        {
                                                            $campo = "placa";
                                                            break;
                                                        }
                                                        case 3:
                                                        {
                                                            $campo = "anoFabricacao";
                                                            break;
                                                        }
                                                        case 4:
                                                        {
                                                            $campo = "anoModelo";
                                                            break;
                                                        }
                                                        case 5:
                                                        {
                                                            $campo = "cor";
                                                            break;
                                                        }
                                                        case 6:
                                                        {
                                                            $campo = "combustivel";
                                                            break;
                                                        }
                                                        case 7:
                                                        {
                                                            $campo = "km";
                                                            break;
                                                        }
                                                        case 8:
                                                        {
                                                            $campo = "nPortas";
                                                            break;
                                                        }
                                                        case 9:
                                                        {
                                                            $campo = "valor";
                                                            break;
                                                        }
                                                        case 10:
                                                        {
                                                            $campo = "nParcelas";
                                                            break;
                                                        }
                                                        case 11:
                                                        {
                                                            $campo = "valorParcela";
                                                            break;
                                                        }
                                                        case 12:
                                                        {
                                                            $campo = "valorEntrada";
                                                            break;
                                                        }
                                                        case 13:
                                                        {
                                                            $campo = "caractVeiculo";
                                                            break;
                                                        }
                                                    }
                                                    if($campo != '')
                                                    {
                                                        if($kCol == 0)
                                                        {
                                                            $qCodigo = mysql_query("SELECT cod FROM clientesAnuncios WHERE codigo = '$col' AND codCliente = '$codCliente' LIMIT 1");
                                                            //echo mysql_error();
                                                            $nCodigo = mysql_num_rows($qCodigo);
                                                            if($nCodigo > 0)
                                                            {
                                                                $tpCodigo = mysql_fetch_assoc($qCodigo);
                                                                $regs[$linha]['campos'][] = "cod";
                                                                $regs[$linha]['valores'][] = "'{$tpCodigo['cod']}'";
                                                                $codigos[] = $col;
                                                                $size += 1;
                                                                
                                                                $qDel = mysql_query("DELETE FROM clientesAnuncios WHERE cod = '{$tpCodigo['cod']}'");
                                                            }
                                                            $regs[$linha]['campos'][] = "codCliente";
                                                            $regs[$linha]['valores'][] = "'$codCliente'";
                                                            
                                                            $regs[$linha]['campos'][] = "status";
                                                            $regs[$linha]['valores'][] = "'1'";
                                                        }
                                                        $regs[$linha]['campos'][] = $campo;
                                                        $regs[$linha]['valores'][] = "'$col'";
                                                    }
                                                }
                                            }
                                        }
                                        if(isset($regs[$linha]) && count($regs[$linha])>0)
                                        {
                                            $regs[$linha]['size'] = $size;
                                        }
                                        //echo "<hr />";
                                        $linha++;
                                    }
                                }
                                $qTot = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '{$codCliente}'");
            					$ofertasCad = mysql_num_rows($qTot);
                                //echo $ofertasCad."<br />";
                                //$nOfertas = 5;
                                
                                foreach($regs as $r => $v)
                                {
                                    //echo count($v['campos'])."<br />";
                                    $nCampos = count($v['campos']);
                                    $nValores = count($v['valores']);
                                    $limite =  $v['size'];
                                    if($nCampos == $limite && $nValores == $limite)
                                    {
                                        $cont++;
                                        if(($cont+$ofertasCad) <= $nOfertas)
                                        {
                                            $sqlIns =  "INSERT INTO clientesAnuncios (".implode(",",$v['campos']).") VALUES (".implode(",",$v['valores']).")";
                                            ///*
                                            for($a=0;$a<5;$a++)
                                            {
                                                
                                                $qIns = mysql_query($sqlIns);
                                                if($qIns)
                                                {
                                                    break;
                                                }
                                              
                                            }
                                            //*/
                                            //echo $sqlIns."<br />";
                                        }
                                        else
                                        {
                                            $erro = 4;
                                            break;
                                        }
                                        
                                    }
                                }
                                echo "<script>alert('{$msg[$erro]}');</script>";
                                /*
                                echo "<pre>";    
                                print_r($ar);
                                echo "</pre>";
                                //*/
                                @unlink($nome);
                            }
                            else
                            {
                                echo "<script>alert('Erro ao realizar upload de arquivo!');</script>";
                            }
                        }
                        mysql_close();
                    ?>
                        <!--<form name="formCsv" id="formCsv" method="post" action="" enctype="multipart/form-data">
                            <div class="csvbloco">
                                <p class="csvtitulo">Faça o upload do arquivo .csv para importar seus anúncios no site:</p>
                                <div class="csvinput">
                                    <input type="file" name="file" id="file" title="Importar CSV" />
                                    <input type="submit" name="enviarCsv" id="enviarCsv" title="Enviar" value="Enviar" />
                                </div>
                            </div>
                        </form>
                        <a target="_blank" href="<?=sslRedir().PROJECT_URL;?>/csv.php">Download da tabela de anúncios</a>-->
                        <div class="anuncioinclusao">
                            <div class="inclusaoindividual">
                            <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados' : sslRedir().PROJECT_URL.'/anuncio-dados.php';
                            ?>
                                <a href="<?=$link;?>">Incluir anúncio individual</a>
                            </div>
                            <div class="inclusaomeio">
                                <div class="inclusaolinha">&nbsp;</div>
                                <div class="ou">Ou</div>
                                <div class="inclusaolinha">&nbsp;</div>
                            </div>
                            <div class="inclusaoarquivo">
                                <form name="formCsv" id="formCsv" method="post" action="" enctype="multipart/form-data">
                                    <div class="csvbloco">
                                        <p class="csvtitulo">Incluir múltiplos anúncios</p>
                                        <div class="csvinput">
                                            <input type="file" name="file" id="file" title="Arquivo" />
                                            <input type="submit" name="enviarCsv" id="enviarCsv" title="Enviar" value="Enviar" />
                                        </div>
                                    </div>
                                </form>
                                <a target="_blank" href="<?=sslRedir().PROJECT_URL;?>/csv.php">Download da tabela de anúncios</a>    
                            </div>
                        </div>
                        
                    <?
                    }
                    $pagina = isset($pagina) ? (int)$pagina : 0;
                    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : $pagina;
                    
                    $num_por_pagina = 15; 
    				if($pagina == 0)
    				{
    					$primeiro_registro = 0;
    					$pagina = 1;
    				}
    				else
    				{
    					$primeiro_registro = ($pagina - 1) * $num_por_pagina;
    				}
                    
                    $conexao = conexao();
                    $sqlCliAnuncios = mysql_query("SELECT * FROM clientesAnuncios WHERE codCliente = '{$codCliente}' AND status <= '1' LIMIT $primeiro_registro,$num_por_pagina");
                    echo mysql_error();
                    $numCliAnuncios = mysql_num_rows($sqlCliAnuncios);
                    $sqlCli = mysql_query("SELECT * FROM clientes WHERE cod = '{$codCliente}'");
                    $tpCli = mysql_fetch_assoc($sqlCli);
                    $tipoRevenda = $tpCli['tipoRevenda'];
                    
                    $sqlPag = "SELECT * FROM clientesAnuncios WHERE codCliente = '{$codCliente}' AND status <= '1'";
                    $resultadoPag = mysql_query($sqlPag, $conexao);
					$linhasPag = mysql_num_rows($resultadoPag);
                    ?>
                    <form name="formApaga" id="formApaga" method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" value="" name="codigoApaga" id="codigoApaga" />
                    </form>
                    <div class="buscaheader">
                        <div class="buscaheaderbotoes">&nbsp;</div>
                        <div class="buscaheadermarca" style="width:265px; cursor:default;">Dados do Anúncio</div>
                        <div class="buscaheaderkm" style="width:211px; cursor:default;">Detalhes</div>
                        <div class="buscaheaderpreco" style="width:183px; cursor:default;">Ações</div>
                    </div>
                    <?
                    if($numCliAnuncios > 0)
                    {
                        for($x = 0;$x < $numCliAnuncios;$x++)
                        {
                            $tpCliAnuncios = mysql_fetch_assoc($sqlCliAnuncios);
                            
                            if($tpCliAnuncios['status'] != '2' && $tpCliAnuncios['status'] != '3')
                            {
                                if($tpCliAnuncios['status'] == 0)
                                {
                                    $sqlCliRenov = mysql_query("SELECT cod FROM clientesAnuncios WHERE cod = '{$tpCliAnuncios['codRenovacao']}' AND status <= '1'");
                                    $nRenov = mysql_num_rows($sqlCliRenov);
                                    if($nRenov > 0)
                                    {
                                        continue;
                                    }
                                }
                    ?>
                                <div class="meusanuncioscoluna">   
                                    <?
                                    $anos = array();
                                    $marca = '';
                                    $modelo = '';
                                    if($tpCliAnuncios['marca'] != 0)
                                    {
                                        $sqlMarca = mysql_query("SELECT marca FROM veiculosMarcas WHERE cod='{$tpCliAnuncios['marca']}'");
                                        $tpMarca = mysql_fetch_assoc($sqlMarca);
                                        $marca = $tpMarca['marca'];
                                    }
                                    if($tpCliAnuncios['modelo'] != 0)
                                    {
                                        $sqlModelo = mysql_query("SELECT modelo FROM veiculosModelos WHERE cod='{$tpCliAnuncios['modelo']}'");
                                        $tpModelo = mysql_fetch_assoc($sqlModelo);
                                        $modelo = $tpModelo['modelo'];
                                    }
                                    $tpCliAnuncios['anoFabricacao'] != '' && $tpCliAnuncios['anoFabricacao'] != '0' ? $anos[]=$tpCliAnuncios['anoFabricacao'] : '';
                                    $tpCliAnuncios['anoModelo'] != '' && $tpCliAnuncios['anoModelo'] != '0' ? $anos[]=$tpCliAnuncios['anoModelo'] : '';
                                    $sqlFotos = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '{$tpCliAnuncios['cod']}' AND referencia = 'clientesAnuncios' AND capa = '1' AND tipo = '1'");    
                                    $numFotos = mysql_num_rows($sqlFotos);
                                                                        
                                    $urlMarcaModelo = ($marca != '' ? $marca : '').($modelo ? ' '.$modelo : '');
                                    $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                                    if($tpCli['tipoAnuncio'] == 1)
                                    {
                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($tpCliAnuncios['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpCliAnuncios['cod'].($tpCli['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCli['estado']) : '').($tpCli['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCli['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpCliAnuncios['cod'];
                                    }
                                    else
                                    {
                                        
                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$tpCli['cleanTitulo'].'/'.($tpCliAnuncios['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpCliAnuncios['cod'].($tpCli['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCli['estado']) : '').($tpCli['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCli['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpCliAnuncios['cod'];
                                    }
                                    $tpFotos = mysql_fetch_assoc($sqlFotos);
                                    ?>
                                    <div class="buscafoto">
                                        <a href="<?=$link;?>">
                                            <img style="width: 116px;" src="<?=$numFotos > 0 ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$tpFotos['arquivo'] : ssl().PROJECT_URL.'/img/placeholderBuscaAnuncios.jpg';?>" alt="Carro" />
                                        </a>
                                    </div>
                                    <div class="buscamarca" style="width:280px;">
                                        <?php
                                        if($tipoAnuncio == 1)
                                        {
                                            echo "Plano: ".$tpCliAnuncios['plano']."<br /><br />";
                                        }
                                        ?>
                                        <?=$marca;?> <?=$modelo;?>
                                        <?=count($anos) > 0 ? "<br />Ano: ".implode("/",$anos) : "";?>
                                        <br />Valor: R$ <?=number_format($tpCliAnuncios['valor'],2,',','.');?> 
                                    </div>
                                    <div class="buscaano" style="width:211px; text-align: left;">
                                        Data de Liberação: <?=$tpCliAnuncios['dataLiberacaoAnuncio'] != '0000-00-00' ? dataBr($tpCliAnuncios['dataLiberacaoAnuncio']) : ' - ';?>
                                        <br />
                                        Data de Validade: <?=$tpCliAnuncios['dataValidadeAnuncio'] != '0000-00-00' ? dataBr($tpCliAnuncios['dataValidadeAnuncio']) : ' - ';?>
                                        <br />
                                        Status:
                                        <?php
                                        switch($tpCliAnuncios['status'])
                                        {
                                            case 0:
                                                echo "Aguardando liberaçao";
                                                break;
                                            case 1:
                                                echo "Ativo";
                                                break;
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="buscamarca" style="border-right: 0px; width: 173px;">
                                            <?php
                                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados/'.$tpCliAnuncios['cod'] : sslRedir().PROJECT_URL.'/anuncio-dados.php?cod='.$tpCliAnuncios['cod'];
                                            ?>
                                            <div class="editaranuncio"><a href="<?=$link;?>">Editar</a></div>
                                            <?
                                            if($tipoAnuncio == '1')
                                            {
                                                $qRenov = mysql_query("SELECT cod, planoValor FROM clientesAnuncios WHERE codRenovacao = '{$tpCliAnuncios['cod']}' AND status = '0'");
                                                $nRenov = mysql_num_rows($qRenov);
                                                if($tpCliAnuncios['status'] == 1 && $nRenov < 1)
                                                {
                                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-renovacao-dados/'.$tpCliAnuncios['cod'] : sslRedir().PROJECT_URL.'/anuncio-renovacao-dados.php?cod='.$tpCliAnuncios['cod'];
                                                    ?>
                                                        <div class="renovaranuncio"><a href="<?=$link;?>">Renovar Anúncio</a></div>
                                                    <?
                                                }
                                                else
                                                {
                                                    
                                                    if($nRenov > 0)
                                                    {
                                                        $tpRenov = mysql_fetch_assoc($qRenov);
                                                        if($tpRenov['planoValor'] > 0)
                                                        {
                                                            $sqlVerificaBoleto = mysql_query("SELECT cod FROM boletos WHERE codAnuncio = '{$tpRenov['cod']}' ORDER BY cod DESC LIMIT 1");
                                                            $numVerificaBoleto = mysql_num_rows($sqlVerificaBoleto);
                                                            if($numVerificaBoleto > 0)
                                                            {
                                                                $tpBol = mysql_fetch_assoc($sqlVerificaBoleto);
                                                            ?>
                                                                <div class="renovaranuncio"><a target="_blank" href="<?=sslRedir().PROJECT_URL.'/boleto/visualizar.php?b='.base64_encode($tpBol['cod']);?>">Visualizar Boleto</a></div>
                                                            <?
                                                            }
                                                            else
                                                            {
                                                                $sqlVerificaCartao = mysql_query("SELECT cod FROM pagamentos WHERE codAnuncio = '{$tpRenov['cod']}' ORDER BY cod DESC LIMIT 1");
                                                                $numVerificaCartao = mysql_num_rows($sqlVerificaCartao);
                                                                if($numVerificaCartao > 0)
                                                                {
                                                                    //$tpCartao = mysql_fetch_assoc($sqlVerificaCartao);
                                                                ?>
                                                                    <!--<div class="renovaranuncio"><a href="#">dados do Cartão</a></div>-->
                                                                <?
                                                                }
                                                                else
                                                                {
                                                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-renovacao-finalizacao/'.base64_encode($tpRenov['cod']) : sslRedir().PROJECT_URL.'/anuncio-renovacao-finalizacao.php?cod='.base64_encode($tpRenov['cod']);
                                                                ?>
                                                                    <div class="renovaranuncio"><a href="<?=$link;?>">Pagar renovação</a></div>
                                                                <?php
                                                                }
                                                                ?>      
                                                            <?
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if($tpCliAnuncios['planoValor'] > 0)
                                                        {
                                                            $sqlVerificaBoleto = mysql_query("SELECT cod FROM boletos WHERE codAnuncio = '{$tpCliAnuncios['cod']}' ORDER BY cod DESC LIMIT 1");
                                                            $numVerificaBoleto = mysql_num_rows($sqlVerificaBoleto);
                                                            if($numVerificaBoleto > 0)
                                                            {
                                                                $tpBol = mysql_fetch_assoc($sqlVerificaBoleto);
                                                            ?>
                                                                <div class="renovaranuncio"><a target="_blank" href="<?=sslRedir().PROJECT_URL.'/boleto/visualizar.php?b='.base64_encode($tpBol['cod']);?>">Visualizar Boleto</a></div>
                                                            <?
                                                            }
                                                            else
                                                            {
                                                                $sqlVerificaCartao = mysql_query("SELECT cod FROM pagamentos WHERE codAnuncio = '{$tpCliAnuncios['cod']}' ORDER BY cod DESC LIMIT 1");
                                                                $numVerificaCartao = mysql_num_rows($sqlVerificaCartao);
                                                                if($numVerificaCartao > 0)
                                                                {
                                                                    //$tpCartao = mysql_fetch_assoc($sqlVerificaCartao);
                                                                ?>
                                                                    <!--<div class="renovaranuncio"><a href="#">dados do Cartão</a></div>-->
                                                                <?
                                                                }
                                                                else
                                                                {
                                                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-finalizacao/'.base64_encode($tpCliAnuncios['cod']) : sslRedir().PROJECT_URL.'/anuncio-finalizacao.php?cod='.base64_encode($tpCliAnuncios['cod']);
                                                                ?>
                                                                    <div class="renovaranuncio"><a href="<?=$link;?>">Pagar anúncio</a></div>
                                                                <?php
                                                                }
                                                                ?>      
                                                            <?
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            if($tipoRevenda != '2')
                                            {
                                                if($tipoAnuncio == '2' || ($tipoAnuncio == '1' && $nRenov < 1))
                                                {
                                            ?>
                                                    <div style="height: 26px; display:block; border-left: 0px; float: left; margin-top: 10px; text-align: center; width: 100%; padding-left: 0px;" class="buscaexcluir" rel="<?=$tpCliAnuncios['cod'];?>"><a><img src="<?=sslRedir().PROJECT_URL;?>/img/anuncio-excluir.png" /></a></div>
                                            <?
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?
                                        $qAnunc = mysql_query("SELECT cod FROM clientesAnuncios WHERE codRenovacao = '{$tpCliAnuncios['cod']}'");
                                        $nAnunc = mysql_num_rows($qAnunc);
                                        if($nAnunc > 0)
                                        {
                                        ?>
                                            <br />
                                            <div class="meusanunciostexto">Este anúncio foi renovado recentemente. Para alterar os dados do novo anúncio, aguarde a aprovação/ativação do administrador do portal.</div>
                                        <?
                                        }
                                        ?>
                                </div>
                        <?
                            }
                        }
                        $total_paginas = ($linhasPag/$num_por_pagina);
                        $prev = ($pagina-1);
                        $next = ($pagina+1);
                        
                        if ($pagina > 1)
                        {
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios/'.$prev : sslRedir().PROJECT_URL.'/meus-anuncios.php?pagina='.$prev;
                            $prev_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaoesq.png' alt='Anterior' /></a>";
                        }
                        else 
                        { // senão não há link para a página anterior
                            $prev_link = "";
                        }
                        
                        if ($total_paginas > 1 && $pagina < $total_paginas )
                        {
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios/'.$next : sslRedir().PROJECT_URL.'/meus-anuncios.php?pagina='.$next;
                            $next_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaodir.png' alt='Seguinte' /></a>";
                        }
                        else
                        { 
                            $next_link = "";
                        }
                        
                        $total_paginas = ceil($total_paginas);
                        $painel = "";                       
                        for ($x=1; $x<=$total_paginas; $x++)
                        {
                            if ($x==$pagina)
                            {
                                $painel .= "<div class='pagina paginahover'><a href='#'>&nbsp;$x&nbsp;</a></div>";
                            }
                            else
                            {
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios/'.$x : sslRedir().PROJECT_URL.'/meus-anuncios.php?pagina='.$x;
                                $painel .= "<div class='pagina'><a href='".$link."'>&nbsp;$x&nbsp;</a></div>";
                            }
                        }
                        if($total_paginas > 1)
                        {
                    ?>
                            <br class="clear" /><br class="clear" />
                            <div class="paginacaowrap">
                                <div class="paginacaobloco">
                                    <div class="buscapaginacao">
                                        <div class="pagina paginaAnterior"><?=$prev_link;?></div>
                                        <?=$painel;?>
                                        <div class="pagina paginaSeguinte"><?=$next_link;?></div>
                                    </div>
                                </div>
                            </div>
                    <?
                        }
                    }
                    else
                    {
                        echo "<p class='nenhumacoluna'>Nenhum anúncio encontrado!</p>";
                    }
                    mysql_close();
                    ?>
                    <!--<div class="meusanuncioscoluna">
                        <div class="buscabotoes">
                            <div class="editaranuncio"><a href="#">Editar</a></div>
                            <div class="renovaranuncio"><a href="#">Renovar Anúncio</a></div>
                        </div>
                        <div class="buscafoto"><a><img src="http://<?=PROJECT_URL;?>/img/resultadobusca2.jpg" alt="Carro" /></a></div>
                        <div class="buscamarca">
                            FIAT PALIO 1.0 MPI FIRE ECONOMY
                            <br /><br />
                            Cor: Azul
                        </div>
                        <div class="buscaano">2011/2012</div>
                        <div class="buscakm">29000 km</div>
                        <div class="buscapreco">R$ 19.500,00</div>
                        <div class="buscaexcluir"><a><img src="http://<?=PROJECT_URL;?>/img/anuncio-excluir.png" /></a></div>
                    </div>-->
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>