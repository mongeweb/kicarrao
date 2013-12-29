<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
        $titulo = 'Quem somos';
        require_once PROJECT_INC_PATH.'head.php';
    ?>
</head>
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
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Quem Somos</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="empresabloco">
                    <div class="empresatopo">
                        <div class="empresatexto">
                            Tendo em vista as dificuldades que o setor de veículos usados possui, decidimos criar uma ferramenta que ofereça aos seus usuários as melhores condições para comercialização de seus produtos e serviços.<br />
                            <br />
                            O grupo MH Correa, através do Portal www.kicarrao.com.br, disponibiliza para o comprador uma maneira mais rápida, eficiente e econômica de localizar veículos a venda, e para o vendedor a melhor forma de divulgação de seus produtos.<br />
                            <br />
                            O KiCarrão é um site moderno e inovador no setor de anúncios automotivos.<br />
                            Sua principal área de atuação são os estados da região sul: Rio Grande do Sul, Santa Catarina e Paraná.
                        </div>
                        <img src="<?=ssl().PROJECT_URL?>/img/empresafoto.png" alt="Quem Somos" />
                    </div>
                    <div class="missaobloco">
                        <img src="<?=ssl().PROJECT_URL?>/img/missaofoto.png" alt="Nossa Missão" />
                        <div class="missaotexto">
                            <span class="missaotitulo">Nossa Missão</span>
                            Nossa missão é transformar o portal em uma ferramenta indispensável para concretização de bons negócios, e para que isto ocorra, buscamos sempre aprimorar nossos serviços, investindo em novas tecnologias, novas técnicas e profissionais qualificados, garantindo assim, que o portal KiCarrão torne-se referência para o setor de anúncios automotivos.<br />
                            <span>Seja Bem Vindo ao Kicarrão!</span>
                        </div>
                    </div>
                </div>
                <!--<div class="noticiapropaganda">
                    <a href="#"><img src="http://<? //=PROJECT_URL;?>/img/adsnoticia1.jpg" alt="Informativo" /></a>
                    <a href="#"><img src="http://<? //=PROJECT_URL;?>/img/adsnoticia2.jpg" alt="Informativo" /></a>
                    <a href="#"><img src="http://<? //=PROJECT_URL;?>/img/adsrevenda3.jpg" alt="Informativo" /></a>
                </div>-->
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>