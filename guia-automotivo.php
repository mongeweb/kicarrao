<?php 
require_once 'configRoot.php';
$estadoGuia = isset($estadoGuia) ? str_replace("+"," ",rawurldecode($estadoGuia)) : '';
$estadoGuia = isset($_GET['e']) ? str_replace("+"," ",rawurldecode($_POST['e'])) : $estadoGuia;

$cidadeGuia = isset($cidadeGuia) ? str_replace("+"," ",rawurldecode($cidadeGuia)) : '';
$cidadeGuia = isset($_GET['ci']) ? str_replace("+"," ",rawurldecode($_POST['ci'])) : $cidadeGuia;

$pagina = isset($pagina) ? $pagina : '';
$pagina = isset($_GET['p']) ? $_GET['p'] : $pagina;

$cat = isset($cat) ? $cat: '';
$cat = isset($_GET['c']) ? $_GET['c'] : $cat;

$categoria = isset($categoria) ? $categoria: '';

$urlPaginacao = '';
$filtroSql = '';
$urlSelect = '';
$urlCategorias = '';
if($MG_MR_Settings['active'])
{
    if($estadoGuia != '')
    {
       $urlPaginacao .= "/e:".str_replace(" ","+",$estadoGuia);
       $urlCategorias .= "/e:".str_replace(" ","+",$estadoGuia);
    }
    if($cidadeGuia != '')
    {
       $urlPaginacao .= "/ci:".str_replace(" ","+",$cidadeGuia);
       $urlCategorias .= "/ci:".str_replace(" ","+",$cidadeGuia);
    }
    if($cat != '')
    {
       $urlPaginacao .= "/c:".$cat;
       $urlSelect .= "/c:".$cat;
    }
    if($categoria != '')
    {
       $urlPaginacao .= "/ca:".$categoria;
       $urlSelect .= "/ca:".$categoria;
    }  
       
}
else
{
    if($estadoGuia != '')
    {
       $urlPaginacao .= "&e=".str_replace(" ","+",$estadoGuia);
       $urlCategorias .= "&e=".str_replace(" ","+",$estadoGuia);
    }
    if($cidadeGuia != '')
    {
        $urlPaginacao .= "&ci=".str_replace(" ","+",$cidadeGuia);
        $urlCategorias .= "&ci=".str_replace(" ","+",$cidadeGuia);
    }
    if($cat != '')
    {
       $urlPaginacao .= "&c=".$cat;
       $urlSelect .= "&c=".$cat;
    }
}
if($estadoGuia != '')
   $filtroSql .= " AND ga.estado = '".$estadoGuia."'";
if($cidadeGuia != '')
   $filtroSql .= " AND ga.cidade = '".$cidadeGuia."'";
if($cat != '')
   $filtroSql .= " AND gr.codCat = '".$cat."'";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_INC_PATH.'head.php';
    require_once PROJECT_INC_PATH."publicidade.php";
    ?>
    <script type="text/javascript" src="<?=ssl().PROJECT_URL;?>/js/jcarousellite.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
        	_visible = 8;
			//if($(".guiaiconebloco li").length > 8)
			//{
				$(".guiaiconebloco").jCarouselLite({
					btnPrev: ".setaguiaesq",
					btnNext: ".setaguiadir",
					speed: 200,
					circular : true,
					visible: _visible,
					auto: 5000,
					beforeStart: function(_obj,_els)
					{
						$(".guiaiconebloco li").each(function(){
							//console.log(_els);
							_elEnd = _els.eq(_visible-1).next();
							_elPrev = _els.eq(_visible-1);
							_index = $(this).index();
							//console.log(_index);
							_length = $(this).parent().find('li').length;
							//console.log(_length);
							//console.log(_elEnd);
							//console.log(_elPrev);
							//console.log("--------");
							$(this).removeClass("noborder");
							if(_index == (_length-1)){
								//console.log("true");
								_elEnd.addClass("noborder");    
							}
							
						})
					}
				});
				//$('.setaguiadir,.setaguiaesq').show();
			//}
            $("div.guiaicone").mouseover(function(){
                _id = $(this).find("a").attr("id");    
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/guia-"+_id+"-hover.png");
                $(this).find("a").css({'color':'#A60F09'});
                if($(this).find("a").hasClass("marcado")){
                    $(this).mouseout(function(){
                        $(this).find("a.marcado").find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/guia-"+_id+"-hover.png");
                    })
                }else{
                    $(this).mouseout(function(){
                        $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/guia-"+_id+".png");
                        $(this).find("a").css({'color':'#333'});
                    })
                }
            });
            $("div.guiaicone").each(function(){
                _id = $(this).find("a").attr("id");
                $(this).find("a.marcado").find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/guia-"+_id+"-hover.png");
            })
            
            $("p.guiafone").hide();
            $("div.verfone").click(function(){
                _obj = $(this);
                _obj.parent().find("p.guiafone").show();
                _obj.find("a").hide();
                _cod = _obj.attr('rel');
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/ajaxGuiaAutoStats.php", //URL de destino
                    data:
                    {
                        cod: _cod
                    },
                    dataType: "json", //Tipo de Retorno
                    success: function(j)
                    { 
                    }
                });
            })
            
           $('#estadoRevenda').change(function(){
        
            
            _estado = $("select[name='estadoRevenda'] > option:selected").val().replace(" ","+"); 
            _estado =  _estado != '' ? "/e:"+_estado : '';
            
            _redireciona = "<?=sslRedir().PROJECT_URL;?>/guia-automotivo"+_estado+"<?=$urlSelect;?>";
    		location.replace(_redireciona);
          })
          $('#cidadeRevenda').change(function(){
            
            _junta = new Array();
            
            _estado = $("select[name='estadoRevenda'] > option:selected").val().replace(" ","+"); 
            _estado != '' ? _junta.push("e:"+_estado) : '';
            
             _cidade = $("select[name='cidadeRevenda'] > option:selected").val().replace(" ","+"); 
            _cidade != '' ? _junta.push("ci:"+_cidade) : '';
            
            _redireciona = "<?=sslRedir().PROJECT_URL;?>/guia-automotivo/"+_junta.join("/")+"<?=$urlSelect;?>";
    		location.replace(_redireciona);
          })
          
          $(".irPagina").click(function(){
                
                _pagina = $("#digitaPagina").val();
                _totalPaginas = $('#totaDePagina').attr('rel');
                console.log(_pagina);
                console.log(_totalPaginas);
                if(_pagina != '' && _pagina != 0)
                {
                    _pagina = parseInt(_pagina) > parseInt(_totalPaginas) ? _totalPaginas : _pagina;
                    _redireciona = "<?=sslRedir().PROJECT_URL;?>/guia-automotivo/p:"+_pagina+"<?=$urlPaginacao;?>";
        	        location.replace(_redireciona);
                }
            })
          
            $("div.paginaAnterior").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaoesqhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaoesq.png");    
                })
            })
            $("div.paginaSeguinte").mouseover(function(){
                $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaodirhover.png");
                $(this).mouseout(function(){
                    $(this).find("img").attr("src","<?=ssl().PROJECT_URL;?>/img/paginacaodir.png");    
                })
            })
        })
    </script>
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
                <a href="<?=$link;?>">Home</a>&nbsp; &gt; &nbsp;<span>Guia Automotivo</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="noticiablocogeral">
                <div class="guiawrap">
                <div class="revendatopo">
                        <form name="revendaSelecao" id="revendaSelecao" method="post" action="" enctype="multipart/form-data">
                            <div class="inputleft">
                                <div class="inputbloco">
                                    <label for="estadoRevenda">Estado</label>
                                    <select class="selectpequeno" name="estadoRevenda" id="estadoRevenda" title="Estado">
                                        <option value="" >Selecione</option>
                                        <?
                                        $conexao = conexao();
                                        $sqlEstados = mysql_query("SELECT estado FROM guiaAutomotivo WHERE mostrar = '1' AND estado != '' GROUP BY estado ORDER BY estado");
                                        $numEstados = mysql_num_rows($sqlEstados);
                                        for($x = 0;$x < $numEstados;$x++)
                                        {
                                            $tpEstados = mysql_fetch_assoc($sqlEstados);
                                        ?>
                                            <option value="<?=$tpEstados['estado'];?>" <?=$estadoGuia == $tpEstados['estado'] ? 'selected="selected"' : '';?> ><?=$tpEstados['estado'];?></option>
                                        <?
                                        }
                                        mysql_close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="inputright">
                                <div class="inputbloco">
                                    <label for="cidadeRevenda">Cidade</label>
                                    <select class="selectgrande" name="cidadeRevenda" id="cidadeRevenda" title="Cidade">
                                        <option value="" >-</option>
                                        <?
                                        if($estadoGuia != '')
                                        {
                                            $conexao = conexao();
                                            $sqlCidades = mysql_query("SELECT cidade FROM guiaAutomotivo WHERE mostrar = '1' AND estado = '{$estadoGuia}' AND cidade != '' GROUP BY cidade ORDER BY estado");
                                            $numCidades = mysql_num_rows($sqlCidades);
                                            for($x = 0;$x < $numCidades;$x++)
                                            {
                                                $tpCidades = mysql_fetch_assoc($sqlCidades);
                                        ?>
                                                <option value="<?=$tpCidades['cidade'];?>" <?=$cidadeGuia == $tpCidades['cidade'] ? 'selected="selected"' : '';?> ><?=$tpCidades['cidade'];?></option>
                                        <?
                                            }
                                            mysql_close();
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="cadastreGuia">
                        	<?
							$link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/anuncio-loja' : sslRedir().PROJECT_URL.'/anuncio-loja.php';
							?>
							<a class="anunciesualoja" href="<?=$link;?>"><img src="img/botaoanunciesualoja.gif" border="0"></a>
                        </div>
                    </div>
                    <div class="setaguiaesq"><img src="<?=ssl().PROJECT_URL;?>/img/setaguiaesq.png" alt="Anterior" /></div>
                    <div class="setaguiadir"><img src="<?=ssl().PROJECT_URL;?>/img/setaguiadir.png" alt="Próxima" /></div>
                    <div class="guiaiconebloco">
                        <ul>
                        	<li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:8/ca:autopecas'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=8'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="autopecas" <?=$categoria == 'autopecas' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-autopecas.png" alt="Autopeças" /><br />
                                        <span>Autopeças</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:9/ca:autosom'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=9'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="autosom" <?=$categoria == 'autosom' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-autosom.png" alt="Autosom" /><br />
                                        <span>Autosom</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:4/ca:guincho'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=4'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="guincho" <?=$categoria == 'guincho' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-guincho.png" alt="Guincho" /><br />
                                        <span>Guincho</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:10/ca:insulfilm'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=10'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="insulfilm" <?=$categoria == 'insulfilm' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-insulfilm.png" alt="Insulfilm" /><br />
                                        <span>Insulfilm</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:7/ca:lavagem'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=7'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="lavagem" <?=$categoria == 'lavagem' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-lavagem.png" alt="Lavagem" /><br />
                                        <span>Lavagem</span>
                                    </a>
                                </div>
                            </li>
                           
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:5/ca:oficinas'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=5'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="oficinas" <?=$categoria == 'oficinas' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-oficinas.png" alt="Oficinas" /><br />
                                        <span>Oficinas</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:6/ca:rodas'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=6'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="rodas" <?=$categoria == 'rodas' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-rodas.png" alt="Rodas" /><br />
                                        <span>Rodas</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:3/ca:seguro'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=3'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="seguro" <?=$categoria == 'seguro' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-seguro.png" alt="Seguro" /><br />
                                        <span>Seguro</span>
                                    </a>
                                </div>
                            </li>
                             <!----INICIO------------------------------->
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:11/ca:autocenter'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=11'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="autocenter" <?=$categoria == 'autocenter' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-autocenter.png" alt="Auto Center" /><br />
                                        <span>Auto Center</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:12/ca:pneus'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=12'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="pneus" <?=$categoria == 'pneus' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-pneus.png" alt="Pneus" /><br />
                                        <span>Pneus</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="guiaicone">
                                <?
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/c:13/ca:motopecas'.$urlCategorias : sslRedir().PROJECT_URL.'/guia-automotivo.php?c=13'.$urlCategorias;
                                ?>
                                    <a href="<?=$link;?>" id="motopecas" <?=$categoria == 'motopecas' ? 'class="marcado"' : '';?>>
                                        <img src="<?=ssl().PROJECT_URL;?>/img/guia-motopecas.png" alt="Moto Peças" /><br />
                                        <span>Moto Peças</span>
                                    </a>
                                </div>
                            </li>
                            
                            <!----FIM--------------------------------->
                        </ul>
                    </div>
                    <?
					$num_por_pagina = 25; 
					if(empty($pagina))
					{
						$primeiro_registro = 0;
						$pagina = 1;
					}
					else
					{
						$primeiro_registro = ($pagina - 1) * $num_por_pagina;
					}
					$conexao = conexao();
				    $sqlGuiaAuto = mysql_query("SELECT ga.*, gac.categoria, gac.cod AS codCategoria FROM guiasRelacao AS gr 
                                            INNER JOIN guiaAutomotivo AS ga ON ga.cod = gr.codGuia
                                            INNER JOIN guiaAutomotivoCategorias AS gac ON gac.cod = gr.codCat
                                            WHERE ga.mostrar = '1' $filtroSql GROUP BY ga.cod ORDER BY ga.ordem LIMIT $primeiro_registro,$num_por_pagina");
                    $numGuiaAuto = mysql_num_rows($sqlGuiaAuto);
                    
                    $sqlPag = "SELECT ga.*, gac.categoria, gac.cod AS codCategoria FROM guiasRelacao AS gr 
                                INNER JOIN guiaAutomotivo AS ga ON ga.cod = gr.codGuia
                                INNER JOIN guiaAutomotivoCategorias AS gac ON gac.cod = gr.codCat
                                WHERE ga.mostrar = '1' $filtroSql GROUP BY ga.cod ORDER BY ga.ordem";
                    $resultadoPag = mysql_query($sqlPag, $conexao);
                    $linhasPag = mysql_num_rows($resultadoPag);
					
					for($x = 0;$x < $numGuiaAuto; $x++)
					{						
						$tpGuiaAuto = mysql_fetch_assoc($sqlGuiaAuto);
						$placeHolder = '';
                        switch($tpGuiaAuto['codCategoria'])
                        {
                            case '3':
                                $placeHolder = 'seguro.jpg';
                                break;
                            case '4':
                                $placeHolder = 'guincho.jpg';
                                break;
                            case '5':
                                $placeHolder = 'oficinas.jpg';
                                break;
                            case '6':
                                $placeHolder = 'rodas.jpg';
                                break;
                            case '7':
                                $placeHolder = 'lavagem.jpg';
                                break;
                            case '8':
                                $placeHolder = 'autopecas.jpg';
                                break;
                            case '9':
                                $placeHolder = 'autosom.jpg';
                                break;
                            case '10':
                                $placeHolder = 'insulfilm.jpg';
                                break;
                            case '11':
                                $placeHolder = 'autocenter.jpg';
                                break;
                            case '12':
                                $placeHolder = 'pneus.jpg';
                                break;
                            case '13':
                                $placeHolder = 'motopecas.jpg';
                                break;
                        }
						$sqlFotoGuiaAuto = mysql_query("SELECT * FROM arquivos WHERE referencia = 'guiaAutomotivo' AND tipo = '1' AND codReferencia = '{$tpGuiaAuto['cod']}'");
						$numFotoGuiaAuto = mysql_num_rows($sqlFotoGuiaAuto);
                        $tpFotoGuiaAuto = mysql_fetch_assoc($sqlFotoGuiaAuto);
                        
						?>
                            <div class="revendadestaque <?=$x == ($numGuiaAuto-1) ? 'noborder' : '';?>">
                                <div class="guiaitem">
                                    <div class="revendaimgborda">
                                        <div class="revendaimg">
                                            <a <?=$tpGuiaAuto['site'] != '' ? 'href="'.$tpGuiaAuto['site'].'"' : '';?> <?=$tpGuiaAuto['site'] != '' ? 'target="_blank"' : 'style="cursor:inherit;"';?>>
                                                <img style="max-width: 116px; max-height: 87px;" src="<?=$numFotoGuiaAuto > 0 ? ssl().PROJECT_URL.'/arquivos/guia-automotivo/'.$tpFotoGuiaAuto['arquivo'] : ssl().PROJECT_URL.'/img/guiaPlace/'.$placeHolder;?>" alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="guiaitemtexto">
                                        <p class="guiaitemtitulo"><?=$tpGuiaAuto['empresa'];?></p>
                                        <p class="guiaendereco">
                                            <?=$tpGuiaAuto['endereco'];?> <?=$tpGuiaAuto['cidade'] != '' ? " - ".$tpGuiaAuto['cidade'] : "";?> <?=$tpGuiaAuto['estado'] != '' ? " / ".$tpGuiaAuto['estado'] : "";?><?//=$tpGuiaAuto['bairro'] != '' ? " <br /> ".$tpGuiaAuto['bairro'] : "";?> <br />
                                            <?=$tpGuiaAuto['email'] != '' ? "E-mail: <span>".$tpGuiaAuto['email'] : "</span>";
                                               /*$tpGuiaAuto['site'] != '' ? " Site: ".$tpGuiaAuto['site'] : "";*/
                                            ?>
                                        </p>
                                    </div>
                                    <div class="guiafonebloco">
                                        <div class="verfone" rel="<?=$tpGuiaAuto['cod'];?>">
                                            &nbsp;<a>Ver telefone de contato</a>
                                        </div>
                                        <p class="guiafone" style="display: none;">
                                            Fones:<br />
                                            <?=$tpGuiaAuto['fone1'];?><?=$tpGuiaAuto['fone2'] != '' ? " | ".$tpGuiaAuto['fone2'] : "";?>
                                        </p>
                                    </div>
                                </div>
                            </div>
						<?
						}			
						mysql_close();						
                        ?>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralGuias();
                    imprimeBannerLateralPequenoGuias();
                    ?>
                </div>
                <?
                $total_paginas = ($linhasPag/$num_por_pagina);
                $total_paginas = ceil($total_paginas);
                $prev = ($pagina-1);
                $next = ($pagina+1);
                
                if ($pagina > 1)
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/p:'.$prev.$urlPaginacao : sslRedir().PROJECT_URL.'/guia-automotivo.php?p='.$prev.$urlPaginacao;
                    $prev_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaoesq.png' alt='Anterior' /></a>";
                }
                else 
                { // senão não há link para a página anterior
                    $prev_link = "";
                }
                
                if ($total_paginas > 1 && $pagina < $total_paginas )
                {
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/p:'.$next.$urlPaginacao : sslRedir().PROJECT_URL.'/guia-automotivo.php?p='.$next.$urlPaginacao;
                    $next_link = "<a href='".$link."'><img src='".ssl().PROJECT_IMG_URL."/paginacaodir.png' alt='Seguinte' /></a>";
                }
                else
                { 
                    $next_link = "";
                }
                $painel = "";
                if ($total_paginas > 1) 
                {
                    $maxPags = 5;
                    $numeroDePaginas = $total_paginas;
                    if (($maxPags != 0) && ($total_paginas > $maxPags)) 
                    {
                        $paginas = array();
            
                        /** vaiaveis de controle **/
                        $metade = floor($maxPags / 2);
                        $metadeFim = ($maxPags % 2 == 0) ? 1 : 0;
            
                        /** Define inicio e fim das paginas **/
                        $ini = 1;
                        $fim = $numeroDePaginas;
                        while ($numeroDePaginas > $maxPags) 
                        {
                            /** Testa se inicio é menor que 0
                             * se for incrementa
                             **/
                            if (($pagina - $metade) > $ini) 
                            {
                                $ini++;
                                $numeroDePaginas--;
                            }
                            /** Testa se fim é menor que o total de páginas
                             * se for decrementa
                             **/
                            if (($pagina + $metade - $metadeFim) < $fim) 
                            {
                                $fim--;
                                $numeroDePaginas--;
                            }
                        }
            
                        /** Preenche o array com as páginas. **/
                        for ($ini; $ini <= $fim; $ini++) 
                        {
                            $paginas[] = $ini;
                        }
                    
                        for ($x=0; $x < count($paginas); $x++)
                        {
                            if ($pagina==$paginas[$x])
                            {
                                $painel .= "<div class='pagina paginahover'><a href='#'>&nbsp;$paginas[$x]&nbsp;</a></div>";
                            }
                            else
                            {
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/p:'.$paginas[$x].$urlPaginacao : sslRedir().PROJECT_URL.'/guia-automotivo.php?p='.$paginas[$x].$urlPaginacao;
                                $painel .= "<div class='pagina'><a href='".$link."'>&nbsp;$paginas[$x]&nbsp;</a></div>";
                            }
                            //echo $painel;
                        }
                    }
                    else
                    {                     
                        for ($x=1; $x<=$total_paginas; $x++)
                        {
                            if ($x==$pagina)
                            {
                                $painel .= "<div class='pagina paginahover'><a href='#'>&nbsp;$x&nbsp;</a></div>";
                            }
                            else
                            {
                                $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/guia-automotivo/p:'.$x.$urlPaginacao : sslRedir().PROJECT_URL.'/guia-automotivo.php?p='.$x.$urlPaginacao;
                                $painel .= "<div class='pagina'><a href='".$link."'>&nbsp;$x&nbsp;</a></div>";
                            }
                        }
                    }
        	        ?>
                    <div class="paginacaowrap">
                        <div class="paginacaobloco">
                            <!--<div class="paginanavbloco">
                                <div id="totaDePagina" rel="<?=$total_paginas;?>">
                                    Você está na página <span><?=$pagina;?></span> de <span><?=$total_paginas;?></span>
                                </div>
                                <div>
                                    Ir para página: 
                                    <input onkeypress="return verificaNumero (event)" name="pagina" id="digitaPagina" title="Página" />
                                    <a class="irPagina" >Ir</a>
                                </div>
                            </div>-->
                            <div class="buscapaginacao">
                                <div class="pagina paginaAnterior"><?=$prev_link;?></div>
                                <?=$painel;?>
                                <div class="pagina paginaSeguinte"><?=$next_link;?></div>
                            </div>
                        </div>
                    </div>
                <?
                }                     
                ?>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_INC_PATH.'rodapebloco.php';?>
</div>
</body>
</html>