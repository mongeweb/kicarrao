<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';?>
    <?php
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    require_once ADMIN_FUNC_PATH.'validaCampo.php';
	?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    <script src="<?=ssl().ADMIN_JS_URL;?>/jquery.maskMoney.js" type="text/javascript"></script>
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
        $(this).parent().parent().find("div.planomodalbloco").show();
    })
    
    $("div.planomodalfechar").click(function(){
        $(this).parent("div.planomodalbloco").hide();
    })
});
</script>
<body>
<div class="mestre">
	<?php require_once PROJECT_INC_PATH.'topo.php';?>
    <?php require_once PROJECT_INC_PATH.'menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
            $link2 = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meus-anuncios' : sslRedir().PROJECT_URL.'/meus-anuncios.php';
            ?>
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<a href="<?=$link2;?>">Meus Anúncios</a>&nbsp; &gt; &nbsp;<span>Renovar Anúncio</span>
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
                <div class="anuncierenovawrap">
                    <div class="anuncierenovamenu">
                        <div class="anunciemenuitem anunciemenuhover" id="dados">
                            <a>Escolher Plano</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft separalefthover"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="identificacao">
                            <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-dados' : sslRedir().PROJECT_URL.'/anuncio-dados.php';
                            ?>
                            <a href="<?=$link;?>">Dados do Veículo</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="fotos">
                            <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-fotos' : sslRedir().PROJECT_URL.'/anuncio-fotos.php';
                            ?>
                            <a href="<?=$link;?>">Fotos</a>
                        </div>
                        <div class="anunciemenusepara">
                            <div class="menuseparaleft"></div>
                            <div class="menusepararight"></div>
                            <div class="separalinha"></div>
                        </div>
                        <div class="anunciemenuitem" id="finalizacao">
                            <?
                            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-finalizacao' : sslRedir().PROJECT_URL.'/anuncio-finalizacao.php';
                            ?>
                            <a href="<?=$link;?>">Finalização</a>
                        </div>
                    </div>
                    <div class="anuncierenovabloco" id="dadosveiculo">
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
                                        <div class="planomodalfechar"><img src="http://<?=PROJECT_URL;?>/img/esquecifechar.png" alt="Fechar" /></div>
                                        <div class="planomodal">
                                            <div class="planomodalimg"><img src="<?=ssl().PROJECT_URL;?>/img/wireframe1.jpg" alt="" /></div>
                                            <div class="planomodaltexto">
                                                <span>Seu anúncio na capa do site</span><br />
                                                Seu anúncio será exibido na capa<br />
                                                do site, trazendo uma visibilidade<br /> 
                                                maior para o seu veículo.
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
                                        <div class="planomodalfechar"><img src="http://<?=PROJECT_URL;?>/img/esquecifechar.png" alt="Fechar" /></div>
                                        <div class="planomodal">
                                            <div class="planomodalimg"><img src="<?=ssl().PROJECT_URL;?>/img/wireframe2.jpg" alt="" /></div>
                                            <div class="planomodaltexto">
                                                <span>Seu anúncio no topo da lista</span><br />
                                                Como resposta a uma busca por<br /> 
                                                veículos, seu anúncio aparecerá de <br />
                                                forma diferenciada no topo da lista <br />
                                                de resultados.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="planocelula">
                                    <div class="planotitulo">Número de fotos</div>
                                </div>
                                <div class="planocelula">
                                    <div class="planotitulo">Vídeos</div>
                                </div>
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
                                <div class="planocelula">
                                    <div class="linhabranca"><?=$planos['Promo']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza"><?=$planos['Promo']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca">
                                        <p class="planopreco planopromo">
                                            <span class="planoreais">R$</span> <span class="planonumero planopromo">
    											<?=number_format($planos['Promo']['valor'],2,',','.');?>
                                            </span>
                                            <br />
                                            R$ <?=number_format($planos['Promo']['valor']/$planos['Bronze']['tempo'],2,',','.')?> por dia
                                        </p>
                                    </div>
                                </div>    
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Promo">Anunciar</a>
                                    </div>
                                </div>    
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
                                <div class="planocelula">
                                    <div class="linhabranca"><?=$planos['Bronze']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza"><?=$planos['Bronze']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca">
                                        <p class="planopreco planobronze">
                                            <span class="planoreais">R$</span> <span class="planonumero planobronze"><?=number_format($planos['Bronze']['valor'],2,'.',',');?></span><br />
                                            R$ <?=number_format($planos['Bronze']['valor']/$planos['Bronze']['tempo'],2,'.',',')?> por dia
                                        </p>
                                    </div>
                                </div>    
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Bronze">Comprar</a>
                                    </div>
                                </div>    
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
                                <div class="planocelula">
                                    <div class="linhabranca"><?=$planos['Prata']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza"><?=$planos['Prata']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca">
                                        <p class="planopreco planoprata">
                                            <span class="planoreais">R$</span> <span class="planonumero planoprata"><?=number_format($planos['Prata']['valor'],2,'.',',');?></span><br />
                                            R$ <?=number_format($planos['Prata']['valor']/$planos['Prata']['tempo'],2,'.',',')?> por dia
                                        </p>
                                    </div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Prata">Comprar</a>
                                    </div>
                                </div>        
                            </div>
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
                                <div class="planocelula">
                                    <div class="linhabranca"><?=$planos['Ouro']['video'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza"><?=$planos['Ouro']['alertaEmail'] > 0 ? '<img src="'.ssl().PROJECT_URL.'/img/ok.png" alt="Ok" />' : '-';?></div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhabranca">
                                        <p class="planopreco planoouro">
                                            <span class="planoreais">R$</span> <span class="planonumero planoouro"><?=number_format($planos['Ouro']['valor'],2,'.',',');?></span><br />
                                            R$ <?=number_format($planos['Ouro']['valor']/$planos['Ouro']['tempo'],2,'.',',')?> por dia
                                        </p>
                                    </div>
                                </div>
                                <div class="planocelula">
                                    <div class="linhacinza">
                                        <a class="planocomprar" href="#" rel="Ouro">Comprar</a>
                                    </div>
                                </div>
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