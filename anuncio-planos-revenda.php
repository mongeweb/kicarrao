<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    $codTipoVeiculo = isset($_SESSION['codTipoVeiculo']) ? $_SESSION['codTipoVeiculo'] : '';
    $codigoDeArea = isset($_SESSION['codigoDeArea']) ? $_SESSION['codigoDeArea'] : '';
    if($restrita == 1 || $codTipoVeiculo == '')
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
        printf("<script type='text/javascript'>
                    document . location . replace('%s');
                </script>", $link);
        exit();
    }
    ?>
</head>
<script type="text/javascript">
$(document).ready(function()
{
    $('.planocomprar').click(function(){
        
        _plano = $(this).attr('rel');
        $('#planoInput').val(_plano);
        $('form#planoForm').submit();
    })
    
    $("div.planotitulo a").click(function(){
        $("div.sobreposto").show();
        $(this).parent().parent().find("div.planomodalbloco").show();
    })
    
    $("div.planomodalfechar").click(function(){
        $("div.sobreposto").hide();
        $(this).parent("div.planomodalbloco").hide();
    })
    
    _textoPlano1 = $("div.planorevenda1").text();
    _textoPlano2 = $("div.planorevenda2").text();
    $("span.planorevendatitulo1").html(_textoPlano1);
    $("span.planorevendatitulo2").html(_textoPlano2);
});
</script>
<body>
<div class="sobreposto">&nbsp;</div>
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
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados-revenda' : sslRedir().PROJECT_URL.'/anuncio-dados-revenda.php';
    ?>
    <form name="planoForm" id="planoForm" action="<?=$link;?>" method="post">
        <input type="hidden" name="planoInput" id="planoInput" value="" />
    </form>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="planoinside">
                <?
                $conexao = conexao();
                $sqlTipoVeiculo = mysql_query("SELECT * FROM tipoVeiculo WHERE cod = '$codTipoVeiculo'");
                $tpTipoVeiculo = mysql_fetch_assoc($sqlTipoVeiculo);
                mysql_close();
                ?>
                    <div class="planotitulogeral">Planos Revenda <?=$tpTipoVeiculo['tipoVeiculo'];?></div>
                    <div class="tabelaplanos">
                        <div class="planotitulobloco">
                            <div class="planocelula">
                                <div class="planotitulo">Planos</div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">Tempo de veiculação</div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">Quantidade de ofertas</div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">
                                    <p>Nº de ofertas em<br /> destaque na capa do site</p> 
                                    <a><img src="<?=ssl().PROJECT_URL;?>/img/ajuda.png" alt="Ajuda" /></a>
                                </div>
                                <div class="planomodalbloco">
                                    <div class="planomodalfechar"><img src="<?=ssl().PROJECT_URL;?>/img/modalfechar.png" alt="Fechar" /></div>
                                    <div class="planomodal1">
                                        <div class="planomodalimg"><img src="<?=ssl().PROJECT_URL;?>/img/_planodestaquecapa.jpg" alt="" /></div>
                                        <div class="planomodaltexto">
                                            <!--
<span class="planomodaltitulo">Seu anúncio com destaque na capa do site</span><br />
                                            Seu anúncio será exibido na capa do site, trazendo uma visibilidade maior para o seu veículo.
-->
                                        </div>
                                        <div class="planomodaltexto1">
                                            <span class="exibeLaranja planorevendatitulo1">&nbsp;</span><br />
                                            <span>Super Destaque Home</span><br /> 
                                            A foto principal do seu anúncio será exibida na página inicial do site em posição de destaque. Excelente visibilidade para o seu veículo.
                                            <br />
                                            <img src="./img/_planodestaquecapa_detplanouro.jpg">
                                        </div>
                                        <div class="planomodaltexto2">
                                            <span class="exibeAzul planorevendatitulo2">&nbsp;</span><br />
                                            <span>Destaque Home</span><br />
                                            A foto principal do seu anúncio será exibida na página inicial do site, logo abaixo do Super Destaque Home em posição média. Mais destaque para seu veículo.
                                            <br />
                                            <img src="./img/_planodestaquecapa_detplanprata.jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">
                                    <p>Nº de ofertas em<br /> destaque na lista de<br /> resultados</p> 
                                    <a><img src="<?=ssl().PROJECT_URL;?>/img/ajuda.png" alt="Ajuda" /></a>
                                </div>
                                <div class="planomodalbloco">
                                    <div class="planomodalfechar"><img src="<?=ssl().PROJECT_URL;?>/img/modalfechar.png" alt="Fechar" /></div>
                                    <div class="planomodal2">
                                        <div class="planomodalimg"><img src="<?=ssl().PROJECT_URL;?>/img/_planodestaquelista.jpg" alt="" /></div>
                                        <div class="planomodaltexto">
                                           <!--
 <span class="planomodaltitulo">Seu anúncio com destaque na lista de resultados</span><br />
                                            Como resposta a uma busca por veículos, seu anúncio aparecerá de forma diferenciada no topo da lista de resultados.
-->
                                        </div>
                                        <div class="planomodaltexto3"> 
                                            <span class="exibeLaranja planorevendatitulo1">&nbsp;</span><br />
                                            <span>Super Destaque Busca</span><br /> 
                                            Assume os primeiros lugares no resultado de busca. Além disso, possui borda destacada, o que proporciona uma visibilidade ainda maior para o anúncio.
                                            <br />
                                            <img src="./img/_planodestaquelista_detplanouro.jpg" />
                                        </div>
                                        <div class="planomodaltexto4">
                                            <span class="exibeAzul planorevendatitulo2">&nbsp;</span><br />
                                            <span>Destaque Busca</span><br />
                                             Entre os primeiros no resultado da busca, abaixo apenas do Super Destaque Busca. Excelente visibilidade para o anúncio. Possui borda destacada.
                                            <br />
                                            <img src="./img/_planodestaquelista_detplanprata.jpg" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">Número de fotos por oferta</div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">
                                    <p>Alerta por e-mail</p>
                                </div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">
                                    <p>Valor</p>
                                </div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">&nbsp;</div>
                            </div>
                        </div>
                        <?
                        $codigoDeAreaRS = array('51','53','54','55');
                        $codigoDeAreaPR = array('41','42','43','44','45','46');
                        $codigoDeAreaSC = array('47','48','49');
                        if(in_array($codigoDeArea,$codigoDeAreaRS))
                        {
                            $filtroRegiao = 0;
                        }
                        elseif(in_array($codigoDeArea,$codigoDeAreaPR))
                        {
                            $filtroRegiao = 3;
                            /*
                                Quando for cadastrado no Banco de Dados os Planos para PR, descomentar. 
                                $filtroRegiao = 1;
                            */
                        }
                        elseif(in_array($codigoDeArea,$codigoDeAreaSC))
                        {
                            $filtroRegiao = 3;
                            /*
                                Quando for cadastrado no Banco de Dados os Planos para SC, descomentar. 
                                $filtroRegiao = 2;
                            */
                        }
                        else
                        {
                            $filtroRegiao = 3;
                        }
                        $conexao = conexao();
                        $qPlanos = mysql_query("SELECT * FROM planosRevenda WHERE codTipoVeiculo = '$codTipoVeiculo' AND regiao = '$filtroRegiao' ORDER BY ordem");
                        $nPlanos = mysql_num_rows($qPlanos);
                        $planos = array();
                        while($tpPlano = mysql_fetch_assoc($qPlanos))
                        {
                            $planos[] = $tpPlano;
                        }
                        mysql_close();
                        foreach($planos as $key => $plano)
                        {
                            $class = '';
                            $classPreco = '';
                            switch($key)
                            {
                                case 0:
                                    $class = 'planorevenda1';
                                    $classPreco = 'planoouro';
                                    break;
                                case 1:
                                    $class = 'planorevenda2';
                                    $classPreco = 'planoprata';
                                    break;
                                case 2:
                                    $class = 'planorevenda3';
                                    $classPreco = 'planobronze';
                                    break;
                                case 3:
                                    $class = 'planorevenda4';
                                    $classPreco = 'planopromo';
                                    break;
                                default:
                                    $class = 'planorevenda1';
                                    $classPreco = 'planoouro';
                                    break;
                            }
                        ?>
                            <div class="planolista">
                                <div class="planocelula">        
                                    <div class="planotipo <?=$class;?>"><?=$plano['plano'];?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca"><!--<?=$plano['tempo'];?> dias--> Mensal</div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza"><?=$plano['nOfertas'] > 0 ? $plano['nOfertas'] : 'Ilimitado';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca"><?=$plano['destaqueHome'] > 0 ? $plano['destaqueHome'] : $plano['superDestaqueHome'];?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza"><?=$plano['destaqueLista'] > 0 ? $plano['destaqueLista'] : $plano['superDestaqueLista'];?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca"><?=$plano['nFotos'];?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza"><?=$plano['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca">
                                        <p class="planopreco <?=$classPreco;?>">
                                             <? 
    										$valorPlano = number_format($plano['valor'],2,',','.');
    										$valorDia = $plano['nOfertas'] > 0 ? number_format($plano['valor']/$plano['nOfertas'],2,',','.') : '';
    										if($valorPlano == '0,00'){
    										?>
    											<span class="planonumero <?=$classPreco;?>">Grátis</span><br />
    										<?
    										}else{
    										?>
    											<span class="planoreais">R$</span> <span class="planonumero <?=$classPreco;?>"><?=$valorPlano;?></span><br />
    										<?
    										}
    										if($valorPlano != '0,00' && $plano['nOfertas'] > 0)
    										{
    											echo "R$ ". $valorDia . " por oferta";
    										}
    										?>
                                        </p>
                                    </div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="<?=$plano['cod'];?>">Anunciar</a>
                                    </div>
                                </div>
                            </div>
                        <?
                        }
                        ?>
                        <div class="planoformasbloco">
                            <div class="planocelula">&nbsp;</div>
                            <div class="planoformas">
                                <p>Formas de pagamento</p>
                                <img src="<?=ssl().PROJECT_URL;?>/img/cartoes/formas.jpg" alt="Formas de pagamento" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>