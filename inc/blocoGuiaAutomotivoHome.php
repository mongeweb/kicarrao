<div class="centrorodape">
	<div class="centrorodapeinside">
        <?/*<div class="linksbloco">
            <p class="linkstitulo">Links</p>
            <div class="linkslista">
                <!--<div><a href="http://< ?=PROJECT_URL;?>/fipe.php"><img src="< ?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Tabela Fipe</a></div>-->
                <div>
                	<a href="http://www.fipe.org.br/web/index.asp?p=51&aspx=/web/indices/veiculos/default.aspx" target="_blank">
                		<img src="<?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Tabela Fipe
                  	</a>
                </div>
                <div><a href="http://www.detran.rs.gov.br/" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Detran RS</a></div>
                <div><a href="http://www.detran.sc.gov.br/" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Detran SC</a></div>
                <div><a href="http://www.detran.pr.gov.br/" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Detran PR</a></div>
                <div><a href="http://www.denatran.gov.br/links.htm" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Denatran (links úteis)</a></div>
                <!--<div><a href="#"><img src="< ?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;PRF</a></div>-->
                <div><a href="<?=ssl().PROJECT_URL;?>/arquivos/documentos/cod-defesa-consumidor.pdf" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Cód. Defesa Consumidor</a></div>
                <!--<div><a href="#"><img src="< ?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Entradas</a></div>-->
                <div><a href="https://maps.google.com.br/" target="_blank"><img src="<?=ssl().PROJECT_URL;?>/img/setalinks.png" alt="Links" />&nbsp;Google Maps</a></div>
            </div>
        </div>*/?>
        <div class="guiabloco">
            <p class="guiatitulo">Guia Automotivo</p>
            <p class="guiasubtitulo">As melhores lojas automotivas</p>
            <?
            $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-loja' : sslRedir().PROJECT_URL.'/anuncio-loja.php';
            ?>
            <a class="anunciesualoja" href="<?=$link;?>"><img src="../img/botaoanunciesualoja.gif" border="0" /></a>
			<div class="guialistabloco">
                <?php
                $conexao = conexao();
				$sqlGuias = mysql_query("SELECT cod, empresa, fone1, fone2, site FROM guiaAutomotivo WHERE destaque = 1 ORDER BY rand()");
                $nGuias = mysql_num_rows($sqlGuias);
				$aux = 0;
                
                //AO SE INSERIR UMA NOVA CATEGORIA NO BANCO, O COD E O ÍCONE CORRESPONDENTES DEVEM SER INSERIDOS NESTE ARRAY PARA A MANIPULAÇÃO
                $iconesGuias = array(
                                    3 => ssl().PROJECT_URL."/img/guia-seguro.png",
                                    4 => ssl().PROJECT_URL."/img/guia-guincho.png",
                                    5 => ssl().PROJECT_URL."/img/guia-oficinas.png",
                                    6 => ssl().PROJECT_URL."/img/guia-rodas.png",
                                    7 => ssl().PROJECT_URL."/img/guia-lavagem.png",
                                    8 => ssl().PROJECT_URL."/img/guia-autopecas.png",
                                    9 => ssl().PROJECT_URL."/img/guia-autosom.png",
                                    10 => ssl().PROJECT_URL."/img/guia-insulfilm.png",
                                    11 => ssl().PROJECT_URL."/img/guia-autocenter.png",
                                    12 => ssl().PROJECT_URL."/img/guia-pneus.png",
                                    13 => ssl().PROJECT_URL."/img/guia-motopecas.png"
                                );
               	for($x = 0;$x < $nGuias;$x++)
    			{
					$tpGuias = mysql_fetch_assoc($sqlGuias);
					
					$sqlRelCatGuias = mysql_query("SELECT codCat FROM guiasRelacao WHERE codGuia = ".$tpGuias['cod'] ."");
					$numRelCatGuias = mysql_num_rows($sqlRelCatGuias);
                    
					if($numRelCatGuias > 0)
                    {
                        $tpRelCatGuias = mysql_fetch_assoc($sqlRelCatGuias);
					
    					$sqlCatGuias = mysql_query("SELECT cod, categoria FROM guiaAutomotivoCategorias WHERE cod = ".$tpRelCatGuias['codCat'] ."");
    					$numCatGuias = mysql_num_rows($sqlCatGuias);
                        
    					$sqlFotoGuias = mysql_query("SELECT arquivo FROM arquivos WHERE referencia = 'guiaAutomotivo' AND codReferencia = ".$tpGuias['cod']." AND tipo = 1");
    					$numFotoGuias = mysql_num_rows($sqlFotoGuias);
                        $tpFotoGuias = mysql_fetch_assoc($sqlFotoGuias);
                        if($numCatGuias > 0)
                        {
                           $aux++;
                           $tpCatGuias = mysql_fetch_assoc($sqlCatGuias);
                    ?>
                    		<?
							$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo' : sslRedir().PROJECT_URL.'/guia-automotivo.php';
							?>
                            <div class="guialistaitem">
                                <!--<div class="guiacategoria"><?=$tpCatGuias['categoria'];?></div>-->
                                <div class="guiacategoria">
                                    <?php
                                    if(key_exists($tpCatGuias['cod'],$iconesGuias));
                                    {
                                    ?>
                                        <img src="<?=$iconesGuias[$tpCatGuias['cod']];?>" alt="<?=$tpCatGuias['categoria'];?>" />
                                    <?
                                    }
                                    ?>
                                    <span><?=$tpCatGuias['categoria'];?></span>
                                </div>
                                <a href="<?=$link;?>" class="guialistaimgwrap">
                                    <span class="guialistaimg">                           	
                                  		<img src="<?=$numFotoGuias > 0 ? ssl().PROJECT_URL.'/arquivos/guia-automotivo/'.$tpFotoGuias['arquivo'] : ssl().PROJECT_URL.'/img/placeholderHomeGuia.jpg';?>" alt="<?=$tpGuias['empresa'];?>" />
                                    </span>
                                </a>
                                <a href="<?=$link;?>" class="guiasHome">
                                    <span class="guialistatitulo"><?=$tpGuias['empresa'];?></span>
                                    <span class="guialistafone"><?=$tpGuias['fone1'];?></span>
                                </a>
                            </div>
                <?
                        if($aux == 5)
                            break;
                        }
                    }
                }
                mysql_close();
                ?>
            </div>
        </div>
    </div>
</div>