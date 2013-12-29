<script>
function tipoBusca(_this,_val)
{
    _val = _val || '';
    console.log(_val);
    if(_this.val())
        {
            $('#marcaBuscaRefinada').hide();
            $('.carregandoMarca').show();
            
            $.ajax(
            {
                type: "POST",
                async: false,
                url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxMarca.php",
                data:
                {
                    cod: _this.val()
                
                },
                dataType: "json", 
                success: function(j)
                { 
                    var options = '<option value="">-</option>';	
                    for (var i = 0; i < j.length; i++) 
                    {
                        options += '<option value="' + j[i].cod + '" '+(_val == j[i].cod ? 'selected="true"' : '')+'>' + j[i].marca + '</option>';
                    }	
                    $('#marcaBuscaRefinada').html(options).show();
                    $('.carregandoMarca').hide();
                    $('#modeloBuscaRefinada').html('<option value="">-</option>');
                    
                }
            });              
        }
        else
        {
            $('#marcaBuscaRefinada').html('<option value="">-</option>');
            $('#modeloBuscaRefinada').html('<option value="">-</option>');
            
        }
}

function marca(_this,_val)
{
    _val = _val || '';
    console.log(_val);
    if(_this.val())
    {
        $('#modeloBuscaRefinada').hide();
        $('.carregandoModelo').show();
        
        $.ajax(
        {
            type: "POST",
            async: false,
            url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxModelo.php",
            data:
            {
                cod: _this.val()
            
            },
            dataType: "json", 
            success: function(j)
            { 
                var options = '<option value="">-</option>';	
                for (var i = 0; i < j.length; i++) 
                {
                    options += '<option value="' + j[i].cod + '" '+(_val == j[i].cod ? 'selected="true"' : '')+'>' + j[i].modelo + '</option>';
                }	
                $('#modeloBuscaRefinada').html(options).show();
                $('.carregandoModelo').hide();
                
            }
        });              
    }
    else
    {
        $('#modeloBuscaRefinada').html('<option value="">-</option>');
    }
}

function anoInicial(_this,_val)
{
    _val = _val || '';
    console.log(_val);
    if(_this.val())
    {
        $('#anoFinalBuscaRefinada').hide();
        //$('#carregandoAnoModelo').show();
        
        $.ajax(
        {
            type: "POST",
            async: false,
            url: "<?=ssl().PROJECT_URL;?>/adm/ajax/ajaxAnosModelo.php",
            data:
            {
                ano: _this.val()
            
            },
            dataType: "json", 
            success: function(j)
            { 
                options = '';
                for (var i = 0; i < j.length; i++) 
                {
                    options += '<option value="' + j[i].ano + '" '+(_val == j[i].ano ? 'selected="true"' : '')+'>' + j[i].ano + '</option>';
                }	
                $('#anoFinalBuscaRefinada').html(options).show();
                //$('#carregandoAnoModelo').hide();
            }
        });              
    }
    else
    {
        $('#anoFinalBuscaRefinada').html('<option value="">-</option>');
    }
}
$(document).ready(function()
{
    $('#tipoBuscaRefinada').change(function()
    {
        tipoBusca($(this));
    })
    $('#marcaBuscaRefinada').change(function()
    {
        marca($(this));
    })
    
    $('#anoBuscaRefinada').change(function()
    {
        anoInicial($(this));
    })
    
    $(".order").click(function()
    {      
        _order = $(this).attr('rel');
        $('#order').val(_order);
        $('#buscaRefinada').submit();
    })
    
    tipoBusca($('#tipoBuscaRefinada'),'<?=$marcaTopo;?>');
    marca($('#marcaBuscaRefinada'),'<?=$modeloTopo;?>');
    anoInicial($('#anoBuscaRefinada'),'<?=$anoFinalTopo;?>');
})
</script>
<div class="buscarevendatopo">
    <?
    $link = $MG_MR_Settings['active'] ? sslRedir().PROJECT_URL.'/busca/' : sslRedir().PROJECT_URL.'/busca.php';
    ?>
    <form name="buscaRefinada" id="buscaRefinada" method="get" action="<?=$link;?>">
        <input type="hidden" name="q" class="buscarTetxo" id="buscar" title="Buscar" value="<?=$qTopo;?>" />
        <div class="buscaleft">
            <div class="buscafiltro">
                <div class="filtro">
                    <input type="radio" checked="true" name="filtroBusca" id="filtroBuscaRevenda" value="2" <?=$filtroBuscaTopo == 2 ? "checked='true'" : '';?> title="Selecionar filtro" class="uncheck" />
                    <label for="filtroBusca">Revendas</label>
                </div>
                <div class="filtro">
                    <input type="radio" name="filtroBusca" id="filtroBuscaParticular" value="1" <?=$filtroBuscaTopo == 1 ? "checked='true'" : '';?> title="Selecionar filtro" class="uncheck" />
                    <label for="filtroBusca">Particulares</label>
                </div>
                <div class="filtro">
                    <input type="radio" name="filtroBusca" id="filtroBuscaAmbos" value="3" <?=$filtroBuscaTopo == 3 ? "checked='true'" : '';?> title="Selecionar filtro" class="uncheck" />
                    <label for="filtroBusca">Ambos</label>
                </div>                
            </div>
            <div class="inputbloco">
                <label for="tipoBuscaRefinada">Tipo</label>
                <select class="selectgrandebusca" name="tipo" id="tipoBuscaRefinada" title="Tipo">
                    <option value="">-</option>
                    <?php
                        $conexao = conexao();
                    	$qTipos = mysql_query("SELECT * FROM tipoVeiculo");
                        $nTipos = mysql_num_rows($qTipos);
                        for($x = 0;$x < $nTipos;$x++)
                        {
                            $tpTipos = mysql_fetch_assoc($qTipos);
                    ?>
                            <option value="<?=$tpTipos['cod'];?>" <?=$tipoTopo == $tpTipos['cod'] ? "selected='true'" : '';?>><?=$tpTipos['tipoVeiculo'];?></option>
                    <?php
                    	}
                        mysql_close();
                    ?>
                </select>
            </div>
            <div class="inputbloco">
                <label for="marcaBuscaRefinada">Marca</label>
                <span class="carregandoMarca" style="color:#666;display:none;">Aguarde, carregando...</span>
                <select class="selectgrandebusca" name="marca" id="marcaBuscaRefinada" title="Marca">
                    <option value="">-</option>
                </select>
            </div>
        </div>
        <div class="buscaright">
            <div class="inputbloco">
                <label for="modeloBuscaRefinada">Modelo</label>
                <span class="carregandoModelo" style="color:#666;display:none;">Aguarde, carregando...</span>
                <select class="selectgrandebusca" name="modelo" id="modeloBuscaRefinada" title="Modelo">
                    <option value="">-</option>
                </select>
            </div>
            <div class="inputbloco">
                <div class="inputleft">
                    <label for="anoInicialBuscaRefinada">Ano</label>
                    <select class="selectpequenobusca" name="anoInicial" id="anoBuscaRefinada" title="Ano">
                        <option value="">-</option>
                        <?php
                        $anosRange = range(date("Y"),1900);
                        foreach($anosRange as $k => $anoTopo)
                        {
                            ?>
                            <option value="<?=$anoTopo;?>" <?=$anoInicialTopo == $anoTopo ? "selected='true'" : '';?>><?=$anoTopo;?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="inputleft">
                    <label for="anoFinalBuscaRefinada" class="buscasepara">a</label>
                    <select class="selectpequenobusca" name="anoFinal" id="anoFinalBuscaRefinada" title="Ano">
                        <option value="">-</option>
                    </select>
                </div>
            </div>
            <div class="inputbloco">
                <div class="inputleft">
                    <label for="precoInicialBuscaRefinada">Preço</label>
                    <input onkeypress="return verificaNumero(event)" type="text" name="precoInicial" id="precoInicial" title="Preço" style="width: 59px;" />
                    <label for="anoFinalBuscaRefinada" class="buscasepara" style="float: none;margin: 0px">a</label>
                    <input onkeypress="return verificaNumero(event)" type="text" name="precoFinal" id="precoFinal" title="Preço" style="width: 59px;" />
                </div>
            </div>
        </div>
        <input type="hidden" name="order" id="order" value="" />
        <div class="buscarevendaenviar">
            <input type="submit" <?/*name="enviarBuscaRevenda"*/;?> id="enviarBuscaRevenda" title="Buscar" value="&nbsp;" />
        </div>
    </form>
</div>