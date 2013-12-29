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
    unset($_SESSION['superDestaque'],$_SESSION['destaque']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Marcação de microdados adicionada pelo Assistente de marcação para dados estruturados do Google. -->
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>

	<?php
	require_once PROJECT_INC_PATH.'head-home.php';
    require_once ADMIN_FUNC_PATH."formatting.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jcarousellite.js"></script>
    <script type="text/javascript">
        _ativoSuperDestaque = 1;
        _ativoDestaque = 1;
        _timeSetTime = 20000;
        _intSuper = '';
        _intDestaque = '';
        function ajaxSuperDestaque(_pagina,_tipo)
        {
            clearTimeout(_intSuper);
            $("div.controleSuper .superPrev").attr("rel","");
            $("div.controleSuper .superNext").attr("rel","");
            $("#bannerSuper").css("min-height", "650px");
            $("#loadSuperDestaque").show();
            
            _ativoSuperDestaque = _tipo || _ativoSuperDestaque;
            $(".ofertamenuSuper > .ofertamenuitem > a").removeClass("ofertahover").eq(_ativoSuperDestaque-1).addClass("ofertahover");
            _pagina = _pagina || 1;
            if(typeof _ajaxSuperDestaque != 'undefined')
                _ajaxSuperDestaque.abort();
            _ajaxSuperDestaque = $.ajax(
            {
                type: "GET",
                //async: false,
                url: "<?=ssl().PROJECT_URL;?>/ajaxHome.php",
                data:
                {
                    bloco: "superDestaque",
                    pagina: _pagina,
                    codSuper: _ativoSuperDestaque
                },
                dataType: "json", 
                success: function(json)
                {
                    $("#bannerSuper li").fadeOut(function()
                    {
                        $("#bannerSuper li").html("");
                        if(json.nItens <= 4)
                            $("#bannerSuper").css("min-height", "240px");
                        else if(json.nItens > 4 && json.nItens <= 8)
                            $("#bannerSuper").css("min-height", "480px");
                        $("#loadSuperDestaque").hide();
                        $(this).html(json.html).fadeIn(1000);
                        if(json.prev == '' && json.next == '')
                        {
                            $("div.controleSuper").hide();
                        }
                        else
                        {
                            $("div.controleSuper .superPrev").attr("rel",json.prev);
                            $("div.controleSuper .superNext").attr("rel",json.next);
                            $("div.controleSuper").show();
                        }
                        _intSuper = setTimeout(function()
                        {
                            _pag = $("div.controleSuper .superNext").attr("rel");
                            if(_pag != '')
                                ajaxSuperDestaque(_pag);
                        },_timeSetTime);
                    });
                    
                }
            }); 
        }
        function ajaxDestaque(_pagina,_tipo)
        {
            clearTimeout(_intDestaque);
            $("div.controleDestaque .destaquePrev").attr("rel","");
            $("div.controleDestaque .destaqueNext").attr("rel","");
            $("#bannerDestaque").css("min-height", "380px");
            $("#loadDestaque").show();
            
            _ativoDestaque = _tipo || _ativoDestaque;
            $(".ofertamenuDestaque > .ofertamenuitem > a").removeClass("ofertahover").eq(_ativoDestaque-1).addClass("ofertahover");
            _pagina = _pagina || 1;
            if(typeof _ajaxDestaque != 'undefined')
                _ajaxDestaque.abort();
            _ajaxDestaque = $.ajax(
            {
                type: "GET",
                //async: false,
                url: "<?=ssl().PROJECT_URL;?>/ajaxHome.php",
                data:
                {
                    bloco: "destaque",
                    pagina: _pagina,
                    codDestaque: _ativoDestaque
                },
                dataType: "json", 
                success: function(json)
                { 
                    $("#bannerDestaque li").fadeOut(function()
                    {
                        $("#bannerDestaque li").html("");
                        if(json.nItens <= 4)
                            $("#bannerDestaque").css("min-height", "240px");
                        
                        $("#loadDestaque").hide();
                        $(this).html(json.html).fadeIn(1000);
                        if(json.prev == '' && json.next == '')
                        {
                            $("div.controleDestaque").hide();
                        }
                        else
                        {
                            $("div.controleDestaque .destaquePrev").attr("rel",json.prev);
                            $("div.controleDestaque .destaqueNext").attr("rel",json.next);
                            $("div.controleDestaque").show();
                        }
                        _intDestaque = setTimeout(function()
                        {
                            _pag = $("div.controleDestaque .destaqueNext").attr("rel");
                            if(_pag != '')
                                ajaxDestaque(_pag);
                        },_timeSetTime);
                        
                    });
                    
                    
                }
            }); 
        }
        $(document).ready(function()
        {
            ajaxSuperDestaque();
            ajaxDestaque();
            
            $("div.controleSuper .superPrev").click(function()
            {
                ajaxSuperDestaque($(this).attr("rel"));
            })
            $("div.controleSuper .superNext").click(function()
            {
                ajaxSuperDestaque($(this).attr("rel"));
            });
            $(".ofertamenuSuper > .ofertamenuitem > a").click(function()
            {
                _ind = $(this).parent().index();
                ajaxSuperDestaque(1,_ind+1);
            })
            
            
            
            $("div.controleDestaque .destaquePrev").click(function()
            {
                ajaxDestaque($(this).attr("rel"));
            })
            $("div.controleDestaque .destaqueNext").click(function()
            {
                ajaxDestaque($(this).attr("rel"));
            });
            $(".ofertamenuDestaque > .ofertamenuitem > a").click(function()
            {
                _ind = $(this).parent().index();
                //console.log(_ind+1);
                ajaxDestaque(1,_ind+1);
            })
            /*
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
			*/
            
            
            
            
            
            
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
            
            $("a.paginaOfertaAnt").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertaesqhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertaesq.png");
                })
            })
            $("a.paginaOfertaProx").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertadirhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/ofertadir.png");
                })
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
                        <img src="<?=ssl().PROJECT_URL;?>/img/anuncie.jpg" alt="Anuncie" />
                        </a>
                    </div>
                </div>
                <div class="centromeio">
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/' : sslRedir().PROJECT_URL.'/busca.php';
                    ?>
                    <form name="buscaVeiculo" id="buscaVeiculo" action="<?=$link;?>" method="get">
                        <!--<p class="veiculostitulo">Veículos<img src="<?=ssl().PROJECT_URL;?>/img/iconeveiculos.png" alt="Veículos" /></p>-->
                        <div class="filtrotopo">
                            <p>Filtrar Busca</p>
                            <div class="buscafiltro">
                                <div class="filtro">
                                    <input checked="true" type="radio" class="check" name="filtroBusca" id="filtroBuscaRevenda" value="2" title="Selecionar filtro" />
                                    <span>Revendas</span>
                                </div>
                                <div class="filtro">
                                    <input type="radio" class="check" name="filtroBusca" id="filtroBuscaParticular" value="1" title="Selecionar filtro" />
                                    <span>Particulares</span>
                                </div>
                                <!--<br class="clear" />-->
                                <div class="filtro">
                                    <input type="radio" class="check" name="filtroBusca" id="filtroBuscaAmbos" value="3" title="Selecionar filtro" />
                                    <span>Ambos</span>
                                </div>
                            </div>
                        </div>
                        <div class="veiculosbloco">
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
                        </div>
                    </form>
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
                <div class="ofertawrap">
                    <div class="ofertamenu ofertamenuSuper">
                        <div class="ofertamenuitem">
                            <a>OFERTAS DE CARRO</a>
                        </div>
                        <div class="ofertamenuitem ofertaborda">
                            <a>OFERTAS DE MOTO</a>
                        </div>
                        <div class="ofertamenuitem">
                            <a>OUTRAS OFERTAS</a>
                        </div>
                    </div>
                    <div id="loadSuperDestaque" class="ofertafundo">
                        <img src='<?=ssl().PROJECT_URL;?>/img/ajax-load-finalizacao.gif' style="position: relative;top: 360px; margin: 0 auto; display: block;" />
                        <span class="loadtexto">Carregando mais ofertas...</span>
                    </div>
              		<div class="ofertalistaSuper" id="bannerSuper" style="overflow: hidden;min-height: 100%;">
                        <!--<img id="loadSuperDestaque" src='<?=ssl().PROJECT_URL;?>/img/ajax-load-finalizacao.gif' style="position: relative;top: 360px;display: none;" />-->
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                </div>
          		<div class="ofertapaginacao controleSuper">
                	<a class="paginaOfertaAnt superPrev" ><img src="<?=ssl().PROJECT_URL;?>/img/ofertaesq.png" alt="Anterior" /></a>
        			<!--<span class="barraoferta">&nbsp;</span>-->
            		<a class="paginaOfertaProx superNext" ><img src="<?=ssl().PROJECT_URL;?>/img/ofertadir.png" alt="Próxima" /></a>
                </div>
            </div>
            <div class="publicidadebloco">
            	<?php
                imprimeBannerRetangulo();
                ?>
            </div>
            <div class="ofertabloco">
                <div class="ofertawrap">
                    <div class="ofertamenu ofertamenuDestaque">
                        <div class="ofertamenuitem">
                            <a>OFERTAS DE CARRO</a>
                        </div>
                        <div class="ofertamenuitem ofertaborda">
                            <a>OFERTAS DE MOTO</a>
                        </div>
                        <div class="ofertamenuitem">
                            <a>OUTRAS OFERTAS</a>
                        </div>
                    </div>
                    <div id="loadDestaque" class="ofertafundo">
                        <img src='<?=ssl().PROJECT_URL;?>/img/ajax-load-finalizacao.gif' style="position: relative; top: 230px; display: none; margin: 0 auto; display: block;" />
                        <span class="loadtexto">Carregando mais ofertas...</span>
                    </div>
                    <div class="ofertalista" id="bannerDestaque" style="overflow: hidden; min-height: 380px;">
                        <!--<img id="loadDestaque" src='img/load.gif' style="position: relative;top: 230px;display: none;" />-->
                        <ul>
                            <li>                            
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ofertapaginacao controleDestaque">
                    <a class="paginaOfertaAnt destaquePrev"><img src="<?=ssl().PROJECT_URL;?>/img/ofertaesq.png" alt="Anterior" /></a>
                    <!--<span class="barraoferta">&nbsp;</span>-->
                    <a class="paginaOfertaProx destaqueNext"><img src="<?=ssl().PROJECT_URL;?>/img/ofertadir.png" alt="Próxima" /></a>
                <br /><br />
                </div>
                
            </div>
            <div class="noticiahomebloco" style="display: block !important">
                <div class="centrorodapeinside">
                    <p class="noticiahomeheader">
                        Últimas notícias
                        <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticias' : sslRedir().PROJECT_URL.'/noticias.php';
                        ?>
                        <a class="noticiahomevertodas" href="<?=$link;?>">Ver todas as Notícias</a>
                    </p>
                    <div class="noticiahomelista">
                            <?
                            $conexao = conexao();
                            $sqlNoticiasDes = mysql_query("SELECT * FROM noticias WHERE destaque = '1' ORDER BY data DESC LIMIT 1");
                            $numNoticiasDes = mysql_num_rows($sqlNoticiasDes);
                            if($numNoticiasDes > 0)
                            {
                            ?>
                                <div class="noticiahomedestaque">
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
                                     
                                            if($tpNoticiasDes['codLable'] > 0)
                                            {
                                                $sqlLable = mysql_query("SELECT * FROM noticiasLables WHERE cod = '{$tpNoticiasDes['codLable']}' LIMIT 1");
                                                $numLable = mysql_num_rows($sqlLable);
                                                if($numLable > 0)
                                                {
                                                    $tpLable = mysql_fetch_assoc($sqlLable);
                                            ?>
                                                    <div class="noticiahometag">
                                                        <div class="tagimg"><img src="<?=ssl().PROJECT_URL;?>/img/tag.png" alt="Dicas" /></div>
                                                        <div class="tagtexto">
                                                            <?=$tpLable['titulo'];?>
                                                        </div>
                                                    </div>
                                            <?
                                                }
                                            }
                                            ?>
                                            <div class="noticiahomedestaqueimg">
                                                <a href="<?=$link;?>">
                                                    <img style="max-height: 265px; max-width: 361px;" src="<?=$imagemCapa;?>" alt="Notícias" title="<?=$tpFotoDes['legenda'];?>" />
                                                </a>
                                            </div>
                                        <?
                                        }
                                        ?>
                                        <div class="noticiahomedestaquetexto">
                                            <div class="noticiahomedestaquefundo">&nbsp;</div>
                                            <a href="<?=$link;?>">
                                                <span class="noticiahomedestaquedata"><?=$data;?></span>
                                                <span class="noticiahomedestaquetitulo"><?=$tpNoticiasDes['titulo'];?></span>
                                                <span class="noticiahomedestaquedescricao"><b> Leia mais ...</b></span>
                                            </a>
                                        </div>
                                    <?  
                                    }
                                    ?>
                                </div>
                                <?
    						}
                            mysql_close();
    						?>
                            <!--<div class="noticiahomedestaque">
                                <div class="noticiahomedestaqueimg">
                                    <a href="#">
                                        <iframe src="//player.vimeo.com/video/8335803?title=0&amp;byline=0&amp;portrait=0&amp;color=c9ff23" width="480" height="265" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/fotonoticia.jpg" alt="Notícias" />
                                    </a>
                                </div>
                                <div class="noticiahomedestaquetexto">
                                    <div class="noticiahomedestaquefundo">&nbsp;</div>
                                    <a href="#">
                                        <span class="noticiahomedestaquedata">24/10/2013</span>
                                        <span class="noticiahomedestaquetitulo">Moto elétrica Sora chega a 190 km/h</span>
                                        <span class="noticiahomedestaquedescricao">
                                            Moto elétrica de empresa canadense consegue atingir 190 km/h. Veja vídeo da moto! <br />
                                            <b>Leia mais ...</b>
                                        </span>
                                    </a>
                                </div>
                            </div>-->
                        <?
                        $conexao = conexao();
                        $sqlNoticias = mysql_query("SELECT * FROM noticias WHERE destaque <> 1 ORDER BY data DESC LIMIT 2");
                        $numNoticias = mysql_num_rows($sqlNoticias);
                                                
                        if($numNoticias > 0)
                        {
                            for($x = 0;$x < $numNoticias;$x++)
                            {
                                $tpNoticias = mysql_fetch_assoc($sqlNoticias);
                                $data = dataBr($tpNoticias['data']);
                                $cleanTitulo = $tpNoticias['cleanTitulo'];
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticia/'.$tpNoticias['cod'].'/'.$tpNoticias['cleanTitulo'] : sslRedir().PROJECT_URL.'/noticias-detalhe.php?cod='.$tpNoticias['cod'];
                        ?>
                                <div class="noticiahomeitem">
                                    <?
                                    if($tpNoticias['codLable'] > 0)
                                    {
                                        $sqlLable = mysql_query("SELECT * FROM noticiasLables WHERE cod = '{$tpNoticias['codLable']}' LIMIT 1");
                                        $numLable = mysql_num_rows($sqlLable);
                                        if($numLable > 0)
                                        {
                                            $tpLable = mysql_fetch_assoc($sqlLable);
                                    ?>
                                            <div class="noticiahometag">
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
                                        <div class="noticiahomeimg">
                                            <a href="<?=$link;?>">
                                                <img style="max-height: 95px; max-width: 138;" src="<?=$imagemCapa;?>" alt="<?=$tpNoticias['titulo'];?>" />
                                            </a>
                                        </div>
                                    <?
                                    }
                                    ?>
                                    <div class="noticiahometexto">
                                        <a href="<?=$link;?>">
                                            <span class="noticiahomedata"><?=$data;?></span>
                                            <span class="noticiahometitulo"><?=$tpNoticias['titulo'];?></span>
                                            <b>Leia mais ...</b>
                                        </a>
                                    </div>
                                </div>
                        <?
                            }
                        }
                        mysql_close();
                       // else
                        //{
                        ?>
                            <!--<div class="noticialink">
                                Nenhuma notícia encontrada.
                            </div>-->
                        <?
                        //}
                        ?>
                   </div>
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