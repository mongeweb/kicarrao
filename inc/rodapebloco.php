<div class="rodapebloco">
    <div class="rodaperedes">
        <div class="rodapeinside">
            <div class="redestexto">Acompanhe o Kicarrão nas <br /><span>Redes Sociais</span></div>
            <div class="redesicones">
                <a href="https://www.facebook.com/kicarrao" target="_blank">
                    <img src="<?=ssl().PROJECT_URL;?>/img/facebook.png" alt="Facebook" />
                </a>
                <a href="https://twitter.com/kicarrao" target="_blank">
                    <img src="<?=ssl().PROJECT_URL;?>/img/twitter.png" alt="Twitter" />
                </a>
                <a href="http://instagram.com/kicarrao" target="_blank">
                    <img src="<?=ssl().PROJECT_URL;?>/img/icoInstagram.png" alt="Instagram" />
                </a>
                <!--<a href="#" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/orkut.png" alt="Orkut" /></a>
                <a href="#" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/rss.png" alt="RSS" /></a>-->
                <a href="http://www.youtube.com/user/kicarrao?feature=watch" target="_blank">
                    <img src="<?=ssl().PROJECT_URL;?>/img/youtube.png" alt="YouTube" />
                </a>
                <!--<a href="#" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/google.png" alt="Google" /></a>
                <a href="#" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/flickr.png" alt="Flickr" /></a>-->
            </div>
        </div>
    </div>
    <div class="rodapelinks">
        <div class="rodapeinside">
            <div class="rodapelinkbloco">
                <div class="rodapelinklista">
                    <div class="rodapelinktitulo">Institucional</div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/politica-de-privacidade' : sslRedir().PROJECT_URL.'/politica-de-privacidade.php';
                    ?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Política de privacidade</a></div>
                    <div class="rodapelinkitem"><a href="<?=ssl().PROJECT_URL;?>/arquivos/documentos/cod-defesa-consumidor.pdf" target="_blank">Cód Defesa Consumidor</a></div>
                    <div class="rodapelinkitem"><a href="<?=ssl().PROJECT_URL;?>/quem-somos.php">Quem somos</a></div>
                </div>
                <div class="rodapelinklista">
                    <div class="rodapelinktitulo">Mapa do Site</div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/planos' : sslRedir().PROJECT_URL.'/planos.php';
                    ?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Anuncie</a></div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca' : sslRedir().PROJECT_URL.'/busca.php';
                    ?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Compre particulares</a></div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revendas' : sslRedir().PROJECT_URL.'/revendas.php';
                    ?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Compre revenda</a></div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/publicidade/1' : sslRedir().PROJECT_URL.'/publicidade.php?cod=1';
					?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Publicidade</a></div>
                    <?
                    if($restrita == 1){
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/meu-cadastro' : sslRedir().PROJECT_URL.'/meu-cadastro.php';
                    }else{
                        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/identificacao' : sslRedir().PROJECT_URL.'/identificacao.php';
                    }
                    ?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Central do cliente</a></div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo' : sslRedir().PROJECT_URL.'/guia-automotivo.php';
                    ?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Guia automotivo</a></div>
                </div>
                <div class="rodapelinklista">
                    <div class="rodapelinktitulo">Atendimento</div>
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/fale-conosco' : sslRedir().PROJECT_URL.'/fale-conosco.php';
                    ?>
                    <div class="rodapelinkitem"><a href="<?=$link;?>">Fale conosco</a></div>
                   <!-- <div class="rodapelinkitem"><a href="#">Dúvidas</a></div>-->
                </div>
                <div class="rodapelinklista">
                   <div class="rodapelinktitulo">Mais Buscados</div>
                    <div class="rodapelinkitem"><a href="<?=ssl().PROJECT_URL;?>/revendas" title="Revenda de Carros">Revenda de Carros RS</a></div>
                    <div class="rodapelinkitem"><a href="<?=ssl().PROJECT_URL;?>/busca/?q=&filtroBusca=2&tipo=1&marca=144&modelo=276&anoInicial=&anoFinal=&precoInicial=&precoFinal=&order=" title="Renault Sandero seminovo rs">Renault Sandero</a></div>
                      <div class="rodapelinkitem"><a href="<?=ssl().PROJECT_URL;?>/busca/?filtroBusca=1&tipo=1&marca=&modelo=&anoInicial=&anoFinal=&precoInicial=&precoFinal=&codigo=" title="Carros Usados em Porto Alegre">Carros Usados em Porto Alegre</a></div>
                        
                    
                </div>
            </div>
        </div>
    </div>
    <div class="rodape">
        <div class="rodapeinside">
            <div class="copyright">
            
                <div class="rapidssl"><img src="<?=ssl().PROJECT_URL;?>/img/rapidssl.png" alt="Secured by Rapid SSL - Secure Site" />
                 

                </div>
                © 2013 Kicarrão - <a href="http://www.monge.com.br" target="_blank">Monge Web + Design</a>.
            </div>
            <div class="rodapelogo">
                <?
                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
                ?>
                <a href="<?=$link;?>"><img src="<?=ssl().PROJECT_URL;?>/img/logofooter.png" alt="Kicarrão" /></a>
           


            </div>
        </div>
    </div>
</div>
<noscript>
    <meta http-equiv='refresh' content='0; url=http://www.kicarrao.com.br/noscript.php' />
</noscript>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 989763481;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript style="border-style:none;">
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/989763481/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>