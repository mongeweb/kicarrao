<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<noscript>
    <meta http-equiv='refresh' content='0; url=http://www.kicarrao.com.br/noscript.php' />
</noscript>
<title><?php echo $titulo; ?></title>
<meta name="keywords" content="<?php echo $palavras; ?>" />

<meta name="description" content="<?php echo $descricao; ?>" />
<meta name="siteinfo" content="robots.txt" />
<meta name="revisit-after" content="1 weeks" />
<meta name="robots" content="index, follow" /> 
<meta name="url" content="http://www.kicarrao.com.br" />  


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

<!-- LiveZilla Chat Button Link Code (ALWAYS PLACE IN BODY ELEMENT) --><div style="display:none;"><a href="javascript:void(window.open('http://kicarrao.com.br/www/livezilla/chat.php?acid=96a1e','','width=590,height=760,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))" class="lz_cbl"><img id="chat_button_image" src="http://kicarrao.com.br/www/livezilla/image.php?acid=3cce8&amp;id=2&amp;type=overlay" width="188" height="70" style="border:0px;" alt="LiveZilla Live Chat Software"></a></div><!-- http://www.LiveZilla.net Chat Button Link Code --><!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">
var script = document.createElement("script");script.async=true;script.type="text/javascript";var src = "http://kicarrao.com.br/www/livezilla/server.php?acid=286f6&request=track&output=jcrpt&fbpos=22&fbml=0&fbmt=0&fbmr=0&fbmb=0&fbw=188&fbh=70&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img src="http://kicarrao.com.br/www/livezilla/server.php?acid=286f6&amp;request=track&amp;output=nojcrpt&amp;fbpos=22&amp;fbml=0&amp;fbmt=0&amp;fbmr=0&amp;fbmb=0&amp;fbw=188&amp;fbh=70" width="0" height="0" style="visibility:hidden;" alt=""></noscript><!-- http://www.LiveZilla.net Tracking Code -->