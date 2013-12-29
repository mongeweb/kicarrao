<?php require_once 'configRoot.php';?>
<?php
	$robot = array(
		'google' => 'Google',
		'slurp'  => 'Yahoo',
		'msn'    => 'MSN',
		'ask'    => 'ASK',
		'alexa'  => 'Alexa',
		'UOL'    => 'UOL'
	);

	foreach($robot as $key => $bot) {
		if(preg_match('/('.$key.')/i', $_SERVER['HTTP_USER_AGENT'])) {
			$visit_url = $_SERVER['HTTPS'] ? "https://" : "http://";
			$visit_url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		
			$visit_dt = date("d/m/Y h:i:s");
			$line = $bot." -> ".$visit_dt." - ".$visit_url."\r\n";
			$file = fopen("googlebot.txt","a");
			fwrite($file, $line);
			fclose($file);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head.php';
    require_once ADMIN_FUNC_PATH."formatting.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jcarousellite.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            if($("#bannerSuper li").length > 1)
            {
                _indexSup = 0;
            	_arr = new Array;
            	$("#bannerSuper li").each(function(){
            		_indexSup++;
            		_arr.push("#elipSuper"+_indexSup);
            	})
                $("#bannerSuper").jCarouselLite({
                		btnPrev: ".superPrev",
                        btnNext: ".superNext",
                        btnGo:_arr,
                        speed: 1500,
                		circular : true,
                		visible: 1,
                        boxElipse: 'div.controleSuper',
                		auto: 20000
                	});
                 $("div.controleSuper").show();
            }
            
            if($("#bannerDestaque li").length > 1)
            {
                _indexDest = 0;
            	_arr = new Array;
            	$("#bannerDestaque li").each(function(){
            		_indexDest++;
            		_arr.push("#elipDestaque"+_indexDest);
            	})
                $("#bannerDestaque").jCarouselLite({
                		btnPrev: ".destaquePrev",
                        btnNext: ".destaqueNext",
                        btnGo:_arr,
                        speed: 1500,
                		circular : true,
                		visible: 1,
                        boxElipse: 'div.controleDestaque',
                		auto: 20000
                	});
                 $("div.controleDestaque").show();
            }
			//
        	if($(".banner li").length > 1)
            {
                _index = 0;
            	_arr = new Array;
            	$(".banner li").each(function(){
            		_index++;
            		_arr.push("#elip"+_index);
            	})
            	$(".banner").jCarouselLite({
            		btnGo:_arr,
            		speed: 1500,
            		circular : true,
            		visible: 1,
            		auto: 13000
            	});
            	$("div.controle").show();
            }
            $("div.guiamenuitem").click(function(){
                $("div.guiamenuitem").removeClass("guiamenuitemhover");
                if($(this).hasClass("guiamenuitem")){
                    $(this).addClass("guiamenuitemhover");
                }else{
                    $(this).removeClass("guiamenuitemhover");
                }
            })
            
            
            
            $('#tipo').change(function()
            {
                if($(this).val())
                {
                    $('#marca').hide();
                    $('.carregando').show();
                    
                    $.ajax(
                    {
                        type: "POST",
                        url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxMarca.php",
                        data:
                        {
                            cod: $(this).val()
                        
                        },
                        dataType: "json", 
                        success: function(j)
                        { 
                            var options = '<option value="">-</option>';	
                            var separador = 0;
                            for (var i = 0; i < j.length; i++) 
                            {
                                if(separador == 0 && j[i].destaque == 0)
        						{
        							options += '<option value="" disabled="disabled">&nbsp;</option>';
        							separador = 1;
        						}
                                options += '<option value="' + j[i].cod + '">' + j[i].marca + '</option>';
                            }	
                            $('#marca').html(options).show();
                            $('.carregando').hide();
                        }
                    });              
                }
                else
                {
                    $('#marca').html('<option value="">-</option>');
                    $('#modelo').html('<option value="">-</option>');
                }
            })
            
            $('#marca').change(function()
            {
                if($(this).val())
                {
                    $('#modelo').hide();
                    $('.carregando').show();
                    
                    $.ajax(
                    {
                        type: "POST",
                        url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxModelo.php",
                        data:
                        {
                            cod: $(this).val()
                        
                        },
                        dataType: "json", 
                        success: function(j)
                        { 
                            var options = '<option value="">-</option>';	
                            for (var i = 0; i < j.length; i++) 
                            {
                                options += '<option value="' + j[i].cod + '">' + j[i].modelo + '</option>';
                            }	
                            $('#modelo').html(options).show();
                            $('.carregando').hide();
                        }
                    });              
                }
                else
                {
                    $('#modelo').html('<option value="">-</option>');
                }
            })
            
            $('#anoInicial').change(function()
            {
                if($(this).val())
                {
                    $('#anoFinal').hide();
                    //$('#carregandoAnoModelo').show();
                    
                    $.ajax(
                    {
                        type: "POST",
                        url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxAnosModelo.php",
                        data:
                        {
                            ano: $(this).val()
                        
                        },
                        dataType: "json", 
                        success: function(j)
                        { 
                            options = '';
                            for (var i = 0; i < j.length; i++) 
                            {
                                options += '<option value="' + j[i].ano + '">' + j[i].ano + '</option>';
                            }	
                            $('#anoFinal').html(options).show();
                            //$('#carregandoAnoModelo').hide();
                        }
                    });              
                }
                else
                {
                    $('#anoFinal').html('<option value="">-</option>');
                }
            })
        })
    </script>
    
</head>

<body>
<?php require_once PROJECT_INC_PATH.'alexa.php';?>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="centro">
    	<div class="centroinside">
        	<div class="centrotopo">
                <div class="centroesq">
                    <?php //require_once PROJECT_INC_PATH.'login.php';?>
                    <div class="anunciebloco">
                        <?
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/planos' : sslRedir().PROJECT_URL.'/anuncio-planos.php';
                        ?>
                       <!-- <a href="< ?=$link;?>">
                            <span class="anunciehometitulo">ANUNCIE</span>
                            <span class="anunciehometexto">SEU VEÍCULO NO KICARRÃO</span>
                        </a>-->
                        <a href="<?=$link;?>">
                        <img src="<?=ssl().PROJECT_URL;?>/img/banneranuncie.jpg" alt="Anuncie" />
                        </a>
                    </div>
                </div>
                <div class="centromeio">
                    <div class="veiculosbloco">
                        <p class="veiculostitulo">Veículos<img src="<?=ssl().PROJECT_URL;?>/img/iconeveiculos.png" alt="Veículos" /></p>
                        <?
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/' : sslRedir().PROJECT_URL.'/busca.php';
                        ?>
                        <form name="buscaVeiculo" id="buscaVeiculo" action="<?=$link;?>" method="get">
                            <div class="buscafiltro">
                                <div class="filtro">
                                    <input checked="true" type="radio" class="check" name="filtroBusca" id="filtroBuscaRevenda" value="2" title="Selecionar filtro" />
                                    <span>Revendas</span>
                                </div>
                                <div class="filtro">
                                    <input type="radio" class="check" name="filtroBusca" id="filtroBuscaParticular" value="1" title="Selecionar filtro" />
                                    <span>Particulares</span>
                                </div>
                            </div>
                        	<div class="veiculoinput">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" id="tipo" title="Tipo" class="dropmaior">
                                    <option value="">-</option>
                                    <?php
                                        $conexao = conexao();
                                    	$qTipos = mysql_query("SELECT * FROM tipoVeiculo");
                                        $nTipos = mysql_num_rows($qTipos);
                                        for($x = 0;$x < $nTipos;$x++)
                                        {
                                            $tpTipos = mysql_fetch_assoc($qTipos);
                                    ?>
                                            <option value="<?=$tpTipos['cod'];?>"><?=$tpTipos['tipoVeiculo'];?></option>
                                    <?php
                                    	}
                                        mysql_close();
                                    ?>
                                </select>
                            </div>
                            <div class="veiculoinput">
                                <label for="marca">Marca</label>
                                <select name="marca" id="marca" title="Marca" class="dropmaior">
                                    <option value="">-</option>
                                    <?php
                                    /*
                                    	$sqlMarcas = mysql_query("SELECT * FROM veiculosMarcas ORDER BY marca");
                                        $numMarcas = mysql_num_rows($sqlMarcas);
                                        for($x = 0;$x < $numMarcas;$x++)
                                        {
                                            $tpMarcas = mysql_fetch_assoc($sqlMarcas);
                                    ?>
                                            <option value="<?=$tpMarcas['cod'];?>"><?=$tpMarcas['marca'];?></option>
                                    <?php
                                    	}
                                    //*/
                                    ?>
                                </select>
                            </div>
                            <div class="veiculoinput">
                                <label for="modelo">Modelo</label>
                                <select name="modelo" id="modelo" title="Modelo" class="dropmaior">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div class="veiculoselect">
                                <label for="anoInicial">Ano</label>
                                <div class="duploselect">
                                    <select name="anoInicial" id="anoInicial" title="Ano" class="dropmenor">
                                        <option value="">-</option>
                                        <?php
                                        $anosRange = range(date("Y"),1900);
                                        foreach($anosRange as $k => $ano)
                                        {
                                            ?>
                                            <option value="<?=$ano;?>"><?=$ano;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span>&nbsp;&nbsp;a&nbsp;&nbsp;</span>
                                    <select name="anoFinal" id="anoFinal" title="Ano" class="dropmenor">
                                        <option value="">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="veiculoselect">
                                <label for="precoInicial">Preço</label>
                                <div class="duploselect">
                                    <input onkeypress="return verificaNumero(event)" type="text" name="precoInicial" id="precoInicial" title="Preço" />
                                    <span style="float: none;">&nbsp;&nbsp;a&nbsp;&nbsp;</span>
                                    <input onkeypress="return verificaNumero(event)" type="text" name="precoFinal" id="precoFinal" title="Preço" />
                                </div>
                            </div>
                            <div class="veiculoinput">
                            	<label for="codigo">Código</label>
                            	<input onkeypress="return verificaNumero(event)" type="text" name="codigo" id="codigo" title="Código" />
                            </div>
                            <div class="veiculosubmit">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca-avancada' : sslRedir().PROJECT_URL.'/busca-avancada.php';
                                ?>
                                <a href="<?=$link;?>">Busca avançada</a>
                                <input type="submit" <? /*name="enviarBuscaVeiculo"*/;?> id="enviarBuscaVeiculo" title="Buscar" value="&nbsp;" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="centrodir">
                    <?php
						require_once PROJECT_INC_PATH."publicidade.php";
                        imprimeBannerRetanguloTopo();
					?>
                </div>
                
            </div>
            <div class="centropropaganda">
                <?php
                	imprimeFullBanner();
                ?>
            </div>
            <div class="ofertabloco">
                <?php
                $anunciosSuperDestaque = array();
                $anunciosDestaque = array();
                $numPorPaginaSuperDestaque = 12;
                $numPorPaginaDestaque = 12;
                
                $dataHoje = date("Y-m-d");
                
                $codSuper = isset($codSuper) ? $codSuper : 1;
                $codSuper = isset($_GET['codSuper']) ? $_GET['codSuper'] : $codSuper;
                
                $codDestaque = isset($codDestaque) ? $codDestaque : 1;
                $codDestaque = isset($_GET['codDestaque']) ? $_GET['codDestaque'] : $codDestaque;
                
                $filtroSuper = '';
                switch($codSuper)
                {
                    case 3:
                    {
                        /** SUPER DESTAQUE - OUTROS **/
                        $filtroSuper = 'AND ca.tipoVeiculo != 1 AND ca.tipoVeiculo != 2';
                        /** SUPER DESTAQUE - OUTROS **/
                        break;
                    }
                    case 2:
                    {
                        /** SUPER DESTAQUE - MOTO **/
                        $filtroSuper = 'AND ca.tipoVeiculo = 2';
                        /** SUPER DESTAQUE - MOTO **/
                        break;
                    }
                    case 1:
                    default:
                    {
                        /** SUPER DESTAQUE - CARROS **/
                        $filtroSuper = 'AND ca.tipoVeiculo = 1';
                        /** SUPER DESTAQUE - CARROS **/
                        break;
                    }
                }
                $conexao = conexao();
                $qSuperPart = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.cleanTitulo, c.estado, c.cidade, ca.km, vm.marca, ca.valor, vv.versao, vmd.modelo,
                                        (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                        AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                        FROM clientesAnuncios AS ca
                                        INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                        INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                        INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                        LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                        WHERE c.tipoAnuncio = 1 AND c.situacao = 1 $filtroSuper AND ca.codPlanoParticular = 4
                                        AND ca.status = 1 AND '$dataHoje' BETWEEN ca.dataLiberacaoAnuncio AND ca.dataValidadeAnuncio");
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
                
                $qSuperRev = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, vm.marca, c.nomeFantasia, c.cleanTitulo, c.tipoRevenda, ca.valor, vv.versao, vmd.modelo,
                                        (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                        AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                        FROM clientesAnuncios AS ca 
                                        INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                        INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                        INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                        LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                        WHERE c.tipoAnuncio = 2 AND c.situacao = 1 $filtroSuper AND ca.superDestaqueHome = '1' AND ca.destaqueHome = '0' AND ca.status = 1
                                        ORDER BY RAND()");
                                        //echo mysql_error();
                $nSuperRev = mysql_num_rows($qSuperRev);
                if($nSuperRev > 0)
                {
                    for($a=0;$a<$nSuperRev;$a++)
                    {
                        $tpSuperRev = mysql_fetch_assoc($qSuperRev);
                        $anunciosSuperDestaque[] = array(
                                                            'cod' => $tpSuperRev['cod'],
                                                            'cor' => $tpSuperRev['cor'],
                                                            'combustivel' => combustivel($tpSuperRev['combustivel']),
                                                            'anoFabricacao' => $tpSuperRev['anoFabricacao'],
                                                            'marca' => $tpSuperRev['marca'],
                                                            'versao' => $tpSuperRev['versao'],
                                                            'modelo' => $tpSuperRev['modelo'],
                                                            'cidade' => $tpSuperRev['cidade'],
                                                            'estado' => $tpSuperRev['estado'],
                                                            'km' => $tpSuperRev['km'],
                                                            'valor' => "R$ ".number_format((float)$tpSuperRev['valor'],2,',','.'),
                                                            'arquivo' => $tpSuperRev['arquivo'],
                                                            'anunciante' => $tpSuperRev['nomeFantasia'],
                                                            'cleanTitulo' => $tpSuperRev['cleanTitulo'], 
                                                            'tipoAnuncio' => 2,
                                                        );
                    }
                    
                }
                mysql_close();
                shuffle($anunciosSuperDestaque);
                
                $linkCarros = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home/?codSuper=1&codDestaque='.$codDestaque : sslRedir().PROJECT_URL.'/home.php?codSuper=1&codDestaque='.$codDestaque;
                $linkMotos = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home/?codSuper=2&codDestaque='.$codDestaque : sslRedir().PROJECT_URL.'/home.php?codSuper=2&codDestaque='.$codDestaque;
                $linkOutros = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home/?codSuper=3&codDestaque='.$codDestaque : sslRedir().PROJECT_URL.'/home.php?codSuper=3&codDestaque='.$codDestaque;
                ?>
                <div class="ofertamenu ofertamenuSuper">
                    <div class="ofertamenuitem">
                        <a href="<?=$linkCarros;?>" class="<?=$codSuper == 1 ? 'ofertahover' : '';?>">OFERTAS DE CARRO</a>
                    </div>
                    
                    
                    <div class="ofertamenuitem ofertaborda">
                        <a href="<?=$linkMotos;?>" class="<?=$codSuper == 2 ? 'ofertahover' : '';?>">OFERTAS DE MOTO</a>
                    </div>
                    
                    
                    
                    <div class="ofertamenuitem">
                        <a href="<?=$linkOutros;?>" class="<?=$codSuper == 3 ? 'ofertahover' : '';?>">OUTRAS OFERTAS</a>
                    </div>
                </div>
          		<div class="ofertalistaSuper" id="bannerSuper" style="overflow: hidden;">
                    <ul>
                        <li>
                            <?php
                            $keySuperDestaque = 0;
                            $aux = 0;
                            $lisSuperDestaque = array();
                            if(count($anunciosSuperDestaque) > 0)
                            {
                                foreach($anunciosSuperDestaque as $k => $anuncioSuperDestaque)
                                {
                                    //echo var_dump($anuncio);
                                    $aux++;
                                    if($anuncioSuperDestaque['tipoAnuncio'] == 1)
                                    {
                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/detalhe/'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['anunciante'] != 'Particular' ? "/".mg_substituirEspacosPorTreacos($anuncioSuperDestaque['anunciante']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                                    }
                                    else
                                    {
                                        $urlMarcaModelo = ($anuncioSuperDestaque['marca'] != '' ? $anuncioSuperDestaque['marca'] : '').($anuncioSuperDestaque['modelo'] ? ' '.$anuncioSuperDestaque['modelo'] : '');
                                        $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$anuncioSuperDestaque['cleanTitulo'].'/'.($anuncioSuperDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioSuperDestaque['cod'].($anuncioSuperDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['estado']) : '').($anuncioSuperDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioSuperDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioSuperDestaque['cod'];
                                    }
                                    $lisSuperDestaque[$keySuperDestaque][] = "
                                            <div class='ofertalistamedio'>
                                                <div class='ofertalistaimgwrap'>
                                                    <div class='ofertalistaimg'><a href='".$link."'><img src='".($anuncioSuperDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioSuperDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' /></a></div>
                                                    <div class='ofertalistapreco'>{$anuncioSuperDestaque['valor']} </div>
                                                </div>
                                                <div class='ofertalistatexto'>
                                                    <p class='ofertalistatitulo'><span>{$anuncioSuperDestaque['marca']} {$anuncioSuperDestaque['versao']}</span></p>
                                                    <p>{$anuncioSuperDestaque['combustivel']} | {$anuncioSuperDestaque['cor']} | {$anuncioSuperDestaque['anoFabricacao']}</p>
                                                    <p><b>{$anuncioSuperDestaque['anunciante']}</b></p>
                                                </div>
                                            </div>";
											// variável retirada por solicitação do cliente pois estava repetindo nome do veículo
											//{$anuncioSuperDestaque['marca']}
                                    if($aux==$numPorPaginaSuperDestaque || $k == count($anunciosSuperDestaque)-1)
                                    {
                                        $aux=0;
                                        $lisSuperDestaque[$keySuperDestaque] = implode("",$lisSuperDestaque[$keySuperDestaque]);
                                        $keySuperDestaque++;
                                        
                                    }
                                }
                                $super = implode("</li><li>",$lisSuperDestaque);
                                echo $super;
                            }
                            else
                            {
                                echo "Nenhum anúncio nesta categoria!";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
          		<div class="ofertapaginacao controleSuper" style="display: none;">
                	<a class="paginaOfertaAnt superPrev" href="#"><img src="<?=ssl().PROJECT_URL;?>/img/setaesq.png" alt="Anterior" /></a>
        			<?
        			/*$qtd = count($lisSuperDestaque);
        			for($i=0;$i<$qtd;$i++)
        			{
        			?>
        				<img class="elipse paginaOferta" id="elipSuper<?=$i+1;?>" src="<?=ssl().PROJECT_URL;?>/img/elipse.png" alt="Página" />
        			<?
        			}*/
        			?>
                    <span class="barraoferta">&nbsp;</span>
            		<a class="paginaOfertaProx superNext" href="#"><img src="<?=ssl().PROJECT_URL;?>/img/setadir.png" alt="Próxima" /></a>
                </div>
            </div>
            <div class="publicidadebloco">
            	<?php
                imprimeBannerRetangulo();
                ?>
            </div>
            <?php
            $filtroDest = '';
            switch($codDestaque)
            {
                case 3:
                {
                    /** DESTAQUE - OUTROS **/
                    $filtroDest = 'AND ca.tipoVeiculo != 1 AND ca.tipoVeiculo != 2';
                    /** DESTAQUE - OUTROS **/
                    break;
                }
                case 2:
                {
                    /** DESTAQUE - MOTO **/
                    $filtroDest = 'AND ca.tipoVeiculo = 2';
                    /** DESTAQUE - MOTO **/
                    break;
                }
                case 1:
                default:
                {
                    /** DESTAQUE - CARROS **/
                    $filtroDest = 'AND ca.tipoVeiculo = 1';
                    /** DESTAQUE - CARROS **/
                    break;
                }
            }
            $conexao = conexao();
            $qDestPart = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, c.estado, c.cidade, ca.km, ca.anoFabricacao, c.cleanTitulo, vm.marca, vv.versao, vmd.modelo,
                                    (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                    AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                    FROM clientesAnuncios AS ca
                                    INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                    INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                    INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                    LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                    WHERE c.tipoAnuncio = 1 AND c.situacao = 1 $filtroDest 
                                    AND ca.codPlanoParticular = 3 AND ca.status = 1 AND '$dataHoje' BETWEEN ca.dataLiberacaoAnuncio AND ca.dataValidadeAnuncio");
                                    //echo mysql_error();
            $nDestPart = mysql_num_rows($qDestPart);
            if($nDestPart > 0)
            {
                for($a=0;$a<$nDestPart;$a++)
                {
                    $tpDestPart = mysql_fetch_assoc($qDestPart);
                    $anunciosDestaque[] = array(
                                                    'cod' => $tpDestPart['cod'],
                                                    'cor' => $tpDestPart['cor'],
                                                    'combustivel' => combustivel($tpDestPart['combustivel']),
                                                    'anoFabricacao' => $tpDestPart['anoFabricacao'],
                                                    'marca' => $tpDestPart['marca'],
                                                    'versao' => $tpDestPart['versao'],
                                                    'modelo' => $tpDestPart['modelo'],
                                                    'cidade' => $tpDestPart['cidade'],
                                                    'estado' => $tpDestPart['estado'],
                                                    'km' => $tpDestPart['km'],
                                                    'arquivo' => $tpDestPart['arquivo'], 
                                                    'anunciante' => 'Particular',
                                                    'cleanTitulo' => $tpDestPart['cleanTitulo'],
                                                    'tipoAnuncio' => 1,
                                               );
                }
                
            }
            
            $qDestRev = mysql_query("SELECT ca.cod, ca.cor, ca.combustivel, ca.anoFabricacao, c.estado, c.cidade, ca.km, c.cleanTitulo, vm.marca, c.nomeFantasia, vv.versao, vmd.modelo,
                                    (SELECT a.arquivo FROM arquivos AS a WHERE a.codReferencia = ca.cod
                                    AND a.referencia = 'clientesAnuncios' AND a.tipo = 1 ORDER BY a.capa DESC LIMIT 1) AS arquivo
                                    FROM clientesAnuncios AS ca 
                                    INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                    INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                    INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo
                                    LEFT JOIN veiculosVersoes AS vv ON vv.cod = ca.versao
                                    WHERE c.tipoAnuncio = 2 AND c.situacao = 1 $filtroDest
                                    AND ca.destaqueHome = '1' AND ca.superDestaqueHome = '0' AND ca.status = 1
                                    ORDER BY RAND()");
                                    //echo mysql_error();
            $nDestRev = mysql_num_rows($qDestRev);
            if($nDestRev > 0)
            {
                for($a=0;$a<$nDestRev;$a++)
                {
                    $tpDestRev = mysql_fetch_assoc($qDestRev);
                    $anunciosDestaque[] = array(
                                                    'cod' => $tpDestRev['cod'],
                                                    'cor' => $tpDestRev['cor'],
                                                    'combustivel' => combustivel($tpDestRev['combustivel']),
                                                    'anoFabricacao' => $tpDestRev['anoFabricacao'],
                                                    'marca' => $tpDestRev['marca'],
                                                    'versao' => $tpDestRev['versao'],
                                                    'modelo' => $tpDestRev['modelo'],
                                                    'cidade' => $tpDestRev['cidade'],
                                                    'estado' => $tpDestRev['estado'],
                                                    'km' => $tpDestRev['km'],
                                                    'arquivo' => $tpDestRev['arquivo'],
                                                    'anunciante' => $tpDestRev['nomeFantasia'],
                                                    'cleanTitulo' => $tpDestRev['cleanTitulo'], 
                                                    'tipoAnuncio' => 2,
                                               );
                }
                
            }
            mysql_close();
            shuffle($anunciosDestaque);
            $linkCarros = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home/?codDestaque=1&codSuper='.$codSuper : sslRedir().PROJECT_URL.'/home.php?codDestaque=1&codSuper='.$codSuper;
            $linkMotos = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home/?codDestaque=2&codSuper='.$codSuper : sslRedir().PROJECT_URL.'/home.php?codDestaque=2&codSuper='.$codSuper;
            $linkOutros = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home/?codDestaque=3&codSuper='.$codSuper : sslRedir().PROJECT_URL.'/home.php?codDestaque=3&codSuper='.$codSuper;
            ?>
            <div class="ofertabloco">
                <div class="ofertamenu">
                    <div class="ofertamenuitem">
                        <a href="<?=$linkCarros;?>" class="<?=$codDestaque == 1 ? 'ofertahover' : '';?>">OFERTAS DE CARRO</a>
                    </div>
                    <div class="ofertamenuitem ofertaborda">
                        <a href="<?=$linkMotos;?>" class="<?=$codDestaque == 2 ? 'ofertahover' : '';?>">OFERTAS DE MOTO</a>
                    </div>
                    <div class="ofertamenuitem">
                        <a href="<?=$linkOutros;?>" class="<?=$codDestaque == 3 ? 'ofertahover' : '';?>">OUTRAS OFERTAS</a>
                    </div>
                </div>
                <div class="ofertalista" id="bannerDestaque" style="overflow: hidden;">
                    <ul>
                        <li>
                            <?php
                                $keyDestaque = 0;
                                $aux = 0;
                                $lisDestaque = array();
                                if(count($anunciosDestaque) > 0)
                                {
                                    foreach($anunciosDestaque as $k => $anuncioDestaque)
                                    {
                                        //echo var_dump($anuncio);
                                        $aux++;
                                        if($anuncioDestaque['tipoAnuncio'] == 1)
                                        {
                                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/detalhe/'.$anuncioDestaque['cod'].($anuncioDestaque['anunciante'] != 'Particular' ? "/".mg_substituirEspacosPorTreacos($anuncioDestaque['anunciante']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioDestaque['cod'];
                                        }
                                        else
                                        {
                                            $urlMarcaModelo = ($anuncioDestaque['marca'] != '' ? $anuncioDestaque['marca'] : '').($anuncioDestaque['modelo'] ? ' '.$anuncioDestaque['modelo'] : '');
                                            $urlMarcaModelo = mg_substituirEspacosPorTreacos($urlMarcaModelo);
                                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncios/revenda/'.$anuncioDestaque['cleanTitulo'].'/'.($anuncioDestaque['km'] == '0' ? 'novo' : 'usado').'/'.$urlMarcaModelo.'-'.$anuncioDestaque['cod'].($anuncioDestaque['estado'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['estado']) : '').($anuncioDestaque['cidade'] != '' ? '/'.mg_substituirEspacosPorTreacos($anuncioDestaque['cidade']) : '') : sslRedir().PROJECT_URL.'/busca-detalhe.php?cod='.$anuncioDestaque['cod'];
                                        }
                                        $lisDestaque[$keyDestaque][] = "
                                                <div class='ofertalistamini'>
                                                    <div class='ofertalistaimgwrap'>
                                                        <div class='ofertalistaimg'>
															<a href='".$link."'>
																<img src='".($anuncioDestaque['arquivo'] != '' ? ssl().PROJECT_URL.'/arquivos/clientesAnuncios/'.$anuncioDestaque['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHome1.jpg')."' alt='Ofertas' width='122px' />
															</a>
														</div>
                                                    </div>
                                                    <div class='ofertalistatexto'>
                                                        <p class='ofertalistatitulo'><span>{$anuncioDestaque['marca']} {$anuncioDestaque['versao']}</span></p>
                                                        <p>{$anuncioDestaque['combustivel']} | {$anuncioDestaque['cor']} | {$anuncioDestaque['anoFabricacao']}</p>
                                                        <p><b>{$anuncioDestaque['anunciante']}</b></p>
                                                    </div>
                                                </div>";
                                        if($aux==$numPorPaginaDestaque || $k == count($anunciosDestaque)-1)
                                        {
                                            $aux=0;
                                            $lisDestaque[$keyDestaque] = implode("",$lisDestaque[$keyDestaque]);
                                            $keyDestaque++;
                                            
                                        }
                                    }
                                    $destaque = implode("</li><li>",$lisDestaque);
                                    echo $destaque;
                                }
                                else
                                {
                                    echo "Nenhum anúncio nesta categoria!";
                                }
                                ?>
                        </li>
                    </ul>
                
                    
                </div>
                <div class="ofertapaginacao controleDestaque" style="display: none;">
                    <a class="paginaOfertaAnt destaquePrev" href="#"><img src="<?=ssl().PROJECT_URL;?>/img/setaesq.png" alt="Anterior" /></a>
                    <?
        			/*$qtd = count($lisDestaque);
        			for($i=0;$i<$qtd;$i++)
        			{
        			?>
        				<img class="elipse paginaOferta" id="elipDestaque<?=$i+1;?>" src="<?=ssl().PROJECT_URL;?>/img/elipse.png" alt="Página" />
        			<?
        			}*/
        			?>
                    <span class="barraoferta">&nbsp;</span>
                    <a class="paginaOfertaProx destaqueNext" href="#"><img src="<?=ssl().PROJECT_URL;?>/img/setadir.png" alt="Próxima" /></a>
                </div>
            </div>
            <?php
            require_once PROJECT_INC_PATH."blocoGuiaAutomotivoHome.php";
            ?>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>