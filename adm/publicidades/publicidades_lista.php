<?php
if(!verifica_permissao($cod_user, $nivel_user, "publicidades"))
{
	echo " <script language=\"JavaScript1.2\"> \n";
	echo " <!-- \n";
	echo " alert(\"Permissao negada!\");\n";
	echo " location.replace('principal.php'); \n";
	echo " //--> \n";
	echo " </script> \n";
	
	die();
}
require_once ADMIN_TOP_PATH.'publicidades_topo.php';
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
            url: "ajax/ajaxPubliMostrar.php", //URL de destino
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
          <td class="txtpreto" style="padding-left:10px">Empresa</td>
          <td width="25%" class="txtpreto" style="text-align:center;">Pagina</td>
          <td width="30%" class="txtpreto" style="text-align:center;">Tipo</td>
          <td width="5%" class="txtpreto" style="text-align:center;">Mostrar</td>
          <td width="8%" align="center" class="txtpreto">A&ccedil;&otilde;es</td>
        </tr>
        <tr>
            <td colspan="5" ><hr /></td>
        </tr>	
            <!-- linha em loop INICIO-->
        <?php
        $resultado = mysql_query("SELECT p.*, pt.tipo, pp.pagina FROM publicidades AS p
                                  INNER JOIN publiTipos AS pt ON pt.cod = p.codTipo
                                  INNER JOIN publiPaginas AS pp ON pp.cod = p.codPagina
                                  ORDER BY p.codPagina, pt.cod ");
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
        
                echo "<td style=\"padding-left:10px;\"><strong>>&nbsp;&nbsp;</strong> ". $tupla['empresa'] ."</td>";
                echo "<td align=\"center\" >". $tupla['pagina'] ."</td>";
                echo "<td align=\"center\" >". $tupla['tipo'] ."</td>";
        		?>
                <td align="center">
                    <input type="checkbox" name="mostrar[]" id="mostrar" value="<?=$tupla['cod'];?>" <?=$tupla['mostrar'] == 1 ? "checked='checked'" : "";?> />
                </td>
                <td align="center">
                    <a href="http://<?=ADMIN_URL;?>/principal.php?id=11&subid=3&cod=<?=$tupla['cod'];?>" class="botaoDourado">&nbsp;Editar&nbsp;</a>
                    <a onclick="return confirm('Tem certeza que deseja excluir esse registro?');" href="http://<?=ADMIN_URL;?>/publicidades/publicidades_apaga.php?cod=<?=$tupla['cod'];?>">&nbsp;&nbsp;X&nbsp;&nbsp;</a>
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
