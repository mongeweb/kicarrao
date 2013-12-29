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
require_once ADMIN_TOP_PATH.'guiaAutomotivoCat_topo.php';
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
            url: "ajax/ajaxGuiaCatMostrar.php", //URL de destino
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
})
</script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>	
        	<td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td class="txtpreto" style="padding-left:10px">Categoria</td>
          <td width="10%" align="center" class="txtpreto">Ordem</td>
          <td width="5%" class="txtpreto" style="text-align:center;">Mostrar</td>
          <td width="8%" align="center" class="txtpreto">A&ccedil;&otilde;es</td>
        </tr>
        <tr>
            <td colspan="5" ><hr /></td>
        </tr>	
            <!-- linha em loop INICIO-->
        <?php
        $resultado = mysql_query("SELECT * FROM guiaAutomotivoCategorias ORDER BY categoria");
        $linhas = mysql_num_rows($resultado);
        
        if ($linhas>0)
        {
        	for($n=0;$n<$linhas;$n++)
        	{
        		#<!-- linha impar branca | linha par cinza -->
        		$tupla = mysql_fetch_assoc($resultado);
                if ( ($n/2) == (ceil($n/2)) )
                {
                    echo "\n  <tr>";
                }	
                else
                {
                    echo  "<tr class=\"linhacinza\">";
                }
        
                echo "<td style=\"padding-left:10px;\"><strong>>&nbsp;&nbsp;</strong> ". $tupla['categoria'] ."</td>";
        		?>
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=4&subid=5&cod=<?=$tupla['cod'];?>" class="botaoDourado"><?=$tupla['ordem'];?></a>
                </td>
                <td align="center">
                    <input type="checkbox" name="mostrar[]" id="mostrar" value="<?=$tupla['cod'];?>" <?=$tupla['mostrar'] == 1 ? "checked='checked'" : "";?> />
                </td>
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=4&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado">&nbsp;Editar&nbsp;</a>
                    <a onclick="return confirm('Tem certeza que deseja excluir esse registro? \nTodas as Guias Automotivas relaciondas a essa categoria serão apagadas!');" href="http://<?=ADMIN_URL;?>/guiaAutoMotivoCat/guiaAutoMotivoCat_apaga.php?cod=<?=$tupla['cod'];?>">&nbsp;&nbsp;X&nbsp;&nbsp;</a>
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
