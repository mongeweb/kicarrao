<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
require_once PROJECT_INC_PATH.'head-revendas.php';
require_once PROJECT_INC_PATH."publicidade.php";
require_once ADMIN_FUNC_PATH."formatting.php";

    $estado = isset($estado) ? str_replace("+"," ",rawurldecode($estado)) : '';
    $estado = isset($_GET['e']) ? str_replace("+"," ",rawurldecode($_POST['e'])) : $estado;
    
    $cidade = isset($cidade) ? str_replace("+"," ",rawurldecode($cidade)) : '';
    $cidade = isset($_GET['c']) ? str_replace("+"," ",rawurldecode($_POST['c'])) : $cidade;
    
    $buscaRevenda = isset($buscaRevenda) ? str_replace("+"," ",rawurldecode($buscaRevenda)) : '';
    $buscaRevenda = isset($_GET['b']) ? str_replace("+"," ",rawurldecode($_POST['b'])) : $buscaRevenda;
    
    $pagina = isset($pagina) ? $pagina : '';
    $pagina = isset($_GET['p']) ? $_GET['p'] : $pagina;
    
    $urlPaginacao = '';
    $filtroSql = '';
    if($MG_MR_Settings['active'])
    {
        if($estado != '')
           $urlPaginacao .= "/e:".str_replace(" ","+",$estado);
        if($cidade != '')
           $urlPaginacao .= "/c:".str_replace(" ","+",$cidade);
        if($buscaRevenda != '')
           $urlPaginacao .= "/b:".str_replace(" ","+",$buscaRevenda);
    }
    else
    {
        if($estado != '')
           $urlPaginacao .= "&e=".str_replace(" ","+",$estado);
        if($cidade != '')
           $urlPaginacao .= "&c=".str_replace(" ","+",$cidade);
        if($buscaRevenda != '')
           $urlPaginacao .= "&b=".str_replace(" ","+",$buscaRevenda);
    }
    if($estado != '')
       $filtroSql .= " AND estado = '".$estado."'";
    if($cidade != '')
       $filtroSql .= " AND cidade = '".$cidade."'";
    if($buscaRevenda != '')
       $filtroSql .= " AND (nomeFantasia LIKE '%".$buscaRevenda."%' OR razaoSocialNome LIKE '%".$buscaRevenda."%') ";
?>
    <script type="text/javascript">
    $(document).ready(function(){
      $('#estadoRevenda').change(function(){
        
        _junta = new Array();
        
        _estado = $("select[name='estadoRevenda'] > option:selected").val().replace(" ","+"); 
        _estado != '' ? _junta.push("e:"+_estado) : '';
        
        _busca = $(".buscaNomeRev").val().replace(" ","+");
        _busca != '' ? _junta.push("b:"+_busca) : '';
        
        _redireciona = "<?=sslRedir().PROJECT_URL;?>/revendas/"+_junta.join("/");
		location.replace(_redireciona);
      })
      $('#cidadeRevenda').change(function(){
        
        _junta = new Array();
        
        _estado = $("select[name='estadoRevenda'] > option:selected").val().replace(" ","+"); 
        _estado != '' ? _junta.push("e:"+_estado) : '';
        
         _cidade = $("select[name='cidadeRevenda'] > option:selected").val().replace(" ","+");
        _cidade != '' ? _junta.push("c:"+_cidade) : '';
        
        _busca = $(".buscaNomeRev").val().replace(" ","+");
        _busca != '' ? _junta.push("b:"+_busca) : '';
        
        _redireciona = "<?=sslRedir().PROJECT_URL;?>/revendas/"+_junta.join("/");
		location.replace(_redireciona);
      })
      
      $(".enviaBuscaRevenda").click(function(){
        
        
        _junta = new Array();
        
        _estado = $("select[name='estadoRevenda'] > option:selected").val().replace(" ","+"); 
        _estado != '' ? _junta.push("e:"+_estado) : '';
        
        _cidade = $("select[name='cidadeRevenda'] > option:selected").val().replace(" ","+"); 
        _cidade != '' ? _junta.push("c:"+_cidade) : '';
        
        _busca = $(".buscaNomeRev").val().replace(" ","+");
        _busca != '' ? _junta.push("b:"+_busca) : '';
        
        _redireciona = "<?=sslRedir().PROJECT_URL;?>/revendas/"+_junta.join("/");
        location.replace(_redireciona);
        return false;
      })
      
      $(".irPagina").click(function(){
                
            _pagina = $("#digitaPagina").val();
            _totalPaginas = $('#totaDePagina').attr('rel');
            console.log(_pagina);
            console.log(_totalPaginas);
            if(_pagina != '' && _pagina != 0)
            {
                _pagina = parseInt(_pagina) > parseInt(_totalPaginas) ? _totalPaginas : _pagina;
                _redireciona = "<?=sslRedir().PROJECT_URL;?>/revendas/p:"+_pagina+"<?=$urlPaginacao;?>";
    	        location.replace(_redireciona);
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
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Revendas</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="revendalista">
                    <div class="revendatopo">
                        <form name="revendaSelecao" id="revendaSelecao" method="post" action="" enctype="multipart/form-data">
                            <div class="inputleft">
                                <div class="inputbloco">
                                    <label for="estadoRevenda">Estado</label>
                                    <select class="selectpequeno" name="estadoRevenda" id="estadoRevenda" title="Estado">
                                        <option value="" >Selecione</option>
                                        <?
                                        $conexao = conexao();
                                        $sqlEstados = mysql_query("SELECT estado FROM clientes WHERE tipoAnuncio = '2' AND situacao = '1' GROUP BY estado ORDER BY estado");
                                        $numEstados = mysql_num_rows($sqlEstados);
                                        for($x = 0;$x < $numEstados;$x++)
                                        {
                                            $tpEstados = mysql_fetch_assoc($sqlEstados);
                                        ?>
                                            <option value="<?=$tpEstados['estado'];?>" <?=$estado == $tpEstados['estado'] ? 'selected="selected"' : '';?> ><?=$tpEstados['estado'];?></option>
                                        <?
                                        }
                                        mysql_close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="inputright">
                                <div class="inputbloco">
                                    <label for="cidadeRevenda">Cidade</label>
                                    <select class="selectgrande" name="cidadeRevenda" id="cidadeRevenda" title="Cidade">
                                        <option value="" >-</option>
                                        <?
                                        if($estado != '')
                                        {
                                            $conexao = conexao();
                                            $sqlCidades = mysql_query("SELECT cidade FROM clientes WHERE tipoAnuncio = '2' AND estado = '{$estado}' AND situacao = '1' GROUP BY cidade ORDER BY estado");
                                            $numCidades = mysql_num_rows($sqlCidades);
                                            for($x = 0;$x < $numCidades;$x++)
                                            {
                                                $tpCidades = mysql_fetch_assoc($sqlCidades);
                                        ?>
                                                <option value="<?=$tpCidades['cidade'];?>" <?=$cidade == $tpCidades['cidade'] ? 'selected="selected"' : '';?> ><?=$tpCidades['cidade'];?></option>
                                        <?
                                            }
                                            mysql_close();
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="inputleft">
                                <div class="buscainputrevenda">
                                    <label for="buscarRevenda">Buscar pelo nome da Revenda:</label>
                                    <input type="text" name="b" id="buscar" class="buscaNomeRev" title="Buscar" value="<?=$buscaRevenda;?>" />
                                    <input type="submit" <?/*name="enviarBusca"*/;?> id="enviarBusca" class="enviaBuscaRevenda" title="Buscar" value="&nbsp;" />
                                </div>
                            </div>
                        </form>
                         <div class="cadastreRevenda">
                        	<?
							$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao-revenda' : sslRedir().PROJECT_URL.'/identificacao-revenda.php';
							?>
							<a class="anunciesuarevenda" href="<?=$link;?>">&nbsp;</a>
                        </div>
                    </div>
                    <?
                    $num_por_pagina = 25; 
    				if(empty($pagina))
    				{
    					$primeiro_registro = 0;
    					$pagina = 1;
    				}
    				else
    				{
    					$primeiro_registro = ($pagina - 1) * $num_por_pagina;
    				}
                    $conexao = conexao();
                    $sqlCli = mysql_query("SELECT * FROM clientes WHERE tipoAnuncio = '2' AND situacao = '1' $filtroSql ORDER BY ordem ASC LIMIT $primeiro_registro,$num_por_pagina");
                    $numCli = mysql_num_rows($sqlCli);
                    
                    $sqlPag = "SELECT * FROM clientes WHERE tipoAnuncio = '2' AND situacao = '1' $filtroSql ORDER BY ordem ASC";
                    $resultadoPag = mysql_query($sqlPag, $conexao);
					$linhasPag = mysql_num_rows($resultadoPag);
                    if($numCli > 0)
                    {
                        for($x = 0;$x < $numCli;$x++)
                        {
                            $tpCli = mysql_fetch_assoc($sqlCli);
                    ?>
                            <div class="revendadestaque <?=$x == ($numCli-1) ? 'noborder' : '';?>">
                                <div class="revendaitem">
                                    <div class="revendaimgborda">
                                        <div class="revendaimg">
                                            <?
                                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revenda/'.$tpCli['cleanTitulo'].($tpCli['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCli['estado']) : '').($tpCli['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCli['cidade']) : '') : sslRedir().PROJECT_URL.'/revenda-lista.php?cod='.$tpCli['cod'];
                                            ?>
                                            <a href="<?=$link;?>">
                                            <?
                                            $sqlFoto = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '{$tpCli['cod']}' AND referencia = 'clienteRevenda' AND tipo = '1'");
                                            $numFoto = mysql_num_rows($sqlFoto);
                                            $tpFoto = mysql_fetch_assoc($sqlFoto)
                                            ?>
                                            <img src="<?=$numFoto > 0 ? ssl().PROJECT_URL.'/arquivos/clientesRevendas/'.$tpFoto['arquivo'] : ssl().PROJECT_URL.'/img/placeholderRevendas.jpg';?>" alt="Revenda" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="revendaitemtexto">
                                        <p class="revendaitemtitulo"><?=$tpCli['nomeFantasia'] != '' ? $tpCli['nomeFantasia'] : $tpCli['razaoSocialNome'];?></p>
                                        <p class="revendaendereco">
                                            <?=$tpCli['endereco'];?><?=$tpCli['numero'] != '' ? ", ".$tpCli['numero'] : "";?> <?=$tpCli['cidade'] != '' ? " - ".$tpCli['cidade'] : "";?> <?=$tpCli['estado'] != '' ? " / ".$tpCli['estado'] : "";?>
                                        </p>
                                        <?php
                                        if($tpCli['site'] != '')
                                        {
                                        ?>
                                            <a class="revendasite" href="<?=$tpCli['site'];?>" target="_blank">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/globo.png" alt="Site" />
                                                <span>Ver site da revenda</span>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="revendafonebloco">
                                        <div class="verfone">&nbsp;</div>
                                        <div class="revendafonewrap">
                                            <p class="revendafone">
                                                <?=$tpCli['telRes'];?><?=$tpCli['telCel'] != '' ? " <br> ".$tpCli['telCel'] : "";?>
                                            </p>
                                        </div>
                                        <div class="verestoque">
                                            <a href="<?=$link;?>"><img src="<?=ssl().PROJECT_URL;?>/img/botaoverestoque.png" alt="Ver Estoque" /></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?
                        }
                        mysql_close();
                    }
                    else
                    {
                        echo "Nenhum anúncio encontrado!";
                    }
                    ?>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralRevendas();
                    imprimeBannerLateralPequenoRevendas();
                    ?>
                </div>
                <?
                $total_paginas = ($linhasPag/$num_por_pagina);
                $total_paginas = ceil($total_paginas);
                $prev = ($pagina-1);
                $next = ($pagina+1);
                
                if ($pagina > 1)
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revendas/p:'.$prev.$urlPaginacao : sslRedir().PROJECT_URL.'/revendas.php?p='.$prev.$urlPaginacao;
                    $prev_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaoesq.png' alt='Anterior' /></a>";
                }
                else 
                { // senão não há link para a página anterior
                    $prev_link = "";
                }
                
                if ($total_paginas > 1 && $pagina < $total_paginas )
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revendas/p:'.$next.$urlPaginacao : sslRedir().PROJECT_URL.'/revendas.php?p='.$next.$urlPaginacao;
                    $next_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaodir.png' alt='Seguinte' /></a>";
                }
                else
                { 
                    $next_link = "";
                }
                
                $painel = "";  
                if ($total_paginas > 1) 
                {
                    $maxPags = 5;
                    $numeroDePaginas = $total_paginas;
                    if (($maxPags != 0) && ($total_paginas > $maxPags)) 
                    {
                        $paginas = array();
            
                        /** vaiaveis de controle **/
                        $metade = floor($maxPags / 2);
                        $metadeFim = ($maxPags % 2 == 0) ? 1 : 0;
            
                        /** Define inicio e fim das paginas **/
                        $ini = 1;
                        $fim = $numeroDePaginas;
                        while ($numeroDePaginas > $maxPags) 
                        {
                            /** Testa se inicio é menor que 0
                             * se for incrementa
                             **/
                            if (($pagina - $metade) > $ini) 
                            {
                                $ini++;
                                $numeroDePaginas--;
                            }
                            /** Testa se fim é menor que o total de páginas
                             * se for decrementa
                             **/
                            if (($pagina + $metade - $metadeFim) < $fim) 
                            {
                                $fim--;
                                $numeroDePaginas--;
                            }
                        }
            
                        /** Preenche o array com as páginas. **/
                        for ($ini; $ini <= $fim; $ini++) 
                        {
                            $paginas[] = $ini;
                        }
                    
                        for ($x=0; $x < count($paginas); $x++)
                        {
                            if ($pagina==$paginas[$x])
                            {
                                $painel .= "<div class='pagina paginahover'><a href='#'>&nbsp;$paginas[$x]&nbsp;</a></div>";
                            }
                            else
                            {
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revendas/p:'.$paginas[$x].$urlPaginacao : sslRedir().PROJECT_URL.'/revendas.php?p='.$paginas[$x].$urlPaginacao;
                                $painel .= "<div class='pagina'><a href='".$link."'>&nbsp;$paginas[$x]&nbsp;</a></div>";
                            }
                            //echo $painel;
                        }
                    }
                    else
                    {                     
                        for ($x=1; $x<=$total_paginas; $x++)
                        {
                            if ($x==$pagina)
                            {
                                $painel .= "<div class='pagina paginahover'><a href='#'>&nbsp;$x&nbsp;</a></div>";
                            }
                            else
                            {
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revendas/p:'.$x.$urlPaginacao : sslRedir().PROJECT_URL.'/revendas.php?p='.$x.$urlPaginacao;
                                $painel .= "<div class='pagina'><a href='".$link."'>&nbsp;$x&nbsp;</a></div>";
                            }
                        }
                    }
        	        ?>
                    <div class="paginacaowrap">
                        <div class="paginacaobloco">
                            <!--<div class="paginanavbloco">
                                <div id="totaDePagina" rel="<?=$total_paginas;?>">
                                    Você está na página <span><?=$pagina;?></span> de <span><?=$total_paginas;?></span>
                                </div>
                                <div>
                                    Ir para página: 
                                    <input onkeypress="return verificaNumero (event)" name="pagina" id="digitaPagina" title="Página" />
                                    <a class="irPagina" >Ir</a>
                                </div>
                            </div>-->
                            
                            <div class="buscapaginacao">
                                <div class="pagina paginaAnterior"><?=$prev_link;?></div>
                                <?=$painel;?>
                                <div class="pagina paginaSeguinte"><?=$next_link;?></div>
                            </div>
                        </div>
                    </div>
   		        <?
                }
                ?>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>