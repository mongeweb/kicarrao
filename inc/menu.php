<div class="menu">
    <div class="menuinside">
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
        ?>
        <div class="menuitem menuhome"><a href="<?=$link;?>"><img src="<?=ssl().PROJECT_URL;?>/img/home.png" alt="Home" title="Home" /></a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/planos' : sslRedir().PROJECT_URL.'/anuncio-planos.php';
        ?>
        <div class="menuitem"><a href="<?=$link;?>">Anuncie</a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/revendas' : sslRedir().PROJECT_URL.'/revendas.php';
        ?>
        <div class="menuitem"><a href="<?=$link;?>" rel="canonical">Revendas</a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/?filtroBusca=1' : sslRedir().PROJECT_URL.'/busca.php?filtroBusca=1';
        ?>
        <div class="menuitem"><a href="<?=$link;?>" rel="canonical">Particulares</a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo' : sslRedir().PROJECT_URL.'/guia-automotivo.php';
        ?>
        <div class="menuitem"><a href="<?=$link;?>">Guia Automotivo</a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/noticias' : sslRedir().PROJECT_URL.'/noticias.php';
        ?>
        <div class="menuitem"><a href="<?=$link;?>">Notícias</a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/fipe' : sslRedir().PROJECT_URL.'/fipe.php';
        // http://www.fipe.org.br/web/index.asp?p=51&aspx=/web/indices/veiculos/default.aspx
        ?>
        <div class="menuitem"><a href="<?=$link;?>">FIPE</a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/detrans' : sslRedir().PROJECT_URL.'/detrans.php';
        ?>
        <div class="menuitem"><a href="<?=$link;?>">DETRANS</a></div>
        <div class="divisora">&nbsp;</div>
        <?
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/fale-conosco' : sslRedir().PROJECT_URL.'/fale-conosco.php';
        ?>
        <div class="menuitem"><a href="<?=$link;?>">Fale Conosco</a></div>
    </div>
</div>