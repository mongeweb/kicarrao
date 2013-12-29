<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
</head>
<script type="text/javascript">
$(document).ready(function()
{
    $('.planocomprar').click(function(){
        
        _plano = $(this).attr('rel');
        $('#planoInput').val(_plano);
        $('form#planoForm').submit();
    })
});
</script>
<?
$cod = isset($cod) ? $cod : 1;
$cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
?>
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
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Anuncie</span>&nbsp; &gt; &nbsp;<span>Planos</span>
            </div>
        </div>
    </div>
    <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados' : sslRedir().PROJECT_URL.'/anuncio-dados.php';
    ?>
    <form name="planoForm" id="planoForm" action="<?=$link;?>" method="post">
        <input type="hidden" name="planoInput" id="planoInput" value="" />
    </form>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="publiesq">
                    <div class="publimenu">
                        <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/publicidade/1' : sslRedir().PROJECT_URL.'/publicidade.php?cod=1';
                        ?>
                        <div class="publimenuitem"><a <?=$cod == 1 ? 'class="publimenuhover"' : '';?> href="<?=$link;?>">BANNER RETÂNGULO TOPO</a></div>
                        <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/publicidade/2' : sslRedir().PROJECT_URL.'/publicidade.php?cod=2';
                        ?>
                        <div class="publimenuitem"><a <?=$cod == 2 ? 'class="publimenuhover"' : '';?> href="<?=$link;?>">FULL BANNER</a></div>
                        <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/publicidade/3' : sslRedir().PROJECT_URL.'/publicidade.php?cod=3';
                        ?>
                        <div class="publimenuitem"><a <?=$cod == 3 ? 'class="publimenuhover"' : '';?> href="<?=$link;?>">BANNER RETÂNGULO</a></div>
                        <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/publicidade/4' : sslRedir().PROJECT_URL.'/publicidade.php?cod=4';
                        ?>
                        <div class="publimenuitem"><a <?=$cod == 4 ? 'class="publimenuhover"' : '';?> href="<?=$link;?>">SUPER BANNER</a></div>
                        <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/publicidade/5' : sslRedir().PROJECT_URL.'/publicidade.php?cod=5';
                        ?>
                        <div class="publimenuitem"><a <?=$cod == 5 ? 'class="publimenuhover"' : '';?> href="<?=$link;?>">BANNER LATERAL</a></div>
                        <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/publicidade/6' : sslRedir().PROJECT_URL.'/publicidade.php?cod=6';
                        ?>
                        <div class="publimenuitem"><a <?=$cod == 6 ? 'class="publimenuhover"' : '';?> href="<?=$link;?>">BANNER LATERAL PEQUENO</a></div>
                    </div>
                </div>
                <div class="publidir">
                    <?
                    if($cod == 1){
                    ?>
                            <div class="planotitulogeral">Banner Retângulo Topo</div>
                            <div class="publi-lista">
                                <div class="publi-item">
                                    <div class="publi-exemplo">
                                        <img src="http://<?=PROJECT_URL;?>/img/pub-banner-retangulo-topo.jpg" alt="BANNER RETÂNGULO TOPO" />
                                        <div class="publi-seta" id="seta1"><img src="http://<?=PROJECT_URL;?>/img/publicidadeseta1.png" alt="" /></div>
                                    </div>
                                    <div class="publi-banner">
                                        <div class="publi-foto">
                                            <a><img src="http://<?=PROJECT_URL;?>/img/publicidade-banner1.png" alt="" /></a>
                                        </div>
                                        <div class="publi-texto">
                                            <span>Especificações Gerais:</span><br />
                                            Dimensões: 346 x 220 pixels<br />
                                            Formatos permitidos: Flash, GIF e JPEG<br />
                                            Peso máximo do arquivo: 40 KB<br />
                                            Tempo de aparição: 15 segundos (máx.) por looping
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        
                        if($cod == 2){
                        ?>
                            <div class="planotitulogeral">Full Banner</div>
                            <div class="publi-lista">
                                <div class="publi-item">
                                    <div class="publi-exemplo">
                                        <img src="http://<?=PROJECT_URL;?>/img/pub-full-banner.jpg" alt="FULL BANNER" />
                                        <div class="publi-seta" id="seta2"><img src="http://<?=PROJECT_URL;?>/img/publicidadeseta2.png" alt="" /></div>
                                    </div>
                                    <div class="publi-banner">
                                        <div class="publi-foto" id="fullbanner">
                                            <a><img src="http://<?=PROJECT_URL;?>/img/publicidade-banner2.png" alt="" /></a>
                                        </div>
                                        <div class="publi-texto">
                                            <span>Especificações Gerais:</span><br />
                                            Dimensões: 796 x 68 pixels<br />
                                            Formatos permitidos: Flash, GIF e JPEG<br />
                                            Peso máximo do arquivo: 40 KB<br />
                                            Tempo de aparição: 15 segundos (máx.) por looping
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        
                        if($cod == 3){
                        ?>
                            <div class="planotitulogeral">Banner Retângulo</div>
                            <div class="publi-lista">
                                <div class="publi-item">
                                    <div class="publi-exemplo">
                                        <img src="http://<?=PROJECT_URL;?>/img/pub-banner-retangulo.jpg" alt="BANNER RETÂNGULO" />
                                        <div class="publi-seta" id="seta3"><img src="http://<?=PROJECT_URL;?>/img/publicidadeseta3.png" alt="" /></div>
                                    </div>
                                    <div class="publi-banner">
                                        <div class="publi-foto" id="bannerret">
                                            <a><img src="http://<?=PROJECT_URL;?>/img/publicidade-banner3.png" alt="" /></a>
                                        </div>
                                        <div class="publi-texto">
                                            <span>Especificações Gerais:</span><br />
                                            Dimensões: 260 x 89 pixels<br />
                                            Formatos permitidos: Flash, GIF e JPEG<br />
                                            Peso máximo do arquivo: 40 KB<br />
                                            Tempo de aparição: 15 segundos (máx.) por looping
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        
                        if($cod == 4){
                        ?>
                            <div class="planotitulogeral">Super Banner</div>
                            <div class="publi-lista">
                                <div class="publi-item">
                                    <div class="publi-exemplo">
                                        <img src="http://<?=PROJECT_URL;?>/img/pub-super-banner.jpg" alt="SUPER BANNER" />
                                        <div class="publi-seta" id="seta4"><img src="http://<?=PROJECT_URL;?>/img/publicidadeseta4.png" alt="" /></div>
                                    </div>
                                    <div class="publi-banner">
                                        <div class="publi-foto" id="superbanner">
                                            <a><img src="http://<?=PROJECT_URL;?>/img/publicidade-banner4.png" alt="" /></a>
                                        </div>
                                        <div class="publi-texto">
                                            <span>Especificações Gerais:</span><br />
                                            Dimensões: 634 x 167 pixels<br />
                                            Formatos permitidos: Flash, GIF e JPEG<br />
                                            Peso máximo do arquivo: 40 KB<br />
                                            Tempo de aparição: 15 segundos (máx.) por looping
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        
                        if($cod == 5){
                        ?>
                            <div class="planotitulogeral">Banner Lateral</div>
                            <div class="publi-lista">
                                <div class="publi-item">
                                    <div class="publi-exemplo">
                                        <img src="http://<?=PROJECT_URL;?>/img/pub-banner-lateral.jpg" alt="BANNER LATERAL" />
                                        <div class="publi-seta" id="seta5"><img src="http://<?=PROJECT_URL;?>/img/publicidadeseta5.png" alt="" /></div>
                                    </div>
                                    <div class="publi-banner">
                                        <div class="publi-foto" id="bannerlateral">
                                            <a><img src="http://<?=PROJECT_URL;?>/img/publicidade-banner5.png" alt="" /></a>
                                        </div>
                                        <div class="publi-texto">
                                            <span>Especificações Gerais:</span><br />
                                            Dimensões: 260 x 89 pixels<br />
                                            Formatos permitidos: Flash, GIF e JPEG<br />
                                            Peso máximo do arquivo: 40 KB<br />
                                            Tempo de aparição: 15 segundos (máx.) por looping
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        
                        if($cod == 6){
                        ?>
                            <div class="planotitulogeral">Banner Lateral Pequeno</div>
                            <div class="publi-lista">
                                <div class="publi-item">
                                    <div class="publi-exemplo">
                                        <img src="http://<?=PROJECT_URL;?>/img/pub-banner-lateral-pequeno.jpg" alt="BANNER LATERAL PEQUENO" />
                                        <div class="publi-seta" id="seta6"><img src="http://<?=PROJECT_URL;?>/img/publicidadeseta5.png" alt="" /></div>
                                    </div>
                                    <div class="publi-banner">
                                        <div class="publi-foto" id="bannerlateral">
                                            <a><img src="http://<?=PROJECT_URL;?>/img/publicidade-banner6.png" alt="" /></a>
                                        </div>
                                        <div class="publi-texto">
                                            <span>Especificações Gerais:</span><br />
                                            Dimensões: 153 x 128 pixels<br />
                                            Formatos permitidos: Flash, GIF e JPEG<br />
                                            Peso máximo do arquivo: 40 KB<br />
                                            Tempo de aparição: 15 segundos (máx.) por looping
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        ?>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>