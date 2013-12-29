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