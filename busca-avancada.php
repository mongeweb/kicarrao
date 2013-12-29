<?php require_once 'configRoot.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="pt-br" xmlns:fb="http://ogp.me/ns/fb#" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php require_once PROJECT_PATH.'inc/head.php';
        require_once PROJECT_INC_PATH."publicidade.php";
    ?>
    <script>
    $(document).ready(function()
    {
        $('#tipo').change(function()
        {
            if($(this).val())
            {
                $('#marcaAvancada').hide();
                $('.carregandoMarca').show();
                
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxMarca.php",
                    data:
                    {
                        cod: $(this).val()
                    
                    },
                    dataType: "json", 
                    success: function(j)
                    { 
                        var options = '<option value="">-</option>';
                        var separador = 0;		
                        for (var i = 0; i < j.length; i++) 
                        {
                            if(separador == 0 && j[i].destaque == 0)
    						{
    							options += '<option value="" disabled="disabled">&nbsp;</option>';
    							separador = 1;
    						}
                            options += '<option value="' + j[i].cod + '">' + j[i].marca + '</option>';
                        }	
                        $('#marcaAvancada').html(options).show();
                        $('.carregandoMarca').hide();
                        $('#modeloAvancada').html('<option value="">-</option>');
                        $('#versaoAvancada').html('<option value="">-</option>');
                    }
                });              
            }
            else
            {
                $('#marcaAvancada').html('<option value="">-</option>');
                $('#modeloAvancada').html('<option value="">-</option>');
                $('#versaoAvancada').html('<option value="">-</option>');
            }
        })
        $('#marcaAvancada').change(function()
        {
            if($(this).val())
            {
                $('#modeloAvancada').hide();
                $('.carregandoModelo').show();
                
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxModelo.php",
                    data:
                    {
                        cod: $(this).val()
                    
                    },
                    dataType: "json", 
                    success: function(j)
                    { 
                        var options = '<option value="">-</option>';	
                        for (var i = 0; i < j.length; i++) 
                        {
                            options += '<option value="' + j[i].cod + '">' + j[i].modelo + '</option>';
                        }	
                        $('#modeloAvancada').html(options).show();
                        $('.carregandoModelo').hide();
                        $('#versaoAvancada').html('<option value="">-</option>');
                    }
                });              
            }
            else
            {
                $('#modeloAvancada').html('<option value="">-</option>');
                $('#versaoAvancada').html('<option value="">-</option>');
                
            }
        })
        
        $('#modeloAvancada').change(function()
        {
            if($(this).val())
            {
                $('#versaoAvancada').hide();
                $('.carregandoVersao').show();
                
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxVersao.php",
                    data:
                    {
                        cod: $(this).val()
                    
                    },
                    dataType: "json", 
                    success: function(j)
                    { 
                        var options = '<option value="">-</option>';	
                        for (var i = 0; i < j.length; i++) 
                        {
                            options += '<option value="' + j[i].cod + '">' + j[i].versao + '</option>';
                        }	
                        $('#versaoAvancada').html(options).show();
                        $('.carregandoVersao').hide();
                    }
                });              
            }
            else
            {
                $('#versaoAvancada').html('<option value="">-</option>');
                
            }
        })
        
        $('#estadoAvancada').change(function()
        {
            if($(this).val())
            {                
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxCidadeAvancada.php",
                    data:
                    {
                        estado: $(this).val()
                    
                    },
                    dataType: "json", 
                    success: function(j)
                    { 
                        var options = '<option value="">-</option>';	
                        for (var i = 0; i < j.length; i++) 
                        {
                            options += '<option value="' + j[i].cod + '">' + j[i].cidade + '</option>';
                        }	
                        $('#cidadeAvancada').html(options).show();
                    }
                });              
            }
            else
            {
                $('#cidadeAvancada').html('<option value="">-</option>');
                
            }
        })
        
        $('#anoAvancadaInicial').change(function()
        {
            if($(this).val())
            {
                $('#anoAvancadaFinal').hide();
                //$('#carregandoAnoModelo').show();
                
                $.ajax(
                {
                    type: "POST",
                    url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxAnosModelo.php",
                    data:
                    {
                        ano: $(this).val()
                    
                    },
                    dataType: "json", 
                    success: function(j)
                    { 
                        options = '';
                        for (var i = 0; i < j.length; i++) 
                        {
                            options += '<option value="' + j[i].ano + '">' + j[i].ano + '</option>';
                        }	
                        $('#anoAvancadaFinal').html(options).show();
                        //$('#carregandoAnoModelo').hide();
                    }
                });              
            }
            else
            {
                $('#anoAvancadaFinal').html('<option value="">-</option>');
            }
        })
    })
    </script>
</head>

<body>
<div class="mestre">
	<?php require_once PROJECT_PATH.'inc/topo.php';?>
    <?php require_once PROJECT_PATH.'inc/menu.php';?>
    <div class="ofertabloco">
        <div class="centroinside">
            <div class="breadcrumb">
                <a href="#">Home</a>&nbsp; &gt; &nbsp;<span>Busca Avançada</span>
            </div>
        </div>
    </div>
    <div class="centro">
    	<div class="centroinside">
            <div class="planobloco">
                <div class="avancadabloco">
                    <?
                    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/' : sslRedir().PROJECT_URL.'/busca.php';
                    ?>
                    <form name="buscaAvancadaForm" id="buscaAvancadaForm" method="get" action="<?=$link;?>" enctype="application/x-www-form-urlencoded">
                        <div class="avancadatitulogeral">Dados do Veículo</div>
                        <div class="buscafiltro">
                            <div class="filtro">
                                <input type="radio" checked="true" class="uncheck" name="filtroBusca" id="filtroBuscaRevenda" value="2" title="Selecionar filtro" />
                                <span>Revendas</span>
                            </div>
                            <div class="filtro">
                                <input type="radio" class="uncheck" name="filtroBusca" id="filtroBuscaRevenda" value="1" title="Selecionar filtro" />
                                <span>Particulares</span>
                            </div>
                            <div class="filtro">
                                <input type="radio" class="uncheck" name="filtroBusca" id="filtroBuscaAmbos" value="3" title="Selecionar filtro" />
                                <span>Ambos</span>
                            </div>
                        </div>
                        <div class="avancadaleft">
                            <div class="inputbloco">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" id="tipo" title="Tipo" class="selectavancado">
                                    <option value="">-</option>
                                    <?php
                                        $conexao = conexao();
                                    	$qTipos = mysql_query("SELECT * FROM tipoVeiculo");
                                        $nTipos = mysql_num_rows($qTipos);
                                        for($x = 0;$x < $nTipos;$x++)
                                        {
                                            $tpTipos = mysql_fetch_assoc($qTipos);
                                    ?>
                                            <option value="<?=$tpTipos['cod'];?>"><?=$tpTipos['tipoVeiculo'];?></option>
                                    <?php
                                    	}
                                        mysql_close();
                                    ?>
                                </select>
                            </div>
                            <div class="inputbloco">
                                <label for="marcaAvancada">Marca</label>
                                <span class="carregandoMarca" style="color:#666;display:none;">Aguarde, carregando...</span>
                                <select class="selectavancado" name="marca" id="marcaAvancada" title="Marca">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div class="inputbloco">
                                <label for="modeloAvancada">Modelo</label>
                                <span class="carregandoModelo" style="color:#666;display:none;">Aguarde, carregando...</span>
                                <select class="selectavancado" name="modelo" id="modeloAvancada" title="Modelo">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div class="inputbloco">
                                <label for="versaoAvancada">Versão</label>
                                <span class="carregandoVersao" style="color:#666;display:none;">Aguarde, carregando...</span>
                                <select class="selectavancado" name="versao" id="versaoAvancada" title="Versão">
                                    <option value="">-</option>
                                </select>
                            </div>
                            
                            
                            <!--
                            <div class="inputbloco">
                                <label for="motorAvancada">Motor</label>
                                <select class="selectavancado" name="motorAvancada" id="motorAvancada" title="Motor">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <br class="clear" />
                            <br class="clear" />
                            <br class="clear" />-->
                            
                            <div class="inputbloco margintop40">
                                <div class="inputleft">
                                    <label for="kmAvancadaInicial">Quilometragem</label>
                                    <input type="text" onkeypress="return verificaNumero(event)" class="inputavancado" name="km" id="kmAvancadaInicial" title="Quilometragem" />
                                        
                                </div>
                                
                                <!--<div class="inputleft">
                                    <label for="kmAvancadaFinal" class="buscasepara">a</label>
                                    <select class="selectpequenobusca" name="kmAvancadaFinal" id="kmAvancadaFinal" title="Quilometragem">
                                        <option value="">-</option>
                                    </select>
                                </div>-->
                            </div>
                            
                            <div class="inputbloco">
                                <label for="combustivelAvancada">Combustível</label>
                                <select class="selectavancado" name="combustivel" id="combustivelAvancada" title="Combustível">
                                    <option value="" >-</option>
                                    <option value="1" >Gasolina</option>
                                    <option value="2" >Álcool</option>
                                    <option value="3" >Flex</option>
                                    <option value="4" >Gás - GNV</option>
                                    <option value="5" >Diesel</option>
                                    <option value="6" >Biodiesel</option>
                                    <option value="7" >Eletricidade</option>
                                </select>
                            </div>
                            
                            <div class="inputbloco">
                                <label for="portasAvancada">Portas</label>
                                <input type="text" onkeypress="return verificaNumero(event)" class="inputavancado" name="portas" id="portasAvancada" title="Portas" />
                            </div>
                            
                            <div class="inputbloco">
                                <label for="corAvancada">Cor</label>
                                <input type="text" name="cor" id="cor" title="Cor" />
                            </div>
                            <div class="inputbloco">
                                <label>&nbsp;</label>
                                <input type="checkbox" name="apenasFoto" id="apenasFoto" title="Ver somente ofertas com foto" value="1" />
                                <label class="avancadacheckmaior" for="apenasFoto">Ver somente ofertas com foto</label>
                            </div>
                            <br class="clear" />
                            <br class="clear" />
                            
                            <div class="avancadatitulogeral">Dados de Localização</div>
                            <!--
                            <div class="inputbloco">
                                <label for="paisAvancada">País</label>
                                <select class="selectavancado" name="paisAvancada" id="paisAvancada" title="País">
                                    <option value="">-</option>
                                </select>
                            </div>
                            -->
                            <div class="inputbloco">
                                <label for="estadoAvancada">Estado</label>
                                <select class="selectavancado" name="estado" id="estadoAvancada" title="Estado">
                                    <option value="">-</option>
                                    <?
                                    $conexao = conexao();
                                    $sqlEstados = mysql_query("SELECT estado FROM clientes WHERE situacao = '1' AND estado != '' GROUP BY estado ORDER BY estado");
                                    $numEstados = mysql_num_rows($sqlEstados);
                                    for($x = 0;$x < $numEstados;$x++)
                                    {
                                        $tpEstados = mysql_fetch_assoc($sqlEstados);
                                    ?>
                                        <option value="<?=$tpEstados['estado'];?>"><?=$tpEstados['estado'];?></option>
                                    <?
                                    }
                                    mysql_close();
                                    ?>
                                </select>
                            </div>
                            
                            <div class="inputbloco">
                                <label for="cidadeAvancada">Cidade</label>
                                <select class="selectavancado" name="cidade" id="cidadeAvancada" title="Cidade">
                                    <option value="">-</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="avancadaright">
                            <div class="inputbloco">
                                <div class="inputleft">
                                    <label for="anoAvancadaInicial">Ano</label>
                                    <select class="selectpequenobusca" name="anoInicial" id="anoAvancadaInicial" title="Quilometragem">
                                        <option value="">-</option>
                                        <?php
                                        $anosRange = range(date("Y"),1900);
                                        foreach($anosRange as $k => $ano)
                                        {
                                            ?>
                                            <option value="<?=$ano;?>"><?=$ano;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="inputleft">
                                    <label for="anoAvancadaFinal" class="buscasepara" style="font-size: 10px; margin-left:9px; margin-right:9px;">a</label>
                                    <select class="selectpequenobusca" name="anoFinal" id="anoAvancadaFinal" title="Quilometragem">
                                        <option value="">-</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="inputbloco">
                                <div class="inputleft">
                                    <label for="precoAvancadaInicial">Preço</label>
                                    <input style="width: 56px;" onkeypress="return verificaNumero(event)" type="text" name="precoInicial" id="precoInicial" title="Preço" />
                                    <span style="float: none;">&nbsp;&nbsp;a&nbsp;&nbsp;</span>
                                    <input style="width: 56px;" onkeypress="return verificaNumero(event)" type="text" name="precoFinal" id="precoFinal" title="Preço" />
                                </div>
                            </div>
                            
                            <!--<div class="inputbloco">
                                <label for="categoriaAvancada">Categoria</label>
                                <select class="selectavancado" name="categoriaAvancada" id="categoriaAvancada" title="Categoria">
                                    <option value="">-</option>
                                </select>
                            </div>-->
                            
                            <div class="inputbloco margintop73">
                                <label for="placaAvancada">Placa</label>
                                <input type="text" class="inputavancado" name="placa" id="placaAvancada" title="Placa" maxlength="7" />
                                <br class="clear" />
                                <label>&nbsp;</label>
                                <span>(EX.: <em>"xyz1234"</em>)</span>
                            </div>
                            
                            <!--<div class="inputbloco">
                                <label for="anoAvancadaInicial">Câmbio</label>
                                <div class="inputleft">
                                    <input type="checkbox" name="cambioAutomatico" id="cambioAutomatico" title="Automático" />
                                    <label class="avancadacheckmenor" for="cambioAutomatico">Automático</label>
                                </div>
                                <div class="inputleft">
                                    <input type="checkbox" name="cambioManual" id="cambioManual" title="Manual" />
                                    <label class="avancadacheckmenor" for="cambioManual">Manual</label>
                                </div>
                            </div>
                            
                            <div class="inputbloco">
                                <label for="anoAvancadaInicial">Procedência</label>
                                <div class="inputleft">
                                    <input type="checkbox" name="procedenciaNacional" id="procedenciaNacional" title="Nacional" />
                                    <label class="avancadacheckmenor" for="procedenciaNacional">Nacional</label>
                                </div>
                                <div class="inputleft">
                                    <input type="checkbox" name="procedenciaImportado" id="procedenciaImportado" title="Importado" />
                                    <label class="avancadacheckmenor" for="procedenciaImportado">Importado</label>
                                </div>
                            </div>-->
                            
                            <div class="avancadaenviar">
                                <input type="submit" <?/*name="enviarDadosAnuncio"*/;?> id="enviarDadosAnuncio" title="Buscar" value="&nbsp;" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="noticiapropaganda">
                    <?php
                    imprimeBannerLateralBuscaAvancada();
                    imprimeBannerLateralPequenoBuscaAvancada();
                    ?>
                </div>
            </div>
    	</div>
    </div>
    <?php require_once PROJECT_PATH.'inc/rodapebloco.php';?>
</div>
</body>
</html>