<?php
if(!verifica_permissao($cod_user, $nivel_user, "guiaAutomotivo"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}

require_once ADMIN_TOP_PATH.'guiaAutomotivo_topo.php';
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
$(document).ready(function()
{
    $('input[name="mostrar[]"]').click(function(){
        
        obj = $(this);
        _mostrar = obj.is(':checked') ? '1' : '0';
        _cod = obj.val();
        obj.css('display', 'none');
        obj.parent().append('<img title="Carregando" src="img/load16x16.gif" />');
        
        $.ajax(
        {
            type: "POST",
            url: "ajax/ajaxGuiaMostrar.php", //URL de destino
            data:
            {
                cod: _cod,
                mostrar: _mostrar
            },
            dataType: "json", //Tipo de Retorno
            success: function(j)
            { //Se ocorrer tudo certo
                obj.css('display', '');
                obj.parent().children('img').each(function() { jQuery(this).remove() });
            }
        });
    })
	$('input[name="destaque[]"]').click(function(){
        
        obj = $(this);
        _destaque = obj.is(':checked') ? '1' : '0';
        _cod = obj.val();
        obj.css('display', 'none');
        obj.parent().append('<img title="Carregando" src="img/load16x16.gif" />');
        
        $.ajax(
        {
            type: "POST",
            url: "ajax/ajaxGuiaDestaque.php", //URL de destino
            data:
            {
                cod: _cod,
                destaque: _destaque
            },
            dataType: "json", //Tipo de Retorno
            success: function(j)
            { //Se ocorrer tudo certo
                obj.css('display', '');
                obj.parent().children('img').each(function() { jQuery(this).remove() });
            }
        });
    })
})
</script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>	
        	<td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td class="txtpreto" style="padding-left:10px">Empresa</td>
          <td width="20%" class="txtpreto">Categorias</td>
          <td width="10%" align="center" class="txtpreto">Ordem</td>
          <td width="10%" class="txtpreto" style="text-align:center;">Destaque</td>
          <td width="5%" class="txtpreto" style="text-align:center;">Mostrar</td>
          <td width="8%" align="center" class="txtpreto">A&ccedil;&otilde;es</td>
        </tr>
        <tr>
            <td colspan="6" ><hr /></td>
        </tr>	
            <!-- linha em loop INICIO-->
        <?php
        $filtroSql = '';
        $filtroSqlArray= array();        
        if($estadoGuia != '' || $cidadeGuia != '' || $catGuia != '' || $letra != '')
            $filtroSql = ' WHERE ';                
        if($estadoGuia != '')
           $filtroSqlArray[] = " ga.estado = '".$estadoGuia."' ";
        if($cidadeGuia != '')
           $filtroSqlArray[] = " ga.cidade = '".$cidadeGuia."' ";
        if($catGuia != '')
           $filtroSqlArray[] = " gr.codCat = '".$catGuia."' ";
        if($letra != '') 
           $filtroSqlArray[] = " ga.empresa LIKE '".$letra."%' ";
        if(count($filtroSqlArray) > 0)
            $filtroSql = $filtroSql." ".implode(' AND ',$filtroSqlArray);
        else
            $filtroSql = '';                                                          
		$resultado = mysql_query("SELECT ga.*, gac.categoria, gac.cod AS codCategoria FROM guiasRelacao AS gr 
                                INNER JOIN guiaAutomotivo AS ga ON ga.cod = gr.codGuia
                                INNER JOIN guiaAutomotivoCategorias AS gac ON gac.cod = gr.codCat
                                $filtroSql GROUP BY ga.cod ORDER BY ga.ordem");                                
        $linhas = mysql_num_rows($resultado);
        
        if ($linhas>0)
        {
        	for($n=0;$n<$linhas;$n++)
        	{
                #<!-- linha impar branca | linha par cinza -->
				if ( ($n/2) == (ceil($n/2)) ){
                    echo "\n  <tr>";
                }else{
                    echo  "<tr class=\"linhacinza\">";
                }
        		$tupla = mysql_fetch_assoc($resultado);
                
				echo "<td style=\"padding-left:10px;\"><strong>>&nbsp;&nbsp;</strong> ". $tupla['empresa'] ."</td>";
                
				$sqlGuiasRel = mysql_query("SELECT * FROM guiasRelacao WHERE codGuia = '{$tupla['cod']}'");
				$nGuiasRel = mysql_num_rows($sqlGuiasRel);
				
				echo "<td>"; 
					for($i=0;$i<$nGuiasRel;$i++)
					{
						$tpGuiasRel = mysql_fetch_assoc($sqlGuiasRel);
				
						$sqlGuiaCategorias = mysql_query("SELECT * FROM guiaAutomotivoCategorias WHERE cod = '{$tpGuiasRel['codCat']}'");
						$tpGuiaCategorias = mysql_fetch_assoc($sqlGuiaCategorias);
					
						echo $tpGuiaCategorias['categoria']."<br>";
					}
				echo "</td>";
        		?>
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=3&subid=5&cod=<?=$tupla['cod'];?>" class="botaoDourado"><?=$tupla['ordem'];?></a>
                </td>
                <td align="center">
                    <input type="checkbox" name="destaque[]" id="destaque" value="<?=$tupla['cod'];?>" <?=$tupla['destaque'] == 1 ? "checked='checked'" : "";?> />
                </td>
                <td align="center">
                    <input type="checkbox" name="mostrar[]" id="mostrar" value="<?=$tupla['cod'];?>" <?=$tupla['mostrar'] == 1 ? "checked='checked'" : "";?> />
                </td>
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=3&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado">&nbsp;Editar&nbsp;</a>
                    <a onclick="return confirm('Tem certeza que deseja excluir esse registro?');" href="http://<?=ADMIN_URL;?>/guiaAutoMotivo/guiaAutoMotivo_apaga.php?cod=<?=$tupla['cod'];?>">&nbsp;&nbsp;X&nbsp;&nbsp;</a>
                </td>
        		<?
        		echo "</tr>";
        	}
        }
        else
        {
        	echo "<tr><td class=\"texto\" colspan='5'>Nenhum Registro Encontrado</td></tr>";
        }	
        
        ?>
    </table>
