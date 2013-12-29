 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<noscript>
    <meta http-equiv='refresh' content='0; url=http://www.kicarrao.com.br/noscript.php' />
</noscript>
<title>Revenda <?php  $uri[0] = strtr($uri[0], "-", " "); $uri[0] = ucwords($uri[0]); echo $uri[0]; ?> <?php  $uri[2] = strtr($uri[2], "-", " ");  $uri[2] = ucwords($uri[2]); echo $uri[2]; ?> </title>
<meta name="keywords" content="Revenda <?php  $uri[0] = strtr($uri[0], "-", " "); $uri[0] = ucwords($uri[0]); echo $uri[0]; ?> <?php  $uri[2] = strtr($uri[2], "-", " ");  $uri[2] = ucwords($uri[2]); echo $uri[2]; ?> " />

<meta name="description" content="Revenda <?php  $uri[0] = strtr($uri[0], "-", " "); $uri[0] = ucwords($uri[0]); echo $uri[0]; ?> <?php  $uri[2] = strtr($uri[2], "-", " ");  $uri[2] = ucwords($uri[2]); echo $uri[2]; ?> " />

<meta name="siteinfo" content="robots.txt" />
<meta name="revisit-after" content="1 weeks" />
<meta name="robots" content="index, follow" /> 
<meta name="author" content="http://www.kicarrao.com.br" />
<meta http-equiv="expires" content="0" />
<meta name="distribution" content="global" />
<meta name="category" content="shopping" />
<meta name="ms.locale" content="pt-br" />




<meta content='<?php echo $titulo;?>' property='og:title' />
<meta content='Kicarrão' property='og:site_name' />
<meta content='<?=ssl();?>www.kicarrao.com.br' property='og:url' />
<meta content='<?=ssl();?>www.kicarrao.com.br/img/logo.png' property='og:image' />
<meta content='<?php echo $descricao;?>' property='og:description' />

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