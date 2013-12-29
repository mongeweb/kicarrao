<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head-revenda-lista.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    require_once ADMIN_FUNC_PATH."formatting.php";
    $filtroPagina = '';
    
    $nomeRevUrl = isset($nomeRevUrl) ? mg_substituirEspacosPorTreacos($nomeRevUrl) : '';
    
    $cod = isset($cod) ? $cod : '';
    $cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
    
    $pagina = isset($pagina) ? $pagina : '';
    $pagina = isset($_GET['p']) ? $_GET['p'] : $pagina;
    
    $order = isset($order) ? $order : '';
    $order = isset($_GET['order']) ? $_GET['order'] : $order;
    
    $estadoUrlRevendas = isset($estadoUrlRevendas) ? $estadoUrlRevendas : '';
    $cidadeUrlRevendas = isset($cidadeUrlRevendas) ? $cidadeUrlRevendas : '';
    
    $orderSql = '';
    if($order != '')
    {
        $exOrder = explode('+',$order);
        $ordem = array_key_exists(0,$exOrder) ? $exOrder[0] : '';
        $ascDesc = array_key_exists(1,$exOrder) ? $exOrder[1] : '';
        $filtroPagina = $MG_MR_Settings['active'] ? '/order:'.$order : '&order='.$order;
        
        switch($ordem)
        {
            case 'marca' :
                $orderSql .= 'ORDER BY vm.marca ';
                break;
            case 'ano' :
                $orderSql .= 'ORDER BY ca.anoFabricacao ';
                break;
            case 'km' :
                $orderSql .= 'ORDER BY ca.km ';
                break;
            case 'preco' :
                $orderSql .= 'ORDER BY ca.valor ';
                break;
        }
        if($ascDesc == 'asc')
        {
            $orderSql .= ' ASC';
            $seta = 'setabuscacima';
        }
        elseif($ascDesc == 'desc')
        {
            $orderSql .= ' DESC';
            $seta = 'setabuscabaixo';
        }
    
    }
    else
    {
        $ordem = '';
        $ascDesc = '';
    }
    ?>
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
                _val = $(this).attr('rel');
                _marca = 0;
                if(_src == "<?=ssl().PROJECT_URL;?>/img/favorito.png")
                { 
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/favoritohover.png");
                    _marca = 1;
                    _favAtual = $('.selecionados').find('b').text();
                    _favAtual = parseInt(_favAtual) + 1;
                    $('.selecionados').find('b').text(_favAtual);
                    $('.selecionados').show();
                }
                if(_src == "<?=ssl().PROJECT_URL;?>/img/favoritohover.png")
                {
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/favorito.png");
                    _marca = 0;
                    _favAtual = $('.selecionados').find('b').text();
                    _favAtual = parseInt(_favAtual) - 1;
                    $('.selecionados').find('b').text(_favAtual);
                    if(_favAtual == 0)
                        $('.selecionados').hide();
                }
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxCookie.php",
                    data:
                    {
                        codFavorito: _val,
                        marca: _marca
                    
                    },
                    dataType: "json", 
                    success: function(j)
                    { 
                        
                    }
                }); 
            })
            
            $(".order").click(function(){
                
                _order = $(this).attr('rel');
                _redireciona = "<?=sslRedir().PROJECT_URL;?>/revenda/<?=$nomeRevUrl;?>/<?=$estadoUrlRevendas != '' ? $estadoUrlRevendas.'/' : '';?><?=$cidadeUrlRevendas != '' ? $cidadeUrlRevendas.'/' : '';?>order:"+_order;
    		   location.replace(_redireciona);
            })
            
            $(".irPagina").click(function(){
                
                _pagina = $("#digitaPagina").val();
                _totalPaginas = $('#totaDePagina').attr('rel');
                console.log(_pagina);
                console.log(_totalPaginas);
                if(_pagina != '' && _pagina != 0)
                {
                    _pagina = parseInt(_pagina) > parseInt(_totalPaginas) ? _totalPaginas : _pagina;
                    _redireciona = "<?=sslRedir().PROJECT_URL;?>/revenda/<?=$nomeRevUrl;?>/<?=$estadoUrlRevendas != '' ? $estadoUrlRevendas.'/' : '';?><?=$cidadeUrlRevendas != '' ? $cidadeUrlRevendas.'/' : '';?>p:"+_pagina+"<?=$filtroPagina;?>";
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
<?
$conexao = conexao();
$sqlCliente = mysql_query("SELECT * FROM clientes WHERE cleanTitulo = '$nomeRevUrl' AND tipoAnuncio = '2' AND situacao = '1' LIMIT 1");
$numCliente = mysql_num_rows($sqlCliente);
if($nomeRevUrl == '' || $numCliente < 1)
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    printf("<script type='text/javascript'>
                document . location . replace('%s');
            </script>", $link);
    exit();
}
$tpCli = mysql_fetch_assoc($sqlCliente);
mysql_close();
?>
<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            $link2 = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revendas' : sslRedir().PROJECT_URL.'/revendas.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<a href="<?=$link2;?>">Revendas</a>&nbsp; &gt; &nbsp;<span><?=$tpCli['nomeFantasia'] != '' ? $tpCli['nomeFantasia'] : $tpCli['razaoSocialNome'];?></span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="buscalista">
                    <div class="bannerbusca">
                        <?php
                        imprimeBannerSuperRevendaLista();
                        ?>
                    </div>
                    <div class="revendabannerbloco">
                        <?
                        $conexao = conexao();
                        $sqlFotoRev = mysql_query("SELECT arquivo, (SELECT arquivo FROM arquivos WHERE codReferencia = '{$tpCli['cod']}' AND referencia = 'bannerRevenda' AND tipo = '1') AS arquivoBanner FROM arquivos WHERE codReferencia = '{$tpCli['cod']}' AND referencia = 'clienteRevenda' AND tipo = '1'");
                        //echo mysql_error();
                        $numFotoRev = mysql_num_rows($sqlFotoRev);
                        $tpFotoRev = mysql_fetch_assoc($sqlFotoRev);
                        mysql_close();
                        ?>
                        <div class="revendabannerimg">
                            <?php
                            if($numFotoRev > 0 && $tpFotoRev['arquivoBanner'] != '')
                            {
                            ?>
                                <!--<img src="<?=ssl().PROJECT_URL;?>/img/bannerRevendedor.png" alt="" />-->
                                <img src="<?=ssl().PROJECT_URL.'/arquivos/clientesRevendas/'.$tpFotoRev['arquivoBanner'];?>" alt="" style="border-radius:8px"/>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="revendabannerconteudo">
                            <div class="revendabannerfundo">&nbsp;</div>
                            <div class="revendabannertexto">
                                <div class="revendabannerlogo">
                                    <a <?=$tpCli['site'] != '' ? 'href="'.$tpCli['site'].'" target="_blank"' : '';?>>
                                        <img src="<?=$numFotoRev > 0 ? ssl().PROJECT_URL.'/arquivos/clientesRevendas/'.$tpFotoRev['arquivo'] : ssl().PROJECT_URL.'/img/placeholderRevLista.jpg';?>" alt="<?=$tpCli['nomeFantasia'] != '' ? $tpCli['nomeFantasia'] : $tpCli['razaoSocialNome'];?>" />
                                        <!--<img src="<?=ssl().PROJECT_URL;?>/img/logoRevendedor.png" alt="Fones" />-->
                                    </a>
                                </div>
                                <div class="revendabanneresq">
                                    <p class="revendaitemtitulo">
                                        <?=$tpCli['nomeFantasia'] != '' ? $tpCli['nomeFantasia'] : $tpCli['razaoSocialNome'];?>
                                    </p>
                                    <p class="revendaendereco">
                                        <?=$tpCli['endereco'];?><?=$tpCli['numero'] != '' ? ", ".$tpCli['numero'] : "";?> <?=$tpCli['cidade'] != '' ? "<br />".$tpCli['bairro']." - ".$tpCli['cidade'] : "";?> <?=$tpCli['estado'] != '' ? " / ".$tpCli['estado'] : "";?>
                                    </p>
                                </div>
                                <div class="revendabannerdir">
                                    <div class="revendafonebloco">
                                        <p class="revendafone">
                                            <img src="<?=ssl().PROJECT_URL;?>/img/telefoneRevendedor.png" alt="Fones" />
                                            <span><?=$tpCli['telRes'];?><?=$tpCli['telCel'] != '' ? " <br> ".$tpCli['telCel'] : "";?></span>
                                        </p>
                                    </div>
                                    <?
                                    if($tpCli['site'] != '')
                                    {
                                    ?>
                                        <a class="revendasite" href="<?=$tpCli['site'];?>" target="_blank">
                                            <img src="<?=ssl().PROJECT_URL;?>/img/globo.png" alt="Site" />
                                            <span>Ver site da revenda</span>
                                        </a>
                                    <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabelabusca">
                        <div class="buscaheader">
                            <div class="buscaheaderfavorito">
                                Favoritos
                            </div>
                            <div class="buscaheaderfoto">&nbsp;</div>
                            <div class="buscaheadermarca order <?=$ordem == 'marca' ? 'vermelho' : '';?>" rel="marca+<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Marca/Modelo
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img/<?=$ordem == 'marca' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
                            </div>
                            <div class="buscaheaderano order <?=$ordem == 'ano' ? 'vermelho' : '';?>" rel="ano+<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Ano
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img//<?=$ordem == 'ano' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
                            </div>
                            <div class="buscaheaderkm order <?=$ordem == 'km' ? 'vermelho' : '';?>" rel="km+<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Km
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img//<?=$ordem == 'km' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
                            </div>
                            <div class="buscaheaderpreco order <?=$ordem == 'preco' ? 'vermelho' : '';?>" rel="preco+<?=$ascDesc == 'asc' ? 'desc' : 'asc';?>">
                                Preço
                                <a class="setafiltro"><img src="<?=sslRedir().PROJECT_URL;?>/img//<?=$ordem == 'preco' ? $seta.'hover' : 'setabuscabaixo';?>.png" /></a>
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
                        $dataHoje = date("Y-m-d");
                        $conexao = conexao();
                        $sqlAnuncios = mysql_query("SELECT ca.cod, ca.km, ca.superDestaqueLista, ca.destaqueLista, ca.cor, ca.combustivel, ca.anoFabricacao, ca.anoModelo, vm.marca, vmd.modelo, ca.valor
                                        FROM clientesAnuncios AS ca
                                        INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                        INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                        WHERE ca.codCliente = '{$tpCli['cod']}' AND ca.status = 1 ".($orderSql != '' ? $orderSql : 'ORDER BY ca.superDestaqueLista DESC, ca.destaqueLista DESC')." LIMIT $primeiro_registro,$num_por_pagina");
                        $numAnuncios = mysql_num_rows($sqlAnuncios);
                        
                        $sqlPag = "SELECT ca.cod, ca.km, ca.superDestaqueLista, ca.destaqueLista, ca.cor, ca.combustivel, ca.anoFabricacao, ca.anoModelo, vm.marca, vmd.modelo, ca.valor
                                        FROM clientesAnuncios AS ca
                                        INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                        INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                        WHERE ca.codCliente = '{$tpCli['cod']}' AND ca.status = 1 ".($orderSql != '' ? $orderSql : 'ORDER BY ca.superDestaqueLista DESC, ca.destaqueLista DESC')."";
                        
						$resultadoPag = mysql_query($sqlPag, $conexao);
    					$linhasPag = mysql_num_rows($resultadoPag);
                        
                        if($numAnuncios > 0)
                        {
                            for($x = 0;$x < $numAnuncios;$x++)
                            {
                                $tpCliAnuncios = mysql_fetch_assoc($sqlAnuncios);
                                $anos = array();
                                
                                $tpCliAnuncios['anoFabricacao'] != '' ? $anos[]=$tpCliAnuncios['anoFabricacao'] : '';
                                $tpCliAnuncios['anoModelo'] != '' ? $anos[]=$tpCliAnuncios['anoModelo'] : '';
                        ?>
                                <div class="buscacoluna <?=$tpCliAnuncios['superDestaqueLista'] == '1' || $tpCliAnuncios['destaqueLista'] == '1' ? 'buscacolunadestaque' : '';?>">
                                    <?=$tpCliAnuncios['superDestaqueLista'] == '1' ? '<div class="destaquerotulo">&nbsp;</div>' : '';?>
                                    <?
                                        $urlMarcaModelo = ($tpCliAnuncios['marca'] != '' ? $tpCliAnuncios['marca'] : '').($tpCliAnuncios['modelo'] ? ' '.$tpCliAnuncios['modelo'] : '');
                                        $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$nomeRevUrl.'/'.($tpCliAnuncios['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo."-".$tpCliAnuncios['cod'].($estadoUrlRevendas != '' ? '/'.$estadoUrlRevendas : '').($cidadeUrlRevendas != '' ? '/'.$cidadeUrlRevendas : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpCliAnuncios['cod'];
                                        
                                    $favoritoImg = 'favorito';
                                    if(isset($_COOKIE['favoritos']) && $_COOKIE['favoritos'] != '')
                                    {
                                        $cookirFav = unserialize($_COOKIE['favoritos']);
                                        if(in_array($tpCliAnuncios['cod'],$cookirFav))
                                        {
                                            $favoritoImg = 'favoritohover';
                                        }
                                    }
                                    ?>    
                                    <div class="buscafavorito" rel="<?=$tpCliAnuncios['cod'];?>"><a><img src="<?=ssl().PROJECT_URL;?>/img/<?=$favoritoImg;?>.png" alt="Favorito" /></a></div>
                                    <div class="buscafoto">
                                        <a href="<?=$link;?>">
                                        <?
                                        $sqlFotosAnuncio = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '{$tpCliAnuncios['cod']}' AND referencia = 'clientesAnuncios' AND capa = '1' AND tipo = '1'");    
                                        $numFotosAnuncio = mysql_num_rows($sqlFotosAnuncio);
                                        $tpFotosAnuncio = mysql_fetch_assoc($sqlFotosAnuncio);
                                        ?>
                                            <img style="width: 116px;" src="<?=$numFotosAnuncio > 0 ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$tpFotosAnuncio['arquivo'] : ssl().PROJECT_URL.'/img/placeholderRevendas.jpg';?>" alt="Carro" />
                                        </a>
                                    </div>
                                    <div class="buscamarca">
                                        <a href="<?=$link;?>">
                                            <?=$tpCliAnuncios['marca'];?> <?=$tpCliAnuncios['modelo'];?>
                                            <br /><br />
                                            Cor: <?=$tpCliAnuncios['cor'];?>
                                        </a>
                                    </div>
                                    <div class="buscaano">
                                        <a href="<?=$link;?>">
                                            <?=implode("/",$anos);?>
                                        </a>
                                    </div>
                                    <div class="buscakm">
                                        <a href="<?=$link;?>">
                                            <?=($tpCliAnuncios['km'] == '1' || $tpCliAnuncios['km'] == '0') ? " - " : $tpCliAnuncios['km'] ." km";?>
                                        </a> 
                                    </div>
                                    <div class="buscapreco">
                                        <a href="<?=$link;?>">
                                            R$ <?=number_format($tpCliAnuncios['valor'],2,',','.');?>
                                        </a>
                                    </div>
                                </div>
                        <?
                            }
                            mysql_close();
                        }
                        else
                        {
                            echo "<p class=\"nenhumacoluna\">
										<br>
										Recentemente fechamos parceria com o Kicarrão.<br>
										Em poucos dias nossos estoques estarão disponíveis.<br><br>
										Agradecemos a compreensão!<br><br>
										".$tpCli['nomeFantasia']."
								  </p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralRevendaLista();
                    imprimeBannerLateralPequenoRevendaLista();
                    ?>
                </div>
                <?
                if($numAnuncios > 0)
                {
                    $total_paginas = ($linhasPag/$num_por_pagina);
                    $total_paginas = ceil($total_paginas);
                    $prev = ($pagina-1);
                    $next = ($pagina+1);
                    $painel = "";  
                    if ($pagina > 1)
                    {
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revenda/'.$nomeRevUrl.($estadoUrlRevendas != '' ? '/'.$estadoUrlRevendas : '').($cidadeUrlRevendas != '' ? '/'.$cidadeUrlRevendas : '').'/p:'.$prev.$filtroPagina : sslRedir().PROJECT_URL.'/revenda-lista.php?pagina='.$prev.'&cod='.$cod.$filtroPagina;
                        $prev_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaoesq.png' alt='Anterior' /></a>";
                    }
                    else 
                    { // senão não há link para a página anterior
                        $prev_link = "";
                    }
                    
                    if ($total_paginas > 1 && $pagina < $total_paginas )
                    {
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revenda/'.$nomeRevUrl.($estadoUrlRevendas != '' ? '/'.$estadoUrlRevendas : '').($cidadeUrlRevendas != '' ? '/'.$cidadeUrlRevendas : '').'/p:'.$next.$filtroPagina : sslRedir().PROJECT_URL.'/revenda-lista.php?pagina='.$next.'&cod='.$cod.$filtroPagina;
                        $next_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaodir.png' alt='Seguinte' /></a>";
                    }
                    else
                    { 
                        $next_link = "";
                    }
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
                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revenda/'.$nomeRevUrl.($estadoUrlRevendas != '' ? '/'.$estadoUrlRevendas : '').($cidadeUrlRevendas != '' ? '/'.$cidadeUrlRevendas : '').'/p:'.$paginas[$x].$filtroPagina : sslRedir().PROJECT_URL.'/revenda-lista.php?pagina='.$paginas[$x].'&cod='.$cod.$filtroPagina;
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
                                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revenda/'.$nomeRevUrl.($estadoUrlRevendas != '' ? '/'.$estadoUrlRevendas : '').($cidadeUrlRevendas != '' ? '/'.$cidadeUrlRevendas : '').'/p:'.$x.$filtroPagina : sslRedir().PROJECT_URL.'/revenda-lista.php?pagina='.$x.'&cod='.$cod.$filtroPagina;
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
                }
                ?>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>