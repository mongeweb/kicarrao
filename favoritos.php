<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    require_once ADMIN_FUNC_PATH."formatting.php";
    $filtroPagina = '';
    
    $pagina = isset($pagina) ? $pagina : '';
    $pagina = isset($_GET['p']) ? $_GET['p'] : $pagina;
    
    $order = isset($order) ? $order : '';
    $order = isset($_GET['order']) ? $_GET['order'] : $order;
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
                if(_src == "<?=ssl().PROJECT_URL;?>/img/favoritohover.png")
                {
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/favorito.png");
                    $(this).parent().remove();
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
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Favoritos</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="buscalista">
                    <?php require_once PROJECT_INC_PATH.'buscatopo.php';?>
                    <div class="tabelabusca">
                        <div class="buscaheader">
                            <div class="buscaheaderfavorito">
                                Favoritos
                            </div>
                            <div class="buscaheaderfoto">&nbsp;</div>
                            <div class="buscaheadermarca" style="cursor: default !important;">
                                Marca/Modelo
                            </div>
                            <div class="buscaheaderano" style="cursor: default !important;">
                                Ano
                            </div>
                            <div class="buscaheaderkm" style="cursor: default !important;">
                                Km
                            </div>
                            <div class="buscaheaderpreco" style="cursor: default !important;">
                                Preço
                            </div>
                        </div>
                        <?
                        $num_por_pagina = 20; 
        				if(empty($pagina))
        				{
        					$primeiro_registro = 0;
        					$pagina = 1;
        				}
        				else
        				{
        					$primeiro_registro = ($pagina - 1) * $num_por_pagina;
        				}
                        $numAnuncios = 0;
                        if(isset($_COOKIE['favoritos']) && $_COOKIE['favoritos'] != '')
                        {
                            $cookirFav = unserialize($_COOKIE['favoritos']);
                            $filtroCod = '';
                            if(count($cookirFav) > 0)
                            {
                                $filtroCod .= ' AND (';
                                $auxFiltroCod = 0;
                                foreach ($cookirFav as $key => $value)
                                {
                                    $auxFiltroCod++;
                                    $filtroCod .= ($auxFiltroCod == '1' ? '' : ' OR ').' ca.cod='.$value;
                                }
                                $filtroCod .= ' ) ';
                                $dataHoje = date("Y-m-d");
                                $conexao = conexao();
                                $sqlAnuncios = mysql_query("SELECT ca.cod, ca.km, c.estado, c.cidade, ca.superDestaqueLista, ca.destaqueLista, ca.cor, ca.combustivel, ca.anoFabricacao, ca.anoModelo, vm.marca, vmd.modelo, ca.valor, ca.dataValidadeAnuncio, c.tipoAnuncio, c.cleanTitulo
                                                FROM clientesAnuncios AS ca
                                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                                WHERE ca.status = 1 AND c.situacao = 1 $filtroCod ".($orderSql != '' ? $orderSql : 'ORDER BY ca.superDestaqueLista DESC, ca.destaqueLista DESC')." LIMIT $primeiro_registro,$num_por_pagina");
                                $numAnuncios = mysql_num_rows($sqlAnuncios);
                                
                                $sqlPag = "SELECT ca.cod, ca.km, ca.superDestaqueLista, c.estado, c.cidade, ca.destaqueLista, ca.cor, ca.combustivel, ca.anoFabricacao, ca.anoModelo, vm.marca, vmd.modelo, ca.valor, ca.dataValidadeAnuncio, c.tipoAnuncio, c.cleanTitulo
                                                FROM clientesAnuncios AS ca
                                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                                WHERE ca.status = 1 AND c.situacao = 1 $filtroCod ".($orderSql != '' ? $orderSql : 'ORDER BY ca.superDestaqueLista DESC, ca.destaqueLista DESC')."";
                                
        						$resultadoPag = mysql_query($sqlPag, $conexao);
            					$linhasPag = mysql_num_rows($resultadoPag);
                                
                                if($numAnuncios > 0)
                                {
                                    for($x = 0;$x < $numAnuncios;$x++)
                                    {
                                        $tpCliAnuncios = mysql_fetch_assoc($sqlAnuncios);
                                        $verificaValidade = 0;
                                        if($tpCliAnuncios['tipoAnuncio'] == '1')
                                        {
                                            if(!$tpCliAnuncios['dataValidadeAnuncio'] >= $dataHoje)
                                                $verificaValidade = 1;
                                        }
                                        if($verificaValidade == 0)
                                        {
                                            $anos = array();
                                            
                                            $tpCliAnuncios['anoFabricacao'] != '' && $tpCliAnuncios['anoFabricacao'] != '0' ? $anos[]=$tpCliAnuncios['anoFabricacao'] : '';
                                            $tpCliAnuncios['anoModelo'] != '' && $tpCliAnuncios['anoModelo'] != '0' ? $anos[]=$tpCliAnuncios['anoModelo'] : '';
                        ?>
                        
                                            <div class="buscacoluna <?=$tpCliAnuncios['superDestaqueLista'] == '1' || $tpCliAnuncios['destaqueLista'] == '1' ? 'buscacolunadestaque' : '';?>">
                                                <?=$tpCliAnuncios['superDestaqueLista'] == '1' ? '<div class="destaquerotulo">&nbsp;</div>' : '';?>
                                                <?
                                                    $urlMarcaModelo = ($tpCliAnuncios['marca'] != '' ? $tpCliAnuncios['marca'] : '').($tpCliAnuncios['modelo'] ? ' '.$tpCliAnuncios['modelo'] : '');
                                                    $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                                                    if($tpCliAnuncios['tipoAnuncio'] == 1)
                                                    {
                                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($tpCliAnuncios['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpCliAnuncios['cod'].($tpCliAnuncios['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCliAnuncios['estado']) : '').($tpCliAnuncios['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCliAnuncios['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpCliAnuncios['cod'];
                                                    }
                                                    else
                                                    {
                                                        
                                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$tpCliAnuncios['cleanTitulo'].'/'.($tpCliAnuncios['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$tpCliAnuncios['cod'].($tpCliAnuncios['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCliAnuncios['estado']) : '').($tpCliAnuncios['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($tpCliAnuncios['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpCliAnuncios['cod'];
                                                    }
                                                    
                                                    //$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/detalhe/'.$tpCliAnuncios['cod'] : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$tpCliAnuncios['cod'];
                                                ?>
                                                <a class="buscalink" href="<?=$link;?>">&nbsp;</a>
                                                <div class="buscafavorito" rel="<?=$tpCliAnuncios['cod'];?>"><a><img src="<?=ssl().PROJECT_URL;?>/img/favoritohover.png" alt="Favorito" /></a></div>
                                                <div class="buscafoto">
                                                    <a>
                                                    <?
                                                    $sqlFotosAnuncio = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '{$tpCliAnuncios['cod']}' AND referencia = 'clientesAnuncios' AND capa = '1' AND tipo = '1'");    
                                                    $numFotosAnuncio = mysql_num_rows($sqlFotosAnuncio);
                                                    $tpFotosAnuncio = mysql_fetch_assoc($sqlFotosAnuncio);
                                                    ?>
                                                        <img style="width: 116px;" src="<?=$numFotosAnuncio > 0 ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$tpFotosAnuncio['arquivo'] : ssl().PROJECT_URL.'/img/placeholderRevendas.jpg';?>" alt="Carro" />
                                                    </a>
                                                </div>
                                                <div class="buscamarca">
                                                    <?=$tpCliAnuncios['marca'];?> <?=$tpCliAnuncios['modelo'];?>
                                                    <br /><br />
                                                    Cor: <?=$tpCliAnuncios['cor'];?>
                                                </div>
                                                <div class="buscaano"><?=implode("/",$anos);?></div>
                                                <div class="buscakm"><?=($tpCliAnuncios['km'] == '1' || $tpCliAnuncios['km'] == '0') ? " - " : $tpCliAnuncios['km'] ." km";?> </div>
                                                <div class="buscapreco">R$ <?=number_format($tpCliAnuncios['valor'],2,',','.');?></div>
                                            </div>
                    <?
                                        }
                                    }
                                }
                                mysql_close();
                            }
                        }
                        else
                        {
                            echo "<p class=\"nenhumacoluna\"> Nenhum anúncio encontrado!</p>";
                        }
                    ?>
                        
                    </div>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralFavoritos();
                    imprimeBannerLateralPequenoFavoritos();
                    ?>
                </div>
                <?
                if($numAnuncios > 0)
                {
                    $total_paginas = ($linhasPag/$num_por_pagina);
                    $prev = ($pagina-1);
                    $next = ($pagina+1);
                    
                    if ($pagina > 1)
                    {
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/favoritos/p:'.$prev.$filtroPagina : sslRedir().PROJECT_URL.'/favoritos.php?pagina='.$prev.$filtroPagina;
                        $prev_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaoesq.png' alt='Anterior' /></a>";
                    }
                    else 
                    { // senão não há link para a página anterior
                        $prev_link = "";
                    }
                    
                    if ($total_paginas > 1 && $pagina < $total_paginas )
                    {
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/favoritos/p:'.$next.$filtroPagina : sslRedir().PROJECT_URL.'/rfavoritos.php?pagina='.$next.$filtroPagina;
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
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/favoritos/p:'.$x.$filtroPagina : sslRedir().PROJECT_URL.'/favoritos.php?pagina='.$x.$filtroPagina;
                            $painel .= "<div class='pagina'><a href='".$link."'>&nbsp;$x&nbsp;</a></div>";
                        }
                    }
                    if($total_paginas > 1)
                    {
                ?>
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
                ?>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>