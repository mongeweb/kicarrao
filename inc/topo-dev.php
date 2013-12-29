<?php
require_once ADMIN_FUNC_PATH.'funcoes.php';
  
$filtroBuscaTopo = isset($_GET['filtroBusca']) && $_GET['filtroBusca'] == 1 ? 1 : (isset($_GET['filtroBusca']) && $_GET['filtroBusca'] == 2 ? 2 : 3);
$tipoTopo = isset($_GET['tipo']) ? (int)$_GET['tipo'] : ''; 
$marcaTopo = isset($_GET['marca']) ? (int)$_GET['marca'] : '';
$modeloTopo = isset($_GET['modelo']) ? (int)$_GET['modelo'] : '';
$versaoTopo = isset($_GET['versao']) ? (int)$_GET['versao'] : '';
$kmTopo = isset($_GET['km']) ? (int)$_GET['km'] : '';
$combustivelTopo = isset($_GET['combustivel']) ? escape(urldecode($_GET['combustivel'])) : '';
$portasTopo = isset($_GET['portas']) ? (int)$_GET['portas'] : '';
$corTopo = isset($_GET['cor']) ? escape(urldecode($_GET['cor'])) : '';
$estadoTopo = isset($_GET['estado']) ? escape(urldecode($_GET['estado'])) : '';
$cidadeTopo = isset($_GET['cidade']) ? escape(urldecode($_GET['cidade'])) : '';
$anoInicialTopo = isset($_GET['anoInicial']) ? (int)$_GET['anoInicial'] : '';
$anoFinalTopo = isset($_GET['anoFinal']) ? (int)$_GET['anoFinal'] : (int)date("Y",strtotime("+1 YEAR"));
$precoInicialTopo = isset($_GET['precoInicial']) ? (int)$_GET['precoInicial'] : '';
$precoFinalTopo = isset($_GET['precoFinal']) ? (int)$_GET['precoFinal'] : '';
$placaTopo = isset($_GET['placa']) ? escape(urldecode($_GET['placa'])) : '';
$codigoTopo = isset($_GET['codigo']) ? (int)$_GET['codigo'] : '';
$apenasFotoTopo = isset($_GET['apenasFoto']) && $_GET['apenasFoto'] == 1 ? 1 : '';
$qTopo = isset($_GET['q']) && !empty($_GET['q']) ? escape(urldecode($_GET['q'])) : '';
?>

<!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">
var script = document.createElement("script");script.async=true;script.type="text/javascript";var src = "http://ftp.kicarrao.com.br/www/livezilla/server.php?acid=f9e3b&request=track&output=jcrpt&ovlp=MjI_&ovlc=I2ZmZmZmZg__&ovlct=IzgwODA4MA__&ovlt=UG9zc28gQWp1ZMOhLWxvPyAoSW5pY2lhciBDaGF0KQ__&ovlto=QXRlbmRpbWVudG8gT0ZGTElORSA_&ovls=MQ__&ovloo=MQ__&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><noscript><img src="http://ftp.kicarrao.com.br/www/livezilla/server.php?acid=f9e3b&amp;request=track&amp;output=nojcrpt&amp;ovlp=MjI_&amp;ovlc=I2ZmZmZmZg__&amp;ovlct=IzgwODA4MA__&amp;ovlt=UG9zc28gQWp1ZMOhLWxvPyAoSW5pY2lhciBDaGF0KQ__&amp;ovlto=QXRlbmRpbWVudG8gT0ZGTElORSA_&amp;ovls=MQ__&amp;ovloo=MQ__" width="0" height="0" style="visibility:hidden;" alt=""></noscript>
<!-- http://www.LiveZilla.net Tracking Code -->
<script type="text/javascript">
function verificaCookies()
{
    $.ajax(
    {
        type: "POST",
        url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxVerificaCookies.php",
        data:
        {
        
        },
        dataType: "json", 
        success: function(j)
        { 
            _resultado = j.retorno;
            if(_resultado == 0)
            {
                $('.selecionados').hide();
            }
            else
            {
                console.log(_resultado);
                $('.selecionados').find('b').text(_resultado);
            }
        }
    });
}
$(document).ready(function()
{
    verificaCookies();
})
</script>
<div class="topo">
    <div class="topoinside">
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
        ?>
        <div class="logo"><a href="<?=$link;?>"><img src="<?=ssl().PROJECT_URL;?>/img-dev/logo.png" alt="Kicarrão" /></a></div>
        <div class="buscabloco">
            <div class="loginbloco">
            <?
            if($restrita != 1)
            {
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
            ?>
                <div class="loginbotao"><a href="<?=$link;?>">Entrar</a></div>
            <?
            }
            else
            {
                $nomeUsuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
            ?>
                <div class="logadobloco">
                    <p class="logadotitulo">Olá, <?=$nomeUsuario;?>!</p>
                    <br class="clear" />
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meu-cadastro' : sslRedir().PROJECT_URL.'/meu-cadastro.php';
                    ?>
                    <div class="logadobotao"><a href="<?=$link;?>">Meu Cadastro</a></div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
                    ?>
                    <div class="logadobotao"><a href="<?=$link;?>">Meus Anúncios</a></div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/deslogar' : sslRedir().PROJECT_URL.'/deslogar.php';
                    ?>
                    <div class="logadosair"><a href="<?=$link;?>">Sair</a></div>
                </div>
                
            <?
            }
            
            $cookirFav = isset($_COOKIE['favoritos']) && $_COOKIE['favoritos'] != '' ? unserialize($_COOKIE['favoritos']) : array();
            $numFav = count($cookirFav);
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/favoritos' : sslRedir().PROJECT_URL.'/favoritos.php';
            ?>
            <div class="selecionados" <?=$numFav > 0 ? 'style="display:block;"' : 'style="display:none;"';?>>
                <a href="<?=$link;?>">
                    <img src="<?=ssl().PROJECT_URL;?>/img/estrela.png" alt="Itens selecionados" />
                    <span><b><?=$numFav;?></b> favoritos</span>
                </a>
            </div>
            </div>
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/' : sslRedir().PROJECT_URL.'/busca.php';
            ?>
            <form name="buscaform" id="buscaform" method="get" action="<?=$link;?>">
                <div class="buscainput">
                    <input type="text" name="q" id="buscar" title="Buscar" value="<?=$qTopo;?>" />
                    <input type="submit" <?/*name="enviarBusca"*/;?> id="enviarBusca" title="Buscar" value="&nbsp;" />
                </div>
                <div class="buscatopo">
                    <!--<p class="buscatitulo">BUSCA</p>-->
                    <div class="buscafiltro">
                        <div class="filtro">
                            <input checked="true" type="radio" class="uncheck" name="filtroBusca" id="filtroBuscaRevenda" value="2" <?=$filtroBuscaTopo == 2 ? "checked='true'" : '';?> title="Selecionar filtro" />
                            <span>Revendas</span>
                        </div>
                        <div class="filtro">
                            <input type="radio" class="uncheck" name="filtroBusca" id="filtroBuscaParticular" value="1" <?=$filtroBuscaTopo == 1 ? "checked='true'" : '';?> title="Selecionar filtro" />
                            <span>Particulares</span>
                        </div>
                        <div class="filtro">
                            <input type="radio" class="uncheck" name="filtroBusca" id="filtroBuscaAmbos" value="3" <?=$filtroBuscaTopo == 3 ? "checked='true'" : '';?> title="Selecionar filtro" />
                            <span>Ambos</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>