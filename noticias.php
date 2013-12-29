<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    require_once ADMIN_FUNC_PATH."formatting.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jcarousellite.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
    {
      $(".irPagina").click(function()
      {
                
            _pagina = $("#digitaPagina").val();
            _totalPaginas = $('#totaDePagina').attr('rel');
            console.log(_pagina);
            console.log(_totalPaginas);
            if(_pagina != '' && _pagina != 0)
            {
                _pagina = parseInt(_pagina) > parseInt(_totalPaginas) ? _totalPaginas : _pagina;
                _redireciona = "<?=sslRedir().PROJECT_URL;?>/noticias/"+_pagina;
    	        location.replace(_redireciona);
            }
        })
        
        $("a.paginaNoticiaAnt").mouseover(function(){
            $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertaesqhover.png");
            $(this).mouseout(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertaesq.png");
            })
        })
        $("a.paginaNoticiaProx").mouseover(function(){
            $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertadirhover.png");
            $(this).mouseout(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertadir.png");
            })
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
        if($("#detalheOfertas li").length>4){
            $("#detalheOfertas").jCarouselLite(
            {
        		btnPrev: ".ofertasPrev",
                btnNext: ".ofertasNext",
                speed: 500,
        		circular : true,
        		visible: 4,
                auto: 20000
        	});
        }
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
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Notícias</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="bannernoticia">
                <?php
                	imprimeFullBannerNoticias();
                ?>
                </div>
                <div class="noticialista">
                    <!--<div class="noticiadestaquewrap">
                        <div class="noticiadestaque">
                            <div class="noticiadestaqueimg">
                                <a href="#">
                                    <img src="<?=ssl().PROJECT_URL;?>/img/fotonoticia.jpg" alt="Notícias" />
                                </a>
                            </div>
                        </div>
                        <div class="noticiadestaquetexto">
                            <div class="noticiatag">
                                <div class="tagimg"><img src="<?=ssl().PROJECT_URL;?>/img/tag.png" alt="Dicas" /></div>
                                <div class="tagtexto">
                                    Matéria Especial
                                </div>
                            </div>
                            <div class="noticiatexto">
                                <a href="<?=$link;?>">
                                    <span class="noticiadata">24/10/2013</span>
                                    <span class="noticiatitulo">Moto elétrica Sora chega a 190 km/h</span>
                                    <b>Leia mais ...</b>
                                </a>
                            </div>
                        </div>
                    </div>-->
                <?
                $pagina = isset($pagina) ? $pagina : '';
                $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : $pagina;
                if($pagina == '1' || $pagina == '')
                {
                    $conexao = conexao();
                    $sqlNoticiasDes = mysql_query("SELECT * FROM noticias WHERE destaque = '1' ORDER BY data DESC LIMIT 1");
                    $numNoticiasDes = mysql_num_rows($sqlNoticiasDes);
                    if($numNoticiasDes > 0)
                    {
                    ?>
                        <div class="noticiadestaquewrap">
                            <?
                            for($x = 0;$x < $numNoticiasDes;$x++)
                            {
                                $tpNoticiasDes = mysql_fetch_assoc($sqlNoticiasDes);
                                $data = dataBr($tpNoticiasDes['data']);
                                $cleanTitulo = $tpNoticiasDes['cleanTitulo'];
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticia/'.$tpNoticiasDes['cod'].'/'.$tpNoticiasDes['cleanTitulo'] : sslRedir().PROJECT_URL.'/noticias-detalhe.php?cod='.$tpNoticiasDes['cod'];
                                $imagemCapa = '';
                                
                                if($tpNoticiasDes['videoDestaque'] > 0 && $tpNoticiasDes['video'] != '')
                                {
                                    $output = array();
                                    $url = $tpNoticiasDes['video'];
                                    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $output);
                                    $imagemCapa = 'http://img.youtube.com/vi/' . $output[0] . '/0.jpg';
                                }
                                else
                                {
                                    $sqlFotoDes = mysql_query("SELECT * FROM arquivos WHERE referencia = 'noticias' AND codReferencia = '{$tpNoticiasDes['cod']}' AND capa = '1' AND tipo = '2'");
                                    $numFotoDes = mysql_num_rows($sqlFotoDes);
                                    if($numFotoDes > 0)
                                    {
                                        $tpFotoDes = mysql_fetch_assoc($sqlFotoDes);
                                        $imagemCapa = ssl().PROJECT_URL.'/arquivos/noticias/'.$tpFotoDes['arquivo'];
                                    }
                                }
                                if($imagemCapa != '')
                                {
                                ?>
                                    <div class="noticiadestaque">
                                        <div class="noticiadestaqueimg">                                                                 
                                            <a href="<?=$link;?>">
                                                <img style="max-width: 361px; max-height: 265px;" src="<?=$imagemCapa;?>" alt="Notícias" />
                                            </a>
                                        </div>
                                    </div>
                                <?
                                }
                                ?>
                                <div class="noticiadestaquetexto">
                                    <?
                                    if($tpNoticiasDes['codLable'] > 0)
                                    {
                                        $sqlLableDes = mysql_query("SELECT * FROM noticiasLables WHERE cod = '{$tpNoticiasDes['codLable']}' LIMIT 1");
                                        $numLableDes = mysql_num_rows($sqlLableDes);
                                        if($numLableDes > 0)
                                        {
                                            $tpLableDes = mysql_fetch_assoc($sqlLableDes);
                                    ?>
                                            <div class="noticiatag">
                                                <div class="tagimg"><img src="<?=ssl().PROJECT_URL;?>/img/tag.png" alt="Dicas" /></div>
                                                <div class="tagtexto">
                                                    <?=$tpLableDes['titulo'];?>
                                                </div>
                                            </div>
                                        <?
                                        }
                                    }
                                    /*if(strlen($tpNoticiasDes['resumo']) > 140)
                                        $resumo = mb_substr($tpNoticiasDes['resumo'], 0, 140);
                                    else*/
                                        $resumo = $tpNoticiasDes['resumo'];
                                    ?>
                                    <div class="noticiatexto">
                                        <a href="<?=$link;?>">
                                            <span class="noticiadata"><?=$data;?></span>
                                            <span class="noticiatitulo"><?=$tpNoticiasDes['titulo'];?></span>
                                            <span class="noticiadestaquedescricao"><?=$resumo;?><b> Leia mais ...</b></span>
                                        </a>
                                    </div>
                                </div>
                            <?  
                            }
                            ?>
                        </div>
                    <?
                    }
                    mysql_close();

                }
                ?>
                    <div class="noticialistalink">
                        <?
                        $num_por_pagina = 6; 
        				if(empty($pagina))
        				{
        					$primeiro_registro = 0;
        					$pagina = 1;
        				}
        				else
        				{
        					$primeiro_registro = ($pagina - 1) * $num_por_pagina;
        				}
                        $num_por_pagina = $pagina == '' || $pagina == '1' ? 6 : 12;
                        $conexao = conexao();
                        $sqlPag = "SELECT * FROM noticias ORDER BY data DESC";
                        $sqlNoticias = mysql_query("SELECT * FROM noticias WHERE destaque <> 1 ORDER BY data DESC LIMIT $primeiro_registro,$num_por_pagina");
                        
                        $numNoticias = mysql_num_rows($sqlNoticias);
                        $resultadoPag = mysql_query($sqlPag, $conexao);
						$linhasPag = mysql_num_rows($resultadoPag);
                                                
                        if($numNoticias > 0)
                        {
                            for($x = 0;$x < $numNoticias;$x++)
                            {
                                $tpNoticias = mysql_fetch_assoc($sqlNoticias);
                                $data = dataBr($tpNoticias['data']);
                                $cleanTitulo = $tpNoticias['cleanTitulo'];
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticia/'.$tpNoticias['cod'].'/'.$tpNoticias['cleanTitulo'] : sslRedir().PROJECT_URL.'/noticias-detalhe.php?cod='.$tpNoticias['cod'];
                        ?>
                                <div class="noticiaitem">
                                <?
                                if($tpNoticias['codLable'] > 0)
                                {
                                    $sqlLable = mysql_query("SELECT * FROM noticiasLables WHERE cod = '{$tpNoticias['codLable']}' LIMIT 1");
                                    $numLable = mysql_num_rows($sqlLable);
                                    if($numLable > 0)
                                    {
                                        $tpLable = mysql_fetch_assoc($sqlLable);
                                ?>
                                        <div class="noticiatag">
                                            <div class="tagimg"><img src="<?=ssl().PROJECT_URL;?>/img/tag.png" alt="Dicas" /></div>
                                            <div class="tagtexto">
                                                <?=$tpLable['titulo'];?>
                                            </div>
                                        </div>
                                    <?
                                    }
                                }   
                                    
                                $imagemCapa = '';
                                
                                if($tpNoticias['videoDestaque'] > 0 && $tpNoticias['video'] != '')
                                {
                                    $output = array();
                                    $url = $tpNoticias['video'];
                                    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $output);
                                    $imagemCapa = 'http://img.youtube.com/vi/' . $output[0] . '/0.jpg';
                                }
                                else
                                {
                                    $sqlFoto = mysql_query("SELECT * FROM arquivos WHERE referencia = 'noticias' AND codReferencia = '{$tpNoticias['cod']}' AND capa = '1' AND tipo = '3'");
                                    $numFoto = mysql_num_rows($sqlFoto);
                                    if($numFoto > 0)
                                    {
                                        $tpFoto = mysql_fetch_assoc($sqlFoto);
                                        $imagemCapa = ssl().PROJECT_URL.'/arquivos/noticias/'.$tpFoto['arquivo'];
                                    }
                                }
                                if($imagemCapa != '')
                                {
                                ?>    
                                    <div class="noticiaimg">
                                        <a href="<?=$link;?>">
                                            <img style="max-height: 95px; max-width: 138;" src="<?=$imagemCapa;?>" alt="<?=$tpNoticias['titulo'];?>" />
                                        </a>
                                    </div>
                                <?
                                }
                                ?>
                                    <div class="noticiatexto">
                                        <a href="<?=$link;?>">
                                            <span class="noticiadata"><?=$data;?></span>
                                            <span class="noticiatitulo"><?=$tpNoticias['titulo'];?></span>
                                            <b>Leia mais ...</b>
                                        </a>
                                    </div>
                                </div>
                        <?
                            }
                        }
                        else
                        {
                        ?>
                            <div class="noticialink">
                                Nenhuma notícia encontrada.
                            </div>
                        <?
                        }
                        mysql_close();
                        ?>
                    </div>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralNoticias();
                    imprimeBannerLateralPequenoNoticias();
                    ?>
                </div>
                <?
                $total_paginas = ($linhasPag/12);
                $total_paginas = ceil($total_paginas);
                $prev = ($pagina-1);
                $next = ($pagina+1);
                
                if ($pagina > 1)
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticias/'.$prev : sslRedir().PROJECT_URL.'/noticias.php?pagina='.$prev;
                    $prev_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaoesq.png' alt='Anterior' /></a>";
                }
                else 
                { // senão não há link para a página anterior
                    $prev_link = "";
                }
                
                if ($total_paginas > 1 && $pagina < $total_paginas )
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticias/'.$next : sslRedir().PROJECT_URL.'/noticias.php?pagina='.$next;
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
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticias/'.$paginas[$x] : sslRedir().PROJECT_URL.'/noticias.php?pagina='.$paginas[$x];
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
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticias/'.$x : sslRedir().PROJECT_URL.'/noticias.php?pagina='.$x;
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
                <div class="detalheoferta">
                    <?
                    $dataHoje = date('Y-m-d');
                    $anunciosSuperDestaque = array();
                    $conexao = conexao();
                    /** Busca os anunios particulares com plano ouro **/
                    $qSuperPart = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.cleanTitulo, c.estado, c.cidade, ca.km, vm.marca, ca.valor, vv.versao, vmd.modelo,
                                            (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                            AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                            FROM clientesAnuncios AS ca
                                            INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                            INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                            INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                            LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                            WHERE c.tipoAnuncio = 1 AND c.situacao = 1 AND ca.codPlanoParticular = 4
                                            AND ca.status = 1 AND '$dataHoje' BETWEEN ca.dataLiberacaoAnuncio AND ca.dataValidadeAnuncio ORDER BY RAND() LIMIT 10");
                                            //echo mysql_error();
                    $nSuperPart = mysql_num_rows($qSuperPart);
                    if($nSuperPart > 0)
                    {
                        for($a=0;$a<$nSuperPart;$a++)
                        {
                            $tpSuperPart = mysql_fetch_assoc($qSuperPart);
                            $anunciosSuperDestaque[] = array(
                                                                'cod' => $tpSuperPart['cod'],
                                                                'cor' => $tpSuperPart['cor'],
                                                                'combustivel' => combustivel($tpSuperPart['combustivel']),
                                                                'anoFabricacao' => $tpSuperPart['anoFabricacao'],
                                                                'marca' => $tpSuperPart['marca'],
                                                                'versao' => $tpSuperPart['versao'],
                                                                'modelo' => $tpSuperPart['modelo'],
                                                                'cidade' => $tpSuperPart['cidade'],
                                                                'estado' => $tpSuperPart['estado'],
                                                                'km' => $tpSuperPart['km'],
                                                                'valor' => "R$ ".number_format((float)$tpSuperPart['valor'],2,',','.'),
                                                                'arquivo' => $tpSuperPart['arquivo'],
                                                                'anunciante' => 'Particular',
                                                                'cleanTitulo' => $tpSuperPart['cleanTitulo'],
                                                                'tipoAnuncio' => 1,
                                                            );
                        }
                        
                    }
                    /** Busca os anunios de revendas com plano 100 **/
                    $qSuperRev100 = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, vm.marca, c.nomeFantasia, c.cleanTitulo, c.tipoRevenda, ca.valor, vv.versao, vmd.modelo,
                                (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                FROM clientesAnuncios AS ca 
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                WHERE c.tipoAnuncio = 2 AND c.situacao = 1 AND ca.superDestaqueHome = '1' AND ca.destaqueHome = '0' AND ca.status = 1 AND (c.codPlanoRevenda = '2' OR c.codPlanoRevenda = '5' OR c.codPlanoRevenda = '9' OR c.codPlanoRevenda = '13' OR c.codPlanoRevenda = '22' OR c.codPlanoRevenda = '24' OR c.codPlanoRevenda = '26' OR c.codPlanoRevenda = '28')
                                ORDER BY RAND() LIMIT 15");
                                //echo mysql_error();
                    $nSuperRev100 = mysql_num_rows($qSuperRev100);
                    if($nSuperRev100 > 0)
                    {
                        for($a=0;$a<$nSuperRev100;$a++)
                        {
                            $tpSuperRev100 = mysql_fetch_assoc($qSuperRev100);
                            $anunciosSuperDestaque[] = array(
                                                                'cod' => $tpSuperRev100['cod'],
                                                                'cor' => $tpSuperRev100['cor'],
                                                                'combustivel' => combustivel($tpSuperRev100['combustivel']),
                                                                'anoFabricacao' => $tpSuperRev100['anoFabricacao'],
                                                                'marca' => $tpSuperRev100['marca'],
                                                                'versao' => $tpSuperRev100['versao'],
                                                                'modelo' => $tpSuperRev100['modelo'],
                                                                'cidade' => $tpSuperRev100['cidade'],
                                                                'estado' => $tpSuperRev100['estado'],
                                                                'km' => $tpSuperRev100['km'],
                                                                'valor' => "R$ ".number_format((float)$tpSuperRev100['valor'],2,',','.'),
                                                                'arquivo' => $tpSuperRev100['arquivo'],
                                                                'anunciante' => $tpSuperRev100['nomeFantasia'],
                                                                'cleanTitulo' => $tpSuperRev100['cleanTitulo'], 
                                                                'tipoAnuncio' => 2,
                                                            );
                        }
                        
                    }
                    /** Busca os anunios de revendas com plano 200 **/
                    $qSuperRev200 = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, vm.marca, c.nomeFantasia, c.cleanTitulo, c.tipoRevenda, ca.valor, vv.versao, vmd.modelo,
                                (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                FROM clientesAnuncios AS ca 
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                WHERE c.tipoAnuncio = 2 AND c.situacao = 1 AND ca.superDestaqueHome = '1' AND ca.destaqueHome = '0' AND ca.status = 1 AND (c.codPlanoRevenda = '1' OR c.codPlanoRevenda = '21' OR c.codPlanoRevenda = '23' OR c.codPlanoRevenda = '25' OR c.codPlanoRevenda = '27')
                                ORDER BY RAND() LIMIT 15");
                                //echo mysql_error();
                    $nSuperRev200 = mysql_num_rows($qSuperRev200);
                    if($nSuperRev200 > 0)
                    {
                        for($a=0;$a<$nSuperRev200;$a++)
                        {
                            $tpSuperRev200 = mysql_fetch_assoc($qSuperRev200);
                            $anunciosSuperDestaque[] = array(
                                                                'cod' => $tpSuperRev200['cod'],
                                                                'cor' => $tpSuperRev200['cor'],
                                                                'combustivel' => combustivel($tpSuperRev200['combustivel']),
                                                                'anoFabricacao' => $tpSuperRev200['anoFabricacao'],
                                                                'marca' => $tpSuperRev200['marca'],
                                                                'versao' => $tpSuperRev200['versao'],
                                                                'modelo' => $tpSuperRev200['modelo'],
                                                                'cidade' => $tpSuperRev200['cidade'],
                                                                'estado' => $tpSuperRev200['estado'],
                                                                'km' => $tpSuperRev200['km'],
                                                                'valor' => "R$ ".number_format((float)$tpSuperRev200['valor'],2,',','.'),
                                                                'arquivo' => $tpSuperRev200['arquivo'],
                                                                'anunciante' => $tpSuperRev200['nomeFantasia'],
                                                                'cleanTitulo' => $tpSuperRev200['cleanTitulo'], 
                                                                'tipoAnuncio' => 2,
                                                            );
                        }
                        
                    }
                    mysql_close();
                    shuffle($anunciosSuperDestaque);
                    ?>
                    <div class="ofertabloco" style="border: none;">
                  		<div class="ofertalistaSuper" id="detalheOfertas" style="overflow: hidden; margin-top:25px;">
                            <div class="ofertaheader">
                                <img src="<?=ssl().PROJECT_URL;?>/img/ofertas-premium.png" alt="Ofertas Premium" />
                                <div class="ofertaheaderlinha">&nbsp;</div>
                            </div>
                            <div class="premiumbloco">
                                <?
                                if(count($anunciosSuperDestaque) > 4)
                                {
                                ?>
                                    <a href="#" class="paginaNoticiaAnt ofertasPrev">
                                        <img alt="Anterior" src="<?=ssl().PROJECT_URL;?>/img/ofertaesq.png" />
                                    </a>
                                <?
                                }
                                ?>
                                <div class="premiumcarro">
                                    <ul>
                                    <?
                                    foreach($anunciosSuperDestaque as $k => $anuncioSuperDestaque)
                                    {
                                        $urlMarcaModelo = ($anuncioSuperDestaque['marca'] != '' ? $anuncioSuperDestaque['marca'] : '').($anuncioSuperDestaque['modelo'] ? ' '.$anuncioSuperDestaque['modelo'] : '');
                                        $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                                        if($anuncioSuperDestaque['tipoAnuncio'] == 1)
                                        {
                                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/particular/'.($anuncioSuperDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['estado']) : '').($anuncioSuperDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                                        }
                                        else
                                        {
                                            
                                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$anuncioSuperDestaque['cleanTitulo'].'/'.($anuncioSuperDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['estado']) : '').($anuncioSuperDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                                        }
                                     
                                        echo "<li>    
                                                <div class='ofertalistamedio'>
                                                    <div class='ofertalistaimgwrap'>
                                                        <div class='ofertalistaimg'><a href='".$link."'><img src='".($anuncioSuperDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioSuperDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' /></a></div>
                                                    </div>
                                                    <div class='ofertalistatexto'>
                                                        <div class='ofertalistapreco'>{$anuncioSuperDestaque['valor']}</div>
                                                        <p class='ofertalistatitulo'><span>{$anuncioSuperDestaque['marca']} {$anuncioSuperDestaque['versao']}</span></p>
                                                        <p><b>{$anuncioSuperDestaque['anunciante']}</b></p>
                                                    </div>
                                                </div>
                                            </li>";
                                      }
                                      ?>  
                                    </ul>
                                </div>
                                <?
                                if(count($anunciosSuperDestaque) > 4)
                                {
                                ?>
                                    <a href="#" class="paginaNoticiaProx ofertasNext">
                                        <img alt="Próxima" src="<?=ssl().PROJECT_URL;?>/img/ofertadir.png" />
                                    </a>
                                <?
                                }
                                ?>
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