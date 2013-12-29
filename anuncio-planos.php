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
    
    $("div.planotitulo a").click(function(){
        $("div.sobreposto").show();
        $(this).parent().parent().find("div.planomodalbloco").show();
    })
    
    $("div.planomodalfechar").click(function(){
        $("div.sobreposto").hide();
        $(this).parent("div.planomodalbloco").hide();
    })
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
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados' : sslRedir().PROJECT_URL.'/anuncio-dados.php';
    ?>
    <form name="planoForm" id="planoForm" action="<?=$link;?>" method="post">
        <input type="hidden" name="planoInput" id="planoInput" value="" />
    </form>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="planoinside">
                    <div class="planotitulogeral">Planos para Particulares</div>
                    <div class="tabelaplanos">
                        <div class="planotitulobloco">
                            <div class="planocelula">
                                <div class="planotitulo">Planos</div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">Tempo de veiculação</div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">
                                    <p>Destaque na capa<br /> do site</p> 
                                    <a><img src="<?=ssl().PROJECT_URL;?>/img/ajuda.png" alt="Ajuda" /></a>
                                </div>
                                <div class="planomodalbloco">
                                    <div class="planomodalfechar"><img src="http://<?=PROJECT_URL;?>/img/modalfechar.png" alt="Fechar" /></div>
                                    <div class="planomodal1">
                                        <div class="planomodalimg"><img src="<?=ssl().PROJECT_URL;?>/img/_planodestaquecapa.jpg" alt="" /></div>
                                        <div class="planomodaltexto">
                                            <!--
<span class="planomodaltitulo">Seu anúncio com destaque na capa do site</span><br />
                                            Seu anúncio será exibido na capa do site, trazendo uma visibilidade maior para o seu veículo.
-->
                                        </div>
                                        <div class="planomodaltexto1">
                                            <span class="exibeOuro">EXIBIÇÃO OURO</span><br />
                                            <span>
                                            Super Destaque Home</span><br /> 
                                            A foto principal do seu anúncio será exibida na página inicial do site em posição de destaque. Excelente visibilidade para o seu veículo.
                                            <br />
                                            <img src="./img/_planodestaquecapa_detplanouro.jpg">
                                        </div>
                                        <div class="planomodaltexto2">
                                            <span class="exibePrata">EXIBIÇÃO PRATA</span><br />
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
                                    <p>Destaque na lista<br /> de resultados</p> 
                                    <a><img src="<?=ssl().PROJECT_URL;?>/img/ajuda.png" alt="Ajuda" /></a>
                                </div>
                                <div class="planomodalbloco">
                                    <div class="planomodalfechar"><img src="http://<?=PROJECT_URL;?>/img/modalfechar.png" alt="Fechar" /></div>
                                    <div class="planomodal2">
                                        <div class="planomodalimg"><img src="<?=ssl().PROJECT_URL;?>/img/_planodestaquelista.jpg" alt="" /></div>
                                        <div class="planomodaltexto">
                                            <!--
<span class="planomodaltitulo">Seu anúncio com destaque na lista de resultados</span><br />
                                            Como resposta a uma busca por veículos, seu anúncio aparecerá de forma diferenciada no topo da lista de resultados.
-->
                                        </div>
                                        <div class="planomodaltexto3"> 
                                            <span class="exibeOuro">EXIBIÇÃO OURO</span><br />
                                            <span>Super Destaque Busca</span><br /> 
                                            Assume os primeiros lugares no resultado de busca. Além disso, possui borda destacada, o que proporciona uma visibilidade ainda maior para o anúncio.
                                            <br />
                                            <img src="./img/_planodestaquelista_detplanouro.jpg" />
                                        </div>
                                        <div class="planomodaltexto4">
                                            <span class="exibePrata">EXIBIÇÃO PRATA</span><br />
                                            <span>Destaque Busca</span><br />
                                            Entre os primeiros no resultado da busca, abaixo apenas do Super Destaque Busca. Excelente visibilidade para o anúncio. Possui borda destacada.
                                            <br />
                                            <img src="./img/_planodestaquelista_detplanprata.jpg" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">Número de fotos</div>
                            </div>
                            <!--<div class="planocelula">
                                <div class="planotitulo">Vídeos</div>
                            </div>-->
                            <div class="planocelula">
                                <div class="planotitulo">
                                    <p>Alerta por e-mail</p>
                                </div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">Valor</div>
                            </div>
                            <div class="planocelula">
                                <div class="planotitulo">&nbsp;</div>
                            </div>
                        </div>
                        <?
                        $conexao = conexao();
                        $tipoAnuncio = isset($_SESSION['tipoAnuncio']) ? $_SESSION['tipoAnuncio'] : '';
                        $qPlanos = mysql_query("SELECT * FROM planosParticular ORDER BY ordem");
                        $nPlanos = mysql_num_rows($qPlanos);
                        $planos = array();
                        while($tpPlano = mysql_fetch_assoc($qPlanos))
                        {
                            $planos[$tpPlano['plano']] = $tpPlano;
                        }
                        mysql_close();
                        ?>
                        <div class="planolista">
                            <div class="planocelula">        
                                <div class="planotipo ouro">Ouro</div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca"><?=$planos['Ouro']['tempo'];?> dias</div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Ouro']['destaqueCapa'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca"><?=$planos['Ouro']['destaqueLista'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Ouro']['nFotos'];?></div>
                            </div>
                            <!--<div class="planocelula">
                                <div class="linhabranca">< ?=$planos['Ouro']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>-->
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Ouro']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca">
                                    <p class="planopreco planoouro">
                                        <? 
										$valorPlano = number_format($planos['Ouro']['valor'],2,',','.');
										$valorDia = number_format($planos['Ouro']['valor']/$planos['Ouro']['tempo'],2,',','.');
										if($valorPlano == '0,00'){
										?>
											<span class="planonumero planoouro">Grátis</span><br />
										<?
										}else{
										?>
											<span class="planoreais">R$</span> <span class="planonumero planoouro"><?=$valorPlano;?></span><br />
										<?
										}
										if($valorPlano != '0,00')
										{
											echo "R$ ". $valorDia . " por dia";
										}
										?>
                                    </p>
                                </div>
                            </div>
                            <?
                            if($tipoAnuncio != '2')
                            {
                            ?>
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Ouro">Anunciar</a>
                                    </div>
                                </div>
                            <?
                            }
                            ?> 
                        </div>
                        <div class="planolista">
                            <div class="planocelula">        
                                <div class="planotipo prata">Prata</div>
                            </div>
                            <div class="planocelula">    
                                <div class="linhabranca"><?=$planos['Prata']['tempo'];?> dias</div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Prata']['destaqueCapa'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca"><?=$planos['Prata']['destaqueLista'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Prata']['nFotos'];?></div>
                            </div>
                            <!--<div class="planocelula">
                                <div class="linhabranca">< ?=$planos['Prata']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>-->
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Prata']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca">
                                    <p class="planopreco planoprata">
                                        <? 
										$valorPlano = number_format($planos['Prata']['valor'],2,',','.');
										$valorDia = number_format($planos['Prata']['valor']/$planos['Prata']['tempo'],2,',','.');
										if($valorPlano == '0,00'){
										?>
											<span class="planonumero planoprata">Grátis</span><br />
										<?
										}else{
										?>
											<span class="planoreais">R$</span> <span class="planonumero planoprata"><?=$valorPlano;?></span><br />
										<?
										}
										if($valorPlano != '0,00')
										{
											echo "R$ ". $valorDia . " por dia";
										}
										?>
                                    </p>
                                </div>
                            </div>
                            <?
                            if($tipoAnuncio != '2')
                            {
                            ?>
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Prata">Anunciar</a>
                                    </div>
                                </div>
                            <?
                            }
                            ?>         
                        </div>
                        <div class="planolista">
                            <div class="planocelula">
                                <div class="planotipo bronze">Bronze</div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca"><?=$planos['Bronze']['tempo'];?> dias</div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Bronze']['destaqueCapa'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca"><?=$planos['Bronze']['destaqueLista'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Bronze']['nFotos'];?></div>
                            </div>
                            <!--<div class="planocelula">
                                <div class="linhabranca">< ?=$planos['Bronze']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>-->
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Bronze']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca">
                                    <p class="planopreco planobronze">
                                        <? 
										$valorPlano = number_format($planos['Bronze']['valor'],2,',','.');
										$valorDia = number_format($planos['Bronze']['valor']/$planos['Bronze']['tempo'],2,',','.');
										if($valorPlano == '0,00'){
										?>
											<span class="planonumero planobronze">Grátis</span><br />
										<?
										}else{
										?>
											<span class="planoreais">R$</span> <span class="planonumero planobronze"><?=$valorPlano;?></span><br />
										<?
										}
										if($valorPlano != '0,00')
										{
											echo "R$ ". $valorDia . " por dia";
										}
										?>
                                    </p>
                                </div>
                            </div>
                            <?
                            if($tipoAnuncio != '2')
                            {
                            ?>    
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Bronze">Anunciar</a>
                                    </div>
                                </div>
                            <?
                            }
                            ?>     
                        </div>
                        <div class="planolista">
                            <div class="planocelula">
                                <div class="planotipo promo">Promo</div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca"><?=$planos['Promo']['tempo'];?> dias</div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Promo']['destaqueCapa'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca"><?=$planos['Promo']['destaqueLista'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Promo']['nFotos'];?></div>
                            </div>
                            <!--<div class="planocelula">
                                <div class="linhabranca">< ?=$planos['Promo']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>-->
                            <div class="planocelula">
                                <div class="linhacinza"><?=$planos['Promo']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                            </div>
                            <div class="planocelula">
                                <div class="linhabranca">
                                    <p class="planopreco planopromo">
                                    	<? 
										$valorPlano = number_format($planos['Promo']['valor'],2,',','.');
										$valorDia = number_format($planos['Promo']['valor']/$planos['Promo']['tempo'],2,',','.');
										if($valorPlano == '0,00'){
										?>
											<span class="planonumero planopromo">Grátis</span><br />
										<?
                                        }else{
										?>
                                            <span class="planoreais">R$</span> <span class="planonumero planopromo"><?=$valorPlano;?></span><br />
                                   		<?
										}
                                    	if($valorPlano != '0,00')
										{
											echo "R$ ". $valorDia . " por dia";
										}
										?>
                                    </p>
                                </div>
                            </div>
                            <?
                            if($tipoAnuncio != '2')
                            {
                            ?>    
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Promo">Anunciar</a>
                                    </div>
                                </div> 
                            <?
                            }
                            ?>   
                        </div>
                        <div class="planoformasbloco">
                            <div class="planocelula">&nbsp;</div>
                            <div class="planoformas">
                                <p>Formas de pagamento</p>
                                <img src="<?=ssl().PROJECT_URL;?>/img/cartoes/formas.jpg" alt="Formas de pagamento" />
                            </div>
                        </div>
                    </div>
                    <div class="planorevendabloco">
                        <div class="planotitulogeral">Planos para Revendas</div>
                        <div class="planorevenda">
                            <?
                                if($tipoAnuncio == '1')
                                {
                                    $link = 'style="cursor:pointer;"';
                                }
                                else if($tipoAnuncio == '2')
                                {
                                    $link = $MG_MR_Settings['active'] ? 'href="'.sslRedir().PROJECT_URL.'/meus-anuncios"' : 'href="'.sslRedir().PROJECT_URL.'/meus-anuncios.php"';
                                }
                                else
                                {
                                    $link = $MG_MR_Settings['active'] ? 'href="'.sslRedir().PROJECT_URL.'/identificacao-revenda"' : 'href="'.sslRedir().PROJECT_URL.'/identificacao-revenda.php"';
                                }
                            ?>
                            <a <?=$link;?>><img src="<?=ssl().PROJECT_URL;?>/img/plano-revenda.png" alt="Anuncie sua Revenda" /></a>
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