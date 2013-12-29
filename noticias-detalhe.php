<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jcarousellite.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" href="<?=ssl().PROJECT_URL;?>/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript">
    $(document).ready(function(){
        $("a[rel=galeria]").fancybox({
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
				return '<span id="fancybox-title-over">Imagem ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
			}
		})
        
        _visible = 2;
        if($(".noticiaminicarro li").length > 2)
        {
        	$(".noticiaminicarro").jCarouselLite({
        		speed: 500,
        		circular : false,
                btnPrev : ".noticiaminiesq img",
			    btnNext : ".noticiaminidir img",
        		visible: _visible,
                vertical : false,
        		auto: false,
                beforeStart:function(_obj,_els)
				{
				    $(".noticiaminiesq img").show();
				}
        	});
        	$("div.noticiaminidir img").show();
            //$("div.setaup img").show();
        }
        
        $("div.noticiaminiesq").mouseover(function(){
            $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setanoticiaesqhover.png");
            $(this).mouseout(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setanoticiaesq.png");
            })
        })
        $("div.noticiaminidir").mouseover(function(){
            $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setanoticiadirhover.png");
            $(this).mouseout(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/setanoticiadir.png");
            })
        })
    });    
    </script>
</head>
<?
$conexao = conexao();
$cod = isset($cod) ? $cod : '';
$cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
$sqlNoticia = mysql_query("SELECT * FROM noticias WHERE cod = '$cod'");
$numNoticia = mysql_num_rows($sqlNoticia);
if($numNoticia < 1)
{
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
    echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " location.replace('".$link."'); \n";
	echo " //--> \n";
	echo " </script> \n";  
}
$tpNoticia = mysql_fetch_assoc($sqlNoticia);
$data = dataBr($tpNoticia['data']);
mysql_close();
?>
<body>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            $link2 = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticias' : sslRedir().PROJECT_URL.'/noticias.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<a href="<?=$link2;?>">Notícias</a>&nbsp; &gt; &nbsp;<span>Detalhe</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="bannernoticia"><img src="<?=ssl().PROJECT_URL;?>/img/bannernoticia.jpg" alt="Promoção da Semana" /></div>
                <div class="noticiadetalhewrap">
                    <div class="faixafonte">
                        <div class="faixafontetexto"><?=$data;?><?=$tpNoticia['fonte'] != '' ? ' | Fonte: '.$tpNoticia['fonte'] : '';?></div>
                        <div class="faixafontevoltar">
                            <a href="javascript:history.back();"><img alt="Voltar" src="http://www.kicarrao.com.br/img/setavoltar.png" />Voltar</a>
                        </div>
                    </div>
                    <div class="noticiadetalhebloco">
                        <p class="noticiadetalhetitulo"><?=$tpNoticia['titulo'];?></p>
                        <p class="noticiadetalheresumo"><? //$tpNoticia['resumo']; ?></p>
                        <?
                        $conexao = conexao();
                        $sqlFotoDes = mysql_query("SELECT * FROM arquivos WHERE referencia = 'noticias' AND codReferencia = '{$cod}' AND capa = '1' AND tipo = '2'");
                        $sqlFotoDesG = mysql_query("SELECT * FROM arquivos WHERE referencia = 'noticias' AND codReferencia = '{$cod}' AND capa = '1' AND tipo = '1'");
                        $numFotoDes = mysql_num_rows($sqlFotoDes);
                        if($numFotoDes > 0 || ($tpNoticia['video'] != '' && $tpNoticia['videoDestaque'] > 0))
                        {
                            $img = '';
                            $auxDaCapa = '';
                            if($tpNoticia['video'] != '' && $tpNoticia['videoDestaque'] > 0)
                            {
                                $output = array();
                                $url = $tpNoticia['video'];
                                preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $output);
                                $img = "<iframe width=\"286\" height=\"190\" src=\"//www.youtube.com/embed/".$output[0]."\" frameborder=\"0\" allowfullscreen></iframe>";
                                $auxDaCapa = '';
                            }
                            else
                            {
                                $tpFotoDes = mysql_fetch_assoc($sqlFotoDes);
                                $tpFotoDesG = mysql_fetch_assoc($sqlFotoDesG);
                                $img = "<a href='".ssl().PROJECT_URL."/arquivos/noticias/".$tpFotoDesG['arquivo']."' title='".$tpFotoDesG['legenda']."' id='fancy' rel='galeria'>
                                            <img style='max-width: 286px; max-height: 190px;' src='".ssl().PROJECT_URL."/arquivos/noticias/".$tpFotoDes['arquivo']."' alt='".$tpNoticia['titulo']."' />
                                        </a>"; 
                                $auxDaCapa = " AND capa = '0' ";                                        
                            }
                            
                        ?>
                            <div class="noticiadetalheimgbloco">
                                <div class="noticiadetalheimg">
                                    <?=$img;?>
                                </div>
                                <?
                                $sqlFoto = mysql_query("SELECT * FROM arquivos WHERE referencia = 'noticias' AND codReferencia = '{$cod}' $auxDaCapa AND tipo = '3'");
                                $numFoto = mysql_num_rows($sqlFoto);
                                if($numFoto > 0)
                                {
                                ?>
                                    <div class="noticiaminibloco">
                                    <?
                                    if($numFoto > 2)
                                    {
                                    ?>
                                        <div class="noticiaminiesq">
                                            <img src="<?=ssl().PROJECT_URL;?>/img/setanoticiaesq.png" alt="Anterior" />
                                        </div>
                                    <?
                                    }
                                    ?>
                                        <div class="noticiaminicarro">
                                            <ul>
                                                <?
                                                for($x = 0;$x < $numFoto;$x++)
                                                {
                                                    $tpFoto = mysql_fetch_assoc($sqlFoto);
                                                    $sqlFotoG = mysql_query("SELECT * FROM arquivos WHERE referencia = 'noticias' AND codigo = '{$tpFoto['codigo']}' AND tipo = '1'");
                                                    $tpFotoG = mysql_fetch_assoc($sqlFotoG);
                                                ?>
                                                    <li>
                                                        <div class="noticiamini">
                                                            <a href="<?=ssl().PROJECT_URL;?>/arquivos/noticias/<?=$tpFotoG['arquivo'];?>" title="<?=$tpFotoG['legenda'];?>" id="fancy" rel="galeria">
                                                                <img style="max-width: 96px; max-height: 64px;" src="<?=ssl().PROJECT_URL;?>/arquivos/noticias/<?=$tpFoto['arquivo'];?>" alt="Notícia" />
                                                            </a>
                                                        </div>
                                                    </li>
                                                <?
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    <?
                                    if($numFoto > 2)
                                    {
                                    ?>
                                        <div class="noticiaminidir">
                                            <img src="<?=ssl().PROJECT_URL;?>/img/setanoticiadir.png" alt="Próxima" />
                                        </div>
                                    <?
                                    }
                                    ?>
                                    </div>
                                <?
                                }
                                mysql_close();
                                ?>
                            </div>
                        <?
                        }
                        ?>
                        <div class="noticiadetalhetexto">
                            <!--<p class="noticiadetalhetitulo"><?=$tpNoticia['titulo'];?></p>-->
                            <?=$tpNoticia['texto'];?>
                            <!--<p class="noticiaFonte">Fonte: <?=$tpNoticia['fonte'];?></p>-->
                        </div>
                    </div>
                    <div class="faixafonte">
                        <div class="detalheshare">
                            <div class="detalheshareitem">
                                <!--<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="150" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>-->
                                <?
                                $linkCurtir = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticia/'.$tpNoticia['cod'].'/'.$tpNoticia['cleanTitulo'] : sslRedir().PROJECT_URL.'/noticias-detalhe.php?cod='.$tpNoticia['cod'];
								?>
                                <div class="fb-like" data-href="<?=$linkCurtir;?>" data-width="100" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
                            </div>
                            <div class="detalheshareitem" id="tweet">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://<?=PROJECT_URL;?>/home.php" data-via="revistadogremio" data-lang="pt">Tweetar</a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                            </div>
                            <div class="detalheshareitem">
                                <script src="//platform.linkedin.com/in.js" type="text/javascript">
                                 lang: pt_BR
                                </script>
                                <script type="IN/Share" data-url="http://<?=PROJECT_URL;?>/anuncios/revenda/nakar-veiculos/novo/fiat-uno-9779/rs/porto-alegre"></script>
                            </div>
                            <div class="detalheshareitem" id="plus">
                                <!-- Place this tag where you want the +1 button to render. -->
                                <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120"></div>
                                
                                <!-- Place this tag after the last +1 button tag. -->
                                <script type="text/javascript">
                                  window.___gcfg = {lang: 'pt-BR'};
                                
                                  (function() {
                                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                    po.src = 'https://apis.google.com/js/platform.js';
                                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                  })();
                                </script>
                            </div>
                        </div>
                        <div class="faixafontevoltarbot">
                            <a href="javascript:history.back();">
                                <img alt="Voltar" src="<?=ssl().PROJECT_URL;?>/img/setavoltar.png" />
                                Voltar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralNoticias();
                    imprimeBannerLateralPequenoNoticias();
                    ?>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>