<?php require_once 'configRoot.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    require_once ADMIN_FUNC_PATH."formatting.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jcarousellite.js"></script>
    <link rel="stylesheet" href="<?=ssl().PROJECT_URL;?>/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/validador1.4.js"></script>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jquery.maskedinput.js"></script>
    <style type="text\css" media="print">
    #myFooter, #myHeader
    {
        display: none;
    }
    </style>
</head>
<body>
    <?
    require_once PROJECT_FUNC_PATH.'enviarEmail.php';
    $cod = isset($cod) ? $cod : '';
    $cod = isset($_GET['cod']) ? $_GET['cod'] : $cod;
    $dataHoje = date("Y-m-d");
    $filtroSqlNomeRevenda = isset($nomeRevUrl) && $nomeRevUrl != '' ? " AND c.cleanTitulo='".$nomeRevUrl."' " : '';
    $conexao = conexao();
    $sqlAnuncio = mysql_query("SELECT ca.cod, c.cod as codCliente, ca.codPlanoParticular, c.codPlanoRevenda, ca.km, ca.cor, ca.combustivel, ca.versao, ca.anoFabricacao, ca.dataLiberacaoAnuncio,
                                ca.anoModelo, vm.marca, vmd.modelo, ca.valor, ca.valorParcela, ca.nPortas, ca.nParcelas, ca.valorEntrada, ca.caractVeiculo, ca.dataValidadeAnuncio,
                                c.email, ca.placa, c.razaoSocialNome, c.sobrenome, c.nomeFantasia, c.cleanTitulo, c.telRes, c.telCel, c.endereco, c.numero, c.cidade, c.bairro, c.estado, c.tipoAnuncio, c.responsavel,
                                ca.marca as codMarca, ca.modelo as codModelo
                                FROM clientesAnuncios AS ca
                                INNER JOIN veiculosMarcas AS vm ON vm.cod = ca.marca
                                INNER JOIN veiculosModelos AS vmd ON vmd.cod = ca.modelo 
                                INNER JOIN clientes AS c ON c.cod = ca.codCliente
                                WHERE ca.cod = '$cod' $filtroSqlNomeRevenda AND ca.status = 1 AND c.situacao = 1");
    $numAnuncio = mysql_num_rows($sqlAnuncio);
    if($numAnuncio < 1)
    {
        $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
        die(printf("<script>
                        document.location.replace('%s');
                    </script>"
                    ,$link));
    }
    $tpAnuncio = mysql_fetch_assoc($sqlAnuncio);
    /*
    echo "<div id='vardump' style='display: none; position: fixed; z-index: 99999;'>";
        var_dump($tpAnuncio);
    echo "</div>";
    //*/
    if($tpAnuncio['versao'] != '0')
    {
        $sqlVersao = mysql_query("SELECT * FROM veiculosVersoes WHERE cod = '{$tpAnuncio['versao']}'");
        $tpVersao = mysql_fetch_assoc($sqlVersao);
        $versao = $tpVersao['versao'];
    }
    else
    {
        $versao = '';
    }
    ?>
    <script>
    $(document).ready(function()
    {
        window.print();
    });
    </script>
    <div class="imprimirmestre">
        <div class="imprimirinside">
            <div class="imprimirtopo">
                <div class="imprimirlogo">
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/home' : sslRedir().PROJECT_URL.'/home.php';
                    ?>
                    <a href="<?=$link;?>"><img src="<?=ssl().PROJECT_URL;?>/img/logo.png" alt="Kicarrão" /></a>
                </div>
                <?
                $anos = array();
                $tpAnuncio['anoFabricacao'] != '' ? $anos[]=$tpAnuncio['anoFabricacao'] : '';
                $tpAnuncio['anoModelo'] != '' ? $anos[]=$tpAnuncio['anoModelo'] : '';
                $combustivel = combustivel($tpAnuncio['combustivel']);
                mysql_close();
                ?>
                <div class="imprimirpropriedade">
                    <?
                    $conexao = conexao();
                    $sqlFotoCliente = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '{$tpAnuncio['codCliente']}' AND referencia = 'clienteRevenda' AND tipo = '1'");
                    $numFotoCliente = mysql_num_rows($sqlFotoCliente);
                    $tpFotoCliente = mysql_fetch_assoc($sqlFotoCliente);
                    mysql_close();
					// tipo 2 = revenda
					if($tpAnuncio['tipoAnuncio'] == '2')
                    {
                    ?>    
                        <div class="imprimirpropriedadeimg">
                            <a>
                                <img src="<?=$numFotoCliente > 0 ? ssl().PROJECT_URL.'/arquivos/clientesRevendas/'.$tpFotoCliente['arquivo'] : ssl().PROJECT_URL.'/img/placeholderRevDetalhe.jpg';?>" alt="<?=$tpAnuncio['nomeFantasia'] != '' ? $tpAnuncio['nomeFantasia'] : $tpAnuncio['razaoSocialNome'];?>" />
                            </a>
                        </div>
                    <?
                    }
					else
					{
                    ?>
                    	<div class="imprimirpropriedadeimg">
                            <a>
                                <img src="<?=ssl().PROJECT_URL.'/img/veiculo-particular.png';?>" alt="Particular" />
                            </a>
                        </div>                    
                    <?
					}
					?>
                    <!--
                    <div class="imprimirpropriedadeimg">
                        <a>
                            <img src="<?=ssl().PROJECT_URL.'/img/revenda5.jpg';?>" alt="Vando Automóveis" />
                        </a>
                    </div>
                    -->
                    <?php
					// tipo 2 = revenda
                    if($tpAnuncio['tipoAnuncio'] == '2')
                    {
                    ?>
                        <div class="imprimirpropriedadetexto">
                            <span><?=$tpAnuncio['nomeFantasia'] != '' ? $tpAnuncio['nomeFantasia'] : $tpAnuncio['razaoSocialNome'];?></span>
                            <?=$tpAnuncio['endereco'];?><?=$tpAnuncio['numero'] != '' ? ", ".$tpAnuncio['numero'] : "";?> <br /> 
                            <?=$tpAnuncio['bairro'] != '' ? $tpAnuncio['bairro']." - " : "";?> 
            				<?=$tpAnuncio['cidade'] != '' ? $tpAnuncio['cidade'] : "";?> 
            				<?=$tpAnuncio['estado'] != '' ? " / ".$tpAnuncio['estado'] : "";?> 
                            <span class="propriedadefone"><?=$tpAnuncio['telRes'];?><?=$tpAnuncio['telCel'] != '' ? " <br> ".$tpAnuncio['telCel'] : "";?></span>
                        </div>
                    <?php
                    }
                    else
                    {
                    ?>
                        <div class="imprimirpropriedadetexto">
                            <span><?=$tpAnuncio['razaoSocialNome']." ".$tpAnuncio['sobrenome'];?> </span>
                            <?=$tpAnuncio['cidade'] != '' ? $tpAnuncio['cidade'] : "";?> 
        				    <?=$tpAnuncio['estado'] != '' ? " / ".$tpAnuncio['estado'] : "";?> 
                            <span class="propriedadefone"><?=$tpAnuncio['telRes'];?><?=$tpAnuncio['telCel'] != '' ? " <br> ".$tpAnuncio['telCel'] : "";?></span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="centro">
            	<div class="imprimircentroinside">
                    <div class="noticiablocogeral">
                        <div class="detalheleft">
                            <?
                            $conexao = conexao();
                            $sqlFotosAnuncioCapaM = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '2' AND referencia = 'clientesAnuncios' AND capa = '1'");
                            $sqlFotosAnuncioCapaG = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '3' AND referencia = 'clientesAnuncios' AND capa = '1'");
                            $numFotosAnuncio = mysql_num_rows($sqlFotosAnuncioCapaM);
                            if($numFotosAnuncio > 0)
                            {
                                $tpFotosAnuncioCapaM = mysql_fetch_assoc($sqlFotosAnuncioCapaM);
                                $tpFotosAnuncioCapaG = mysql_fetch_assoc($sqlFotosAnuncioCapaG);
                                
                                $sqlFotosAnuncioP = mysql_query("SELECT * FROM arquivos WHERE codReferencia = '$cod' AND tipo = '1' AND referencia = 'clientesAnuncios' AND capa = '0'");
                                $numFotosAnuncioP = mysql_num_rows($sqlFotosAnuncioP);
                            ?>
                                <!--<div class="detalhefotobloco" <?=$numFotosAnuncioP > 0 ? '' : 'style="width:auto;"';?>>
                                    <div class="detalhefotowrap">
                                        <div class="detalhefoto">
                                            <a href="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaG['arquivo'];?>" id="fancy" rel="galeria">
                                                <img src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaM['arquivo'];?>" alt="Revenda" />
                                            </a>
                                            <a href="<?=ssl().PROJECT_URL;?>/img/detalhefoto.jpg" id="fancy" rel="galeria">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/detalhefoto.jpg" width="479" alt="Revenda" />
                                            </a>
                                            
                                            <a href="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaG['arquivo'];?>" id="fancy" rel="galeria">
                                                <img src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaM['arquivo'];?>" alt="Revenda" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                -->
                                <div class="imprimirdetalhefotobloco">
                                    <div class="detalhefotowrap">
                                        <div class="detalhefoto">
                                            <!--<a href="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaG['arquivo'];?>" id="fancy" rel="galeria">
                                                <img src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaM['arquivo'];?>" alt="Revenda" />
                                            </a>
                                            <a href="<?=ssl().PROJECT_URL;?>/img/detalhefoto.jpg" id="fancy" rel="galeria">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/detalhefoto.jpg" width="479" alt="Revenda" />
                                            </a>-->
                                            <a>
                                                <img src="<?=ssl().PROJECT_URL;?>/arquivos/clientesAnuncios/<?=$tpFotosAnuncioCapaM['arquivo'];?>" alt="Revenda" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?
                            }
                            $anos = array();
                            $tpAnuncio['anoFabricacao'] != '' ? $anos[]=$tpAnuncio['anoFabricacao'] : '';
                            $tpAnuncio['anoModelo'] != '' ? $anos[]=$tpAnuncio['anoModelo'] : '';
                            $combustivel = combustivel($tpAnuncio['combustivel']);
                            mysql_close();
                            ?>
                            
                            
                        </div>
                        <div class="imprimirdetalheright">
                            <div class="detalhetextobloco">
                                <div class="detalhetopo">
                                    <div class="detalhecodigo">
                                        cód. <?=$cod;?>
                                    </div>
                                </div>
                                <div class="imprimirvalortotal">
                                    <div class="imprimirvalorimg">
                                        <img src="<?=ssl().PROJECT_URL;?>/img/fundoprecodetalhe.png" alt="" />
                                    </div>
                                    <div class="imprimirvalortexto">
                                        Valor R$ <span style="color: #FFF;"><?=number_format($tpAnuncio['valor'],2,',','.');?></span>
                                    </div>
                                </div>
                                <div class="detalhetexto">
                                    <div class="detalhetextoesq">
                                        <!--Bmw X6<br />--><?=$tpAnuncio['marca'];?> <?//=$tpAnuncio['modelo'];?> <?=$versao;?>
                                        <!--Ano/Modelo: 2008/2008<br />--><?=count($anos) > 0 ? 'Ano/Modelo: '.implode("/",$anos).'<br />' : '';?>
                                        <!--Cor: PRATA<br />--><?=$tpAnuncio['cor'] != '' ? 'Cor: '.$tpAnuncio['cor'].'<br />' : '';?>
                                        <!--Placa: AXX-6336--><?=$tpAnuncio['placa'] != '' ? 'Placa: '.$tpAnuncio['placa'].'<br />' : '';?>
                                    </div>
                                    <div class="detalhetextodir">
                                        <?=$tpAnuncio['combustivel'] != '' ? 'Combustível: '.$combustivel.'<br />' : '';?>
                                        <?=$tpAnuncio['km'] != '0' && $tpAnuncio['km'] != '1' ? 'Km: '.$tpAnuncio['km'].' km<br />' : '';?>
                                        <?=$tpAnuncio['nPortas'] != '0' ? 'Portas: '.$tpAnuncio['nPortas'].'<br />' : '';?>
                                        <?=$tpAnuncio['valorEntrada'] != '0' ? 'Entrada: R$ '.number_format($tpAnuncio['valorEntrada'],2,',','.').'<br />' : '';?>
                                        <?=$tpAnuncio['nParcelas'] != '0' ? 'Nº de Parcelas: '.$tpAnuncio['nParcelas'].'<br />' : '';?>
                                        <?=$tpAnuncio['valorParcela'] != '0' ? 'Valor da Parcela: R$ '.number_format($tpAnuncio['valorParcela'],2,',','.') : '';?>
                                    </div>
                                </div>
                                <div class="atributobloco">
                                    <div class="atributotopo">
                                        Detalhes do Veículo
                                    </div>
                                    <div class="atributolistawrap">
                                        <div class="atributolista">
                                            <!--
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>Air Bag</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>Controle automático de velocidade</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>Ar Condicionado</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>Limpador traseiro</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-naopossui.png" alt="Possui" />
                                                <span>Direção Hidráulica</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>Protetor de caçamba</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>Freio ABS</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>CD e MP3 Player</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-naopossui.png" alt="Possui" />
                                                <span>Banco do motorista com ajuste de altura</span>
                                            </div>
                                            <div class="atributoitem">
                                                <img src="<?=ssl().PROJECT_URL;?>/img/atributo-possui.png" alt="Possui" />
                                                <span>Capota marítima</span>
                                            </div>
                                            -->
                                            <div style="color: #6E6E6E; font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; line-height: 16px;">
                                                <?=$tpAnuncio['caractVeiculo'] != '' ? nl2br($tpAnuncio['caractVeiculo']) : '';?>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="imprimirrodape">
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <img src="<?=ssl().PROJECT_URL;?>/img/fundorodapeimprimir.png" alt="" />
                <div class="imprimirrodapelogo">
                    <img alt="Kicarrão" src="<?=ssl().PROJECT_URL;?>/img/logofooter.png" />
                </div>
            </div>
        </div>
    </div>
</body>
</html>