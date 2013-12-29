<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'))
{
    require_once '../../configRoot.php';
    $codPlano = isset($_POST['cod']) ? $_POST['cod'] : '';
    $campo = isset($_POST['campo']) ? $_POST['campo'] : '';
    $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
    $valor = $campo == 'valor' ? (float)trim($valor) : $valor;
    $sql = "UPDATE planosRevenda SET $campo = '$valor' WHERE cod = '$codPlano'";
    $erro = 0;
    for($a=0;$a<5;$a++)
    {
        $q = mysql_query($sql);
        if($q)
        {
            break;
        }
        else
        {
            $erro = 1;
        }
    }
    die(json_encode(array("erro" => (int)$erro)));
    
}
if(!verifica_permissao($cod_user, $nivel_user, "planos"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'planosRev_topo.php';
?>
<script type="text/javascript">
function verificaNumero(e)
{
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
   	    if (tecla==8 || tecla==0) return true;
        else  return false;
    }
}
function ajaxPlano(_cod,_val,_campo)
{
    _ajax = $.ajax(
            {
                type: "POST",
                async: false,
                url: "http://<?=ADMIN_URL;?>/planosRev/planosRev_lista.php", //URL de destino
                data:
                {
                    cod: _cod,
                    valor: _val,
                    campo: _campo
                },
                dataType: "json"
            }).done(function(_obj)
            {
                _erro = parseInt(_obj.erro);
            });
    return _erro;
    
}
$(document).ready(function()
{
    $("#planosLista input.input[type='text']").blur(function()
    {
        _input = $(this);
        _type = _input.attr('type');
        _input.css('display', 'none');
        _input.parent().append('<img id="load" title="Carregando" src="img/load16x16.gif" />');
        _cod = _input.attr('rel');
        _campo = _input.parent().parent().attr('rel');
        _title = _input.attr("title");
        _val = _input.val();
        _val = _campo == 'valor' ? _val.replace("R$ ","") : _val;
        _ret = ajaxPlano(_cod,_val,_campo);
        
        if(_ret == 1)
        {
            alert("Erro ao atualizar \""+_title+"\"");
            document.location.reload();
        }
        
        _input.show().parent().find('img#load').remove();
        
    })
    $("#planosLista input.input[type='checkbox']").change(function()
    {
        _input = $(this);
        _type = _input.attr('type');
        _input.css('display', 'none');
        _input.parent().append('<img id="load" title="Carregando" src="img/load16x16.gif" />');
        _cod = _input.attr('rel');
        _campo = _input.parent().parent().attr('rel');
        _title = _input.attr("title");
        _val = _input.is(":checked") ? 1 : 0;
        _ret = ajaxPlano(_cod,_val,_campo);
        if(_ret == 1)
        {
            alert("Erro ao atualizar \""+_title+"\"");
            document.location.reload();
        }
        _input.show().parent().find('img#load').remove();
        
    })
    $("input.valor").maskMoney({showSymbol:true, symbol:"R$ ", decimal:".", thousands:""});
    
})
</script>
<style>
.tr > td:first-child{
    text-align: left;
}
.tr{
    text-align: center;
}
.input {
    height: 15px;
    margin: 2px auto;
    text-align: center;
}
.input[type='text'] {
    width: 80px;
}
.input[type='checkbox'] {
    
}
</style>
<?
$sqlTipos = mysql_query("SELECT * FROM planosRevenda GROUP BY codTipoVeiculo");
$numTipos = mysql_num_rows($sqlTipos);
for($xx = 0;$xx < $numTipos;$xx++)
{
    $tpTipos = mysql_fetch_assoc($sqlTipos);
    $sqlTipoVeiculo = mysql_query("SELECT * FROM tipoVeiculo WHERE cod = '{$tpTipos['codTipoVeiculo']}'");
    $tpTipoVeiculo = mysql_fetch_assoc($sqlTipoVeiculo);
    $tipo = $tpTipoVeiculo['tipoVeiculo'];
?>
    <table id="planosLista" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>	
        	<td colspan="6" style="font-size: 22px;"><b><?=$tipo;?></b></td>
        </tr>
        <?php
        $qPlanos = mysql_query("SELECT * FROM planosRevenda WHERE codTipoVeiculo = '{$tpTipos['codTipoVeiculo']}' ORDER BY ordem");
        $nPlanos = mysql_num_rows($qPlanos);
        $planos = array();
        while($tpPlano = mysql_fetch_assoc($qPlanos))
        {
            $planos[$tpPlano['cod']] = $tpPlano;
        }
        /*
        echo "<pre>";
        var_dump($planos);
        echo "</pre>";
        //*/
        ?>
        <tr>
          <th style="width: 25%;text-align: left;">&nbsp;</th>
          <?php
          foreach($planos as $val)
            echo "<th style=\"width: 18%;text-align: center;\">{$val['plano']}</th>"
          ?>
        </tr>
        <tr>
            <td colspan="6"><hr /></td>
        </tr>	
        <?php
        $a = 0; 
        if ($nPlanos>0)
        {
        	?>
                <tr rel='tempo' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Quantidade de ofertas</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input" type="text" onkeypress="return verificaNumero(event);" value="<?=$val['tempo'];?>" title="Tempo de veiculação/Plano <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
                <tr rel='destaqueCapa' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Nº de ofertas em destaque na capa do site</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input" type="checkbox" <?=$val['destaqueHome'] == 1 ? 'checked' : '';?> value="1" title="Destaque na capa do site/Plano <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
                <tr rel='destaqueLista' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Nº de ofertas em destaque na lista de resultados</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input" type="checkbox" <?=$val['destaqueLista'] == 1 ? 'checked' : '';?> value="1" title="Destaque na lista de resultados/Plano <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
                <tr rel='destaqueCapa' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Nº de ofertas em super destaque na capa do site</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input" type="checkbox" <?=$val['superDestaqueHome'] == 1 ? 'checked' : '';?> value="1" title="Destaque na capa do site/Plano <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
                <tr rel='destaqueLista' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Nº de ofertas em super destaque na lista de resultados</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input" type="checkbox" <?=$val['superDestaqueLista'] == 1 ? 'checked' : '';?> value="1" title="Destaque na lista de resultados/Plano <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
                <tr rel='nFotos' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Número de fotos por oferta</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input" type="text" onkeypress="return verificaNumero(event);" value="<?=$val['nFotos'];?>" title="Número de fotos/Plano <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
                <tr rel='alertaEmail' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Alerta por e-mail</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input" type="checkbox" <?=$val['alertaEmail'] == 1 ? 'checked' : '';?> value="1" title="Alerta por e-mail <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
                <tr rel='valor' class="tr <?=($a/2) == ceil($a/2) ? 'linhacinza' : '';?>">
                    <td>Valor</td>
                    <?php
                    foreach($planos as $k => $val)
    	            {
                    ?>
                        <td><input class="input valor" type="text" value="<?=number_format($val['valor'],2,'.','');?>" title="Valor/Plano <?=$val['plano'];?>" rel="<?=$k;?>" /></td>
                    <?php
                    }
                    $a++;
                    ?>
        		</tr>
            <?
        }
        else
        {
        	echo "<tr><td class=\"texto\" colspan='5'>Nenhum Registro Encontrado</td></tr>";
        }	
        ?>
    </table><br /><br />
<?
}
?>