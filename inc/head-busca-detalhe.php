<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Venda de <?php  $uri[3] = strtr($uri[3], "-", " "); $uri[3] = ucwords($uri[3]); echo $uri[3]; ?> <?php  $uri[4] = strtr($uri[4], "-", " "); $uri[4] = ucwords($uri[4]);  echo $uri[4]; ?> </title>
<meta name="keywords" content="Venda de <?php  $uri[3] = strtr($uri[3], "-", " "); $uri[3] = ucwords($uri[3]); echo $uri[3]; ?> <?php  $uri[4] = strtr($uri[4], "-", " "); $uri[4] = ucwords($uri[4]);  echo $uri[4]; ?> " />

<meta name="description" content="Venda de <?php  $uri[3] = strtr($uri[3], "-", " "); $uri[3] = ucwords($uri[3]); echo $uri[3]; ?> <?php  $uri[4] = strtr($uri[4], "-", " "); $uri[4] = ucwords($uri[4]);  echo $uri[4]; ?> " />
<meta name="siteinfo" content="robots.txt" />
<meta name="revisit-after" content="1 weeks" />
<meta name="robots" content="noodp" /> 
<meta name="author" content="http://www.kicarrao.com.br" />
<meta http-equiv="expires" content="0" />
<meta name="distribution" content="global" />
<meta name="category" content="shopping" />
<meta name="ms.locale" content="pt-br" />

<?php
/*
<meta content='Venda de <?php  $uri[3] = strtr($uri[3], "-", " "); $uri[3] = ucwords($uri[3]); echo $uri[3]; ?> <?php  $uri[4] = strtr($uri[4], "-", " "); $uri[4] = ucwords($uri[4]);  echo $uri[4]; ?> ' property='og:title' />
<meta content='Kicarrao' property='og:site_name' />
<meta content='<?=ssl();?>www.kicarrao.com.br' property='og:url' />
<meta content='<?=ssl();?>www.kicarrao.com.br/img/logo.png' property='og:image' />
<meta content='Venda de <?php  $uri[3] = strtr($uri[3], "-", " "); $uri[3] = ucwords($uri[3]); echo $uri[3]; ?> <?php  $uri[4] = strtr($uri[4], "-", " "); $uri[4] = ucwords($uri[4]);  echo $uri[4]; ?>' property='og:description' />
*/?>


<link href="<?=ssl().PROJECT_URL;?>/css/estilos.css" rel="stylesheet" type="text/css" />
<link href="<?=ssl().PROJECT_URL;?>/fontkit/stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.1.6.4.min.js"></script>
<script src="<?=ssl().PROJECT_URL;?>/Scripts/swfobject_modified.js" type="text/javascript"></script>
<link href="<?=ssl().PROJECT_URL;?>/favicon.ico" rel="icon" type="image/x-icon" />
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