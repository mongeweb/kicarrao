<?php 
require_once 'configRoot.php';

if (!defined('PROJECT_IMG_URL_DEV')) {
    define('PROJECT_IMG_URL_DEV', PROJECT_URL . '/img-dev');
}
?>
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <noscript>
        <meta http-equiv='refresh' content='0; url=http://www.kicarrao.com.br/noscript.php' />
    </noscript>
    <title>Venda de Carros Usado em Porto Alegre, Canoas, Gravataí, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba - KiCarrão</title>
    <meta name="keywords" content="venda de Carros em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba" />
    
    <meta name="description" content="No Kicarrão você encontra as melhores ofertas de carros usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba. As grandes ofertas de venda do kicarrão tornam a procura mais fácil!" />
    <meta name="siteinfo" content="robots.txt" />
    <meta name="revisit-after" content="1 weeks" />
    <meta name="robots" content="noodp" /> 
    <meta name="author" content="Kicarrao" />
    <meta name="distribution" content="global" />
    <meta name="ms.locale" content="pt-br" />
    
    <meta content='Venda de Carros Usado em Porto Alegre, Canoas, Gravataí, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba - KiCarrão' property='og:title' />
    <meta content='kicarrao' property='og:site_name' />
    <meta content='<?=ssl();?>www.kicarrao.com.br' property='og:url' />
    <meta content='<?=ssl();?>www.kicarrao.com.br/img/logo.png' property='og:image' />
    <meta content='No Kicarrão você encontra as melhores ofertas de carros usados em Porto Alegre, Canoas, Dois Irmãos, Esteio, Novo Hamburgo, Curitiba. As grandes ofertas de venda do kicarrão tornam a procura mais fácil!' property='og:description' />
    
    <link href="<?=ssl().PROJECT_URL;?>/css/estilos.css" rel="stylesheet" type="text/css" />
    <link href="<?=ssl().PROJECT_URL;?>/fontkit/stylesheet.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.1.6.4.min.js"></script>
    <script src="<?=ssl().PROJECT_URL;?>/Scripts/swfobject_modified.js" type="text/javascript"></script>
    <link href="<?=ssl().PROJECT_URL;?>/favicon.ico" rel="icon" type="image/x-icon" />
    <style type="text/css">
        div.logo{
        	float:left;
        	margin-left:56px;
        	margin-top:29px;
        }
        div.loginbotao {
            color: #FFFFFF;
            float: left;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 12px;
            font-weight: bold;
            height: 42px;
            text-align: center;
            text-transform: uppercase;
            width: 143px;
        }
        div.buscatopo{
            background:#A60F09;
            float:left;
            margin-left:11px;
            min-height:29px;
            position:relative;
            z-index:0;
            width:auto;
            border-radius:0 0 10px 10px;
            -moz-border-radius:0 0 10px 10px;
            -webkit-border-radius:0 0 10px 10px;
            behavior:url(PIE.htc);
        }
        div.buscafiltro{
            margin-left:12px;
        }
        div.buscainput input#buscar{
            border:1px solid #C8C8CA;
            border-radius:10px 0 0 10px;
            -moz-border-radius:10px 0 0 10px;
            -webkit-border-radius:10px 0 0 10px;
            behavior:url(PIE.htc);
        	color: #1A1A1A;
            float: left;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 12px;
            height: 22px;
            line-height: 22px;
            padding-bottom: 6px;
            padding-left: 17px;
            padding-top: 6px;
            width: 290px;
        }
        div.buscainput input#enviarBusca{
        	background:url(../img-dev/lupa.png) no-repeat;
        	border:none;
        	cursor:pointer;
        	float:left;
        	width:51px;
        	height:36px;
        }
        
        div.filtrotopo{
            background:url("../img-dev/fundotopofiltro.png") no-repeat scroll 191px 5px #A60F09;
            float:left;
            margin-bottom:14px;
            min-height:57px;
            width:100%;
        }
        div.filtrotopo p{
            color:#FFF;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 12px;
            margin-left:12px;
            margin-bottom:2px;
            margin-top:11px;
        }
        div.filtrotopo div.buscafiltro{
            float: left;
            margin-left:12px;
            margin-bottom: 7px;
        }
        div.filtrotopo div.filtro span{
            color:#FFF;
        }
        
        div.veiculosubmit input#enviarBuscaVeiculo{
        	background:url(../img-dev/botaobuscar.png) no-repeat;
        	border:none;
        	cursor:pointer;
        	float:right;
        	margin-left:7px;
        	width:105px;
        	height:25px;
        }
        
        div.ofertawrap{
            float:left;
            width:100%;
        }
        div.ofertalistaimgwrap {
            border-radius:10px;
            -moz-border-radius:10px;
            -webkit-border-radius:10px;
            behavior:url(PIE.htc);
            border: none;
            height: 115px;
            overflow: hidden;
            position: relative;
            width: 157px;
        }
        div.ofertalistamini div.ofertalistaimgwrap{
            border:none;
        }
        div.ofertalistatexto {
            float: left;
            margin-top: -8px;
            text-align: center;
            width: 100%;
        }
        div.ofertalistapreco{
        	background: url("../img-dev/fundopreco.png") no-repeat scroll 0 0 transparent;
            color: #FFFFFF;
            display: inline-block;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 11px;
            font-weight: bold;
            height: 31px;
            line-height: 31px;
            padding-bottom: 0;
            padding-top: 0;
            position: relative;
            text-align: center;
            width: 120px;
        }
        div.ofertalistaprecomenor{
        	background: url("../img-dev/fundoprecomenor.png") no-repeat scroll 0 0 transparent;
            color: #FFFFFF;
            display: inline-block;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 9px;
            font-weight: bold;
            height: 23px;
            line-height: 23px;
            padding-bottom: 0;
            padding-top: 0;
            position: relative;
            text-align: center;
            width: 88px;
        }
        a.paginaOfertaAnt {
            cursor: pointer;
            margin-left:8px;
            margin-right:8px;
        }
        a.paginaOfertaProx {
            cursor: pointer;
            margin-left:8px;
            margin-right:8px;
        }
        
        div.noticiahomebloco{
            float:left;
            margin-top:42px;
            width:100%;
        }
        p.noticiahomeheader{
            border-bottom:1px solid #D1D1D1;
            color:#A60F09;
            font-family: 'context_rounded_ssibold';
            font-size: 22px;
            font-weight: bold;
            float:left;
            margin-top:0;
            margin-bottom:0;
            padding-bottom:7px;
            width:100%;
        }
        a.noticiahomevertodas{
            color: #333333;
            float: right;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 10px;
            font-weight: normal;
            padding-top: 14px;
            text-decoration: none;
        }
        div.noticiahomelista{
            float:left;
            margin-top:22px;
            width:100%;
        }
        div.noticiahomedestaque{
            border-radius:10px;
            -moz-border-radius:10px;
            -webkit-border-radius:10px;
            behavior:url(PIE.htc);
            float:left;
            height:265px;
            margin-right:12px;
            /*overflow:hidden;*/
            position:relative;
            width:480px;
        }
        div.noticiahomedestaqueimg{
            float:left;
            height:265px;
            overflow:hidden;
            width:480px;
            position:relative;
            z-index:1;
        }
        div.noticiahomedestaqueimg a{
            height:265px;
            width:480px;
            display:table-cell;
            vertical-align:middle;
            text-align:center;
        }
        div.noticiahomedestaquetexto{
            float:left;
            position:absolute;
            bottom:0;
            left:0;
            height:97px;
            width:480px;
            z-index:2;
        }
        div.noticiahomedestaquefundo{
            background:#FFF;
            opacity:0.85;
            filter:alpha(opacity=85);
            height:97px;
            width:480px;
            top:0;
            left:0;
            position:absolute;
            z-index:1;
        }
        div.noticiahomedestaquetexto a{
            display:block;
            text-decoration:none;
            position:absolute;
            padding-left:20px;
            padding-top:13px;
            padding-bottom:13px;
            z-index:2;
        }
        div.noticiahomedestaquetexto span.noticiahomedestaquedata{
            display:block;
            color:#6E7275;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 11px;
            font-weight: normal;
            padding-bottom:3px;
        }
        div.noticiahomedestaquetexto span.noticiahomedestaquetitulo{
            display:block;
            color:#333333;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 14px;
            font-weight: bold;
            padding-bottom:4px;
        }
        div.noticiahomedestaquetexto span.noticiahomedestaquedescricao{
            display:block;
            color:#333333;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 14px;
        }
        div.noticiahomedestaquetexto span.noticiahomedestaquedescricao b{
            color:#CD1009;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 11px;
            font-weight: bold;
        }
        
        div.noticiahomeitem{
            border-radius:10px;
            -moz-border-radius:10px;
            -webkit-border-radius:10px;
            behavior:url(PIE.htc);
            float:left;
            margin-bottom:8px;
            min-height:126px;
            /*overflow:hidden;*/
            position:relative;
            width:324px;
        }
        div.noticiahometag{
            float:left;
            margin-bottom:4px;
            width:100%;
        }
        div.noticiahomeimg{
            float:left;
            height:95px;
            overflow:hidden;
            padding-right:11px;
            width:138px;
            position:relative;
            z-index:1;
        }
        div.noticiahomeimg a{
            height:95px;
            width:138px;
            display:table-cell;
            vertical-align:middle;
            text-align:center;
        }
        div.noticiahometexto{
            float: left;
            padding-right:10px;
            width: 165px;
        }
        div.noticiahometexto a{
            display:block;
            text-decoration:none;
        }
        div.noticiahometexto span.noticiahomedata{
            display:block;
            color:#6E7275;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 11px;
            font-weight: normal;
            padding-bottom:3px;
        }
        div.noticiahometexto span.noticiahometitulo{
            display:block;
            color:#333333;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 14px;
            font-weight: bold;
            padding-bottom:4px;
        }
        div.noticiahometexto span.noticiahomedescricao{
            display:block;
            color:#333333;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 14px;
        }
        div.noticiahometexto b{
            color:#CD1009;
            display:block;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 11px;
            font-weight: bold;
            margin-top:0;
        }
        
        div.centrorodape {
            float: left;
            margin-top: 33px;
            text-align: center;
            width: 100%;
        }
        div.centrorodapeinside {
            margin-left: auto;
            margin-right: auto;
            position: relative;
            width: 817px;
        }
        div.guiabloco {
            float: left;
            width: 100%;
        }
        p.guiatitulo {
            color: #A60F09;
            float: left;
            font-family: 'context_rounded_ssibold';
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 4px;
        }
        p.guiasubtitulo {
            color: #333333;
            float: left;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
            margin-top: 15px;
        }
        a.anunciesualoja{
            background: url("../img-dev/botaoanunciesualoja.png") no-repeat scroll 0 0 transparent;
            border: medium none;
            color: #FFFFFF;
            cursor: pointer;
            display:block;
            float: left;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 13px;
            font-weight: bold;
            height: 29px;
            line-height: 29px;
            margin-bottom: 10px;
            margin-left:10px;
            text-align: center;
            text-decoration:none;
            text-transform: uppercase;
            width: 147px;
        }
        div.guialistabloco {
            border: 1px solid #C7C8CA;
            float: left;
            margin-top: -1px;
            min-height: 187px;
            width: 817px;
        }
        div.guialistaitem {
            float: left;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 16px;
            text-align: center;
            width: 123px;
        }
        div.guiacategoria {
            float: left;
            margin-bottom: 16px;
            text-align: center;
            width: 100%;
        }
        div.guiacategoria span{
            display:block;
            color:#020202;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 12px;
            font-weight: bold;
            margin-top:9px;
            text-align: center;
            text-transform:uppercase;
        }
        a.guiasHome{
            display:block;
            text-decoration:none;
        }
        a.guialistaimgwrap{
            display:block;
            float:left;
            height: 82px;
            overflow:hidden;
            text-align: center;
            text-decoration:none;
            vertical-align: middle;
            width: 123px;
        }
        span.guialistaimg{
            display:table-cell;
            height: 82px;
            text-align: center;
            vertical-align: middle;
            width: 123px;
        }
        span.guialistatitulo {
            display:block;
            color: #6E6E6E;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 12px;
            font-weight: bold;
            padding-bottom: 5px;
            padding-top: 9px;
            float:left;
            width:100%;
        }
        span.guialistafone {
            display:block;
            color: #A60F09;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 16px;
            margin-top: 0;
            float:left;
            width:100%;
        }
    </style>
    
    <script type="text/javascript">
    function verificaNumero(e)
    {
        var tecla=(window.event)?event.keyCode:e.which;   
        if((tecla>47 && tecla<58)) return true;
        else{
        	if (tecla==8 || tecla==0) return true;
    	else  return false;
        }
    }
    $(document).ready(function(){
        $("div.filtro img").each(function(){
    		$(this).click(function(){
    			if($(this).hasClass("uncheck")){
    				$(this).attr("src","<?=ssl().PROJECT_URL;?>/img/buscacheck.png");
    				$(this).removeClass("uncheck");
    				$(this).addClass("check");
    			}else{
    				$(this).attr("src","<?=ssl().PROJECT_URL;?>/img/buscauncheck.png");
    				$(this).removeClass("check");
    				$(this).addClass("uncheck");
    			}
    		})
    	})
        
        $("div.ofertapaginacao a.paginaOferta").mouseover(function(){
            $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/elipseativa.png");
            $(this).mouseout(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/elipse.png");
            })
        })
        
        if($.browser.msie){
            if($.browser.version == 8){
                $("div.separalinha").css({'margin-left':'-21px','margin-top':'9px'});
                $("div.filtro label").css({'line-height':'20px'});
                $("div.filtro span").css({'line-height':'20px'});
            }
        }
    })
    </script>
    
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-40864118-1', 'kicarrao.com.br');
      ga('send', 'pageview');
    
    </script>
    <?
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
            $("#bannerSuper").css("min-height", "720px");
            $("#bannerSuper li").html("");
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
                url: "<?=ssl().PROJECT_URL;?>/ajaxHome-dev.php",
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
                        if(json.nItens <= 4)
                            $("#bannerSuper").css("min-height", "240px");
                        else if(json.nItens > 4 && json.nItens <= 8)
                            $("#bannerSuper").css("min-height", "480px");
                        $("#loadSuperDestaque").hide();
                        $(this).html(json.html).fadeIn(1000);
                        _intSuper = setTimeout(function()
                        {
                            _pag = $("div.controleSuper .superNext").attr("rel");
                            if(_pag != '')
                                ajaxSuperDestaque(_pag);
                        },_timeSetTime);
                    });
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
                }
            }); 
        }
        function ajaxDestaque(_pagina,_tipo)
        {
            clearTimeout(_intDestaque);
            $("#bannerDestaque").css("min-height", "480px");
            $("#bannerDestaque li").html("");
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
                url: "<?=ssl().PROJECT_URL;?>/ajaxHome-dev.php",
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
                        if(json.nItens <= 4)
                            $("#bannerDestaque").css("min-height", "240px");
                        
                        $("#loadDestaque").hide();
                        $(this).html(json.html).fadeIn(1000);
                        _intDestaque = setTimeout(function()
                        {
                            _pag = $("div.controleDestaque .destaqueNext").attr("rel");
                            if(_pag != '')
                                ajaxDestaque(_pag);
                        },_timeSetTime);
                        
                    });
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
                console.log(_ind+1);
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
        })
    </script>
    
</head>

<body>
<?php require_once PROJECT_INC_PATH.'alexa.php';?>
<div class="mestre">

	<?php require_once PROJECT_INC_PATH.'topo-dev.php';?>
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
                        <img src="<?=ssl().PROJECT_URL;?>/img-dev/anuncie.jpg" alt="Anuncie" />
                        </a>
                    </div>
                </div>
                <div class="centromeio">
                    <form name="buscaVeiculo" id="buscaVeiculo" action="<?=$link;?>" method="get">
                        <!--<p class="veiculostitulo">Veículos<img src="<?=ssl().PROJECT_URL;?>/img/iconeveiculos.png" alt="Veículos" /></p>-->
                        <?
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/' : sslRedir().PROJECT_URL.'/busca.php';
                        ?>
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
                                <br class="clear" />
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
              		<div class="ofertalistaSuper" id="bannerSuper" style="overflow: hidden;min-height: 720px;">
                        <img id="loadSuperDestaque" src='img/load.gif' style="position: relative;top: 360px;display: none;" />
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                </div>
          		<div class="ofertapaginacao controleSuper">
                	<a class="paginaOfertaAnt superPrev" ><img src="<?=ssl().PROJECT_URL;?>/img-dev/ofertaesq.png" alt="Anterior" /></a>
        			<!--<span class="barraoferta">&nbsp;</span>-->
            		<a class="paginaOfertaProx superNext" ><img src="<?=ssl().PROJECT_URL;?>/img-dev/ofertadir.png" alt="Próxima" /></a>
                </div>
            </div>
            <div class="publicidadebloco">
            	<?php
                imprimeBannerRetangulo();
                ?>
            </div>
            <div class="ofertabloco">
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
                <div class="ofertalista" id="bannerDestaque" style="overflow: hidden;min-height: 460px;">
                    <img id="loadDestaque" src='img/load.gif' style="position: relative;top: 230px;display: none;" />
                    <ul>
                        <li>                            
                        </li>
                    </ul>
                </div>
                <div class="ofertapaginacao controleDestaque">
                    <a class="paginaOfertaAnt destaquePrev"><img src="<?=ssl().PROJECT_URL;?>/img-dev/ofertaesq.png" alt="Anterior" /></a>
                    <!--<span class="barraoferta">&nbsp;</span>-->
                    <a class="paginaOfertaProx destaqueNext"><img src="<?=ssl().PROJECT_URL;?>/img-dev/ofertadir.png" alt="Próxima" /></a>
                </div>
            </div>
            <div class="noticiahomebloco">
                <div class="centrorodapeinside">
                    <p class="noticiahomeheader">
                        Últimas notícias
                        <a class="noticiahomevertodas" href="#">Ver todas as Notícias</a>
                    </p>
                    <div class="noticiahomelista">
                        <div class="noticiahomedestaque">
                            <div class="noticiahomedestaqueimg">
                                <a href="#"><img src="<?=ssl().PROJECT_URL;?>/img-dev/fotonoticia.jpg" alt="Notícias" /></a>
                            </div>
                            <div class="noticiahomedestaquetexto">
                                <div class="noticiahomedestaquefundo">&nbsp;</div>
                                <a href="#">
                                    <span class="noticiahomedestaquedata">24/10/2013</span>
                                    <span class="noticiahomedestaquetitulo">Moto elétrica Sora chega a 190 km/h</span>
                                    <span class="noticiahomedestaquedescricao">Moto elétrica de empresa canadense consegue atingir 190 km/h. Veja vídeo da moto! <b>Leia mais ...</b></span>
                                </a>
                            </div>
                        </div>
                        <div class="noticiahomeitem">
                            <div class="noticiahometag">
                                <img src="<?=ssl().PROJECT_URL;?>/img-dev/tag-dicas.png" alt="Dicas" />
                            </div>
                            <div class="noticiahomeimg">
                                <a href="#"><img src="<?=ssl().PROJECT_URL;?>/img-dev/fotodica.png" alt="Dicas" /></a>
                            </div>
                            <div class="noticiahometexto">
                                <a href="#">
                                    <span class="noticiahomedata">24/10/2013</span>
                                    <span class="noticiahometitulo">Novo Ford Focus parte de R$ 60.990 (hatch) e vai até R$ 89.990 (sedã top)</span>
                                    <b>Leia mais ...</b>
                                </a>
                            </div>
                        </div>
                        <div class="noticiahomeitem">
                            <div class="noticiahometag">
                                <img src="<?=ssl().PROJECT_URL;?>/img-dev/tag-materia-especial.png" alt="Matéria Especial" title="Matéria Especial" />
                            </div>
                            <div class="noticiahomeimg">
                                <a href="#"><img src="<?=ssl().PROJECT_URL;?>/img-dev/fotomateria.png" alt="Matéria Especial" /></a>
                            </div>
                            <div class="noticiahometexto">
                                <a href="#">
                                    <span class="noticiahomedata">24/10/2013</span>
                                    <span class="noticiahometitulo">Moto elétrica Sora chega a 190 km/h</span>
                                    <b>Leia mais ...</b>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            require_once PROJECT_INC_PATH."blocoGuiaAutomotivoHome-dev.php";
            ?>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>